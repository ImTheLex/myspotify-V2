<?php
namespace myspotifyV2\models;

require_once '../dependencies/MyModel.php';
require_once '../config/myconfig.php';

use myspotifyV2\dependencies\MyModel;

class User extends MyModel {

    protected $rules = ([
        'username'=>'required|min:3|max:40',
        'email'=>'required|min:10|max:40',
        'password'=>'required|min:5|password',
        'birth'=>'required|birthdate',
        'gender'=>'required',
    ]);

    /**
     * oldName:insertInto
     * Based on given parameters will create a new entry in users
     */
    public function createUser(array $datas){
       
        if($this->validate($datas,$this->rules)){

            $this->db->beginTransaction();
                $images = glob(MY_PLAYLIST_DEFAULT_IMAGES . '/*.jpeg');
                $imageSource = $images[rand(0,4)];
                $uniqueId = uniqid('-',true);
                $keys = array_keys($datas);
            
                $token = $datas[$keys[0]] . $uniqueId;
                $result = $this->query("INSERT INTO $this->table (username, email, `password`, birth, gender, recover_token, profile_picture) VALUES (:username, :email, :password, :birth, :gender, :recover_token, :profile_picture )",
                    [
                        "username"=>$datas[$keys[0]],
                        "email"=>$datas[$keys[1]],
                        "password"=> password_hash($datas[$keys[2]],PASSWORD_DEFAULT),
                        "birth"=>$datas[$keys[4]],
                        "gender"=>$datas[$keys[5]],
                        "recover_token"=>$token,
                        "profile_picture"=>$imageSource
                    ]);
            $this->db->commit();

            return $result;

        }         
    }

    /**
     * old: signup/doesExistuser
     * Based on a post request for sign up, will filter datas
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

            $result = $this->query("UPDATE $this->table SET `password` = :password WHERE (email =  :email)",
            [
                'email' => $user_info['email'],
                'password'=> $new_password
            ]);

            if($result === 0){
                throw new \Exception("resetPasswordFailed");
            }
            return true;
        }

    }

    /**
     * Based on an email, or a username, and an recover_token, will grant a new initiatePassword.
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

}   

