<?php
namespace myspotifyV2\models;
use myspotifyV2\dependencies\MyModel;


require_once $_SERVER['DOCUMENT_ROOT'] . '/dependencies/MyModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/myconfig.php';


class User extends MyModel {

    protected $rules = ([
        'id'=>'require|int',
        'username'=>'required|min:3|max:40',
        'email'=>'required|min:10|max:40',
        'password'=>'required|min:5|password',
        'birth'=>'required|birthdate',
        'gender'=>'required',
    ]);

    /**
     * oldName:insertInto
     * Based on given parameters will create a new entry in users
     * If user is successfully created, will return the user_id
     */
    public function createUser(array $datas){
       
        if($this->validate($datas,$this->rules)){

            $this->db->beginTransaction();
                $images = glob(MY_PLAYLIST_DEFAULT_IMAGES . '/*.jpeg');
                $imageSource = $images[rand(0,4)];
                $uniqueId = uniqid('-',true);
                $token = $datas['signUpUsername'] . $uniqueId;
                $result = $this->query("INSERT INTO $this->table (username, email, `password`, birth, gender, recover_token, profile_picture) VALUES (:username, :email, :password, :birth, :gender, :recover_token, :profile_picture )",
                    [
                        "username"=>$datas['signUpUsername'],
                        "email"=>$datas['signUpEmail'],
                        "password"=> password_hash($datas['signUpPassword1'],PASSWORD_DEFAULT),
                        "birth"=>$datas['signUpBirth'],
                        "gender"=>$datas['signUpGender'],
                        "recover_token"=>$token,
                        "profile_picture"=>$imageSource
                    ]);
            $this->db->commit();

            return $result;
        }         
    }

    /**
     * old: signup/doesExistuser
     * Based on a post request for sign up, will filter analyze username/email and id if given.
     * Returns true if the user doesn't exist.
     * @return true
     */
    public function searchUser(string $username, string $email,?int $id):true {

        $request = "SELECT id, username, email FROM $this->table WHERE (email = :email OR username = :username)";
        $params = [
            "username" => $username,
            "email" => $email,
        ];

        if ($id !== null) {
            $request .= " AND id != :id";
            $params['id'] = $id;
        }

        $result = $this->query($request, $params)->fetch(\PDO::FETCH_ASSOC);
    
        if($result){
            if($result['email'] === $email){
                var_dump($email);
                throw new \Exception("email");
            }
            if($result['username'] === $username){
                var_dump($username);
                throw new \Exception("username");
            }
        }
        return true; 
    }

    /**
     * old:getAuth
     * Based on given username and password, will search first for the given username, then will compare the password.
     * If success, authenticates the user.
     */
    public function authUser(string $userInfos, string $password){

        $result = $this->query("SELECT `password` FROM $this->table WHERE username = :username OR email = :email",[
            'username'=>$userInfos,
            'email'=>$userInfos,
        ])->fetch(\PDO::FETCH_ASSOC);

        if(!$result){
            throw new \Exception("get_auth_no_match");
        }    
        if($result && password_verify($password, $result['password'])) {
            return $this->getUserInfos($userInfos,null);
        }
        else{
            throw new \Exception("get_auth_wrong_password");
        }
    }

    /**
     * Based on an username or an email, will fetch all the userdatas
     */
    public function getUserInfos(?string $userInfos,?string $recover_token):array {

        $result = $this->query("SELECT * FROM $this->table WHERE username = :username OR email = :email OR id = :id OR recover_token = :recover_token",[
            'id'=>$userInfos,
            'username'=>$userInfos,
            'email'=>$userInfos,
            'recover_token'=>$recover_token,
        ])->fetch(\PDO::FETCH_ASSOC);

        if(!$result){
            throw new \Exception("Aucune correspondance.");
        }
        return $result;
    }

    /**
     * Based on user_id will return username.
     */
    public function getUsername(int $user_id){
        $result = $this->query("SELECT username FROM $this->table WHERE id = :id",
        [
            'id' => $user_id,
        ])->fetch(\PDO::FETCH_ASSOC);
        return $result['username'];
    }

    /**
     * Based on userdatas will update the userdatas only if they match end validators.
     */
    public function updateUser(array $userdatas,array $datas,?array $files) {
        
        if($this->searchUser($datas['usernameUpdate'],$datas['userEmailUpdate'],$userdatas['id'])){

            if($this->validate($datas,$this->rules())){
                    
                $this->db->beginTransaction();
                    $keys = array_keys($datas);
    
                    $result = $this->query("UPDATE $this->table SET  username = :username, email = :email, birth = :birth,  gender = :gender WHERE id = :id",
                    [
                        'username'=> $datas[$keys[0]],
                        'email' => $datas[$keys[1]],
                        ":birth" => $datas[$keys[2]],
                        ":gender" => $datas[$keys[3]],
                        "id" => $userdatas['id']
                    ]);

                $this->db->commit();

                if(!empty($files) && ($files['userImgUpdate']['size'] > 0)){
                    $extension = pathinfo($_FILES['userImgUpdate']['name'], PATHINFO_EXTENSION);
                    $fileName = $userdatas['id'] . '-profile-picture';
                    $uploadDir = ".." . MY_RELATIVE_PATH_TO_USER_IMAGE;
                    $uploadFile = $uploadDir . $fileName . '.'.$extension;

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
            
                    array_map('unlink', glob($uploadDir . $fileName . '.*'));
                    move_uploaded_file($_FILES['userImgUpdate']['tmp_name'], $uploadFile);
                    $this->query("UPDATE $this->table SET profile_picture = :profile_picture WHERE id = :id",
                    [
                        'profile_picture'=> $uploadFile,
                        "id" => $userdatas['id']
                    ]);
                    $result = true;
                }
                
                return $result;
    
            }
       
        };
            
    }

    /**
     * Based on an email, will set a new password for the given user_email.
     * @return Void An update doesn't return de datas, only the number of rows affected.
     */
    public function initiatePassword (array $user_info, string $new_password){

        if ($this->validate(['password' => $new_password],$this->rules)){

            $this->db->beginTransaction();

                $result = $this->query("UPDATE $this->table SET `password` = :password WHERE (email =  :email)",
                [
                    'email' => $user_info['email'],
                    'password'=> password_hash($new_password,PASSWORD_DEFAULT)
                ]);

                if($result === 0){
                    throw new \Exception("reset_password_failed");
                }
            $this->db->commit();
            return true;
        }

    }

    /**
     * Based on an email, or a username, and an recover_token, will grant a new initiatePassword.
     * It could be dangerous as it doesn't verify if the requester is the owner of the account.
     * It only relies on "yes i have a token and I know that address"
     */
    public function resetPassword(string $userInfo,string $recover_token){

        $result = $this->query("SELECT email FROM $this->table WHERE (username = :username OR email = :email) AND recover_token = :recover_token",
        [
            'username' => $userInfo,
            'email' => $userInfo,
            'recover_token' => $recover_token
        ])->fetch(\PDO::FETCH_ASSOC);
            
        if(!$result){
            throw new \Exception("reset_password");
        }
        return $result;  
    }

    /**
     * Deletes the given user and all of its datas.
     * It's a one shot, no warning.
     */
    public function deleteUser($user_id){

        if($this->validate(['id' => $user_id],$this->rules())){

            $result = $this->query("SELECT `id` FROM playlists WHERE `user_id` = :id",
            [
                'id' => $user_id
            ])->fetchAll(\PDO::FETCH_ASSOC);


            if($result){

                $ids = array_map(function($row) { return $row['id']; }, $result);
                $placeholders = implode(',', array_fill(0, count($result), '?'));
                $result = $this->query("DELETE FROM playlists WHERE id IN ($placeholders)",$ids);

                if($result){

                    $pictures = [];
                    foreach ($ids as $id) {
                        $pictures = array_merge($pictures, glob($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'public' . DIRECTORY_SEPARATOR . 'ressources' . DIRECTORY_SEPARATOR . 'playlists_image' . DIRECTORY_SEPARATOR . $id . '*'));
                    }
                    foreach($pictures as $picture){
                        unlink($picture);
                    }
                }
            }
              
            $result = $this->query("DELETE FROM $this->table WHERE id = :id",
            [
                'id' => $user_id
            ]);
            if($result){
                
                unlink(glob($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'public' . DIRECTORY_SEPARATOR . 'ressources' . DIRECTORY_SEPARATOR . 'users_image' . DIRECTORY_SEPARATOR . $user_id . '*')[0] ?? '');
              
                return $result;

            }
        }
    }

    public function setNewUserRole($user_id,$role) {

        $result = $this->query("UPDATE $this->table SET `role` = :role WHERE (`id` = :id)",
        [
            'role' => $role,
            'id' => $user_id,
        ]);
        return $result; 

    }

}   

