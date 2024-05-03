<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/myconfig.php';


class User {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Based on a recover_token saved in client should allow reconnect.
     */
    public function authWithToken($login_token){
        $request = $this->db->prepare("SELECT * FROM users WHERE login_token = :login_token");
        $request->bindValue('login_token',$login_token);
        $request->execute();
        $result = $request->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            throw new Exception("auth_with_token_login_token");
        }
        return $result;
    }

    
    /**
     * Based on an email, will set a new password for the given user_email.
     * @return Void An update doesn't return de datas, only the number of rows affected.
     */
    public function initiatePassword (array $user_info, string $new_password){

        $request = $this->db->prepare("UPDATE users SET `password` = :password WHERE (email =  :email)");
        $request->bindValue(":email", $user_info['email']);
        $request->bindValue(":password", $new_password);
        $request->execute();
        $result = $request->rowCount();
        if($result === 0){
            throw new Exception("intiate_password_email");
        }
        return true;
    }
    /**
     * Based on an email, or a username, and an recover_token, will grant a new initiatePassword.
     */
    public function resetPassword(string $userInfo,string $recover_token){

        $request = $this->db->prepare("SELECT email FROM users WHERE (username = :username OR email = :email) AND recover_token = :recover_token");
        $request->bindValue(':username', $userInfo);
        $request->bindValue(':email', $userInfo);
        $request->bindValue(':recover_token', $recover_token);
        $request->execute();
        $result = $request->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            throw new Exception("reset_password");
        }

        return $result;
    
    }

    /**
     * Based on an username or an email, will fetch all the userdatas
     */
    public function getUserInfos(?string $username,?string $recover_token):array {

        $request = $this->db->prepare("SELECT * FROM users WHERE username = :username OR email = :username2 OR recover_token = :recover_token");
        $request->bindValue(':username', $username);
        $request->bindValue(':username2', $username);
        $request->bindValue(':recover_token', $recover_token);
        $request->execute();

        $result = $request->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            throw new Exception("Aucune correspondance.");
        }

        return $result;

    }
  
    /**
     * Based on given username and password, will search first for the given username, then will compare the password.
     */
    public function getAuth($nomUtilisateur, $motDePasse){

        $request = $this->db->prepare("SELECT `password` FROM users WHERE username = :username1 OR email = :username2");
        $request->bindParam(':username1', $nomUtilisateur);
        $request->bindParam(':username2', $nomUtilisateur);
        $request->execute();
    
        $result = $request->fetch(PDO::FETCH_ASSOC);

        // var_dump($result);
        // exit;
        if(!$result){
            // Aucune correspondance ni email ni username
            throw new Exception("get_auth_no_match");
        }
        
        if ($result && password_verify($motDePasse, $result['password'])) {
        
            return $this->getUserInfos($nomUtilisateur,null);
            
        }
        else{
            throw new Exception("get_auth_wrong_password");

        }
        
    }
    
    /**
     * Based on given parameters will create a new entry in users
     */
    public function insertInto($user_const,...$params){

        $this->db->beginTransaction();
            $request = $this->db->prepare(
                "INSERT INTO users (username, email, `password`, birth, gender, recover_token, profile_picture) 
                VALUES (:username, :email, :password, :birth, :gender, :recover_token, :profile_picture )");

            foreach($params as $k=>$param) {
                $request->bindValue(":" . $user_const[$k], $param);
            }
            $images = glob(MY_PLAYLIST_DEFAULT_IMAGES . '/*.jpeg');
            $imageSource = $images[rand(0,4)];

            // var_dump($images);
            // exit;
            $request->bindValue(':profile_picture', $imageSource);

            $request->execute();
            $result = $this->db->lastInsertId();  
        $this->db->commit();
             
        return $result;
    }

    /**
     * Based on a post request for sign up, will filter datas
     */
    public function signUp($user_const,array $data){

        unset($data['bSignUp']);
        foreach ($data as $key => $value) {
            if (empty($value)) {
                    throw new Exception("$key");
            }
        }

        $email = (string)$data['createUserEmail'];
        $password = password_hash($data['createUserPassword'],PASSWORD_DEFAULT);
        $userName = (string)$data['createUsername'];
        $date = date('Y-m-d',strtotime($data['signUpBirth']));
        $gender = (string)$data['signUpGender'];

        $isValid = $this->doesExistMailOrUsername($userName,$email,null);

        if ($isValid){

            // var_dump($isValid);
            // exit;
            $uniqueId = uniqid('-',true);
            $token = $userName . $uniqueId;
            $result = $this->insertInto($user_const,$email,$password,$userName,$date,$gender,$token);
        
            return $result;
        }

        var_dump("STOP ");
        exit;

    }

    public function doesExistMailOrUsername (string $username,string $email,?int $userid):bool{

        $sql = "SELECT id, email, username FROM users WHERE (email = :email OR username = :username)";
        if ($userid !== null) {
            $sql .= " AND id != :id";
        }
        $request = $this->db->prepare($sql);
        $request->bindValue(':email', $email);
        $request->bindValue(':username', $username); 
        if ($userid !== null) {
            $request->bindValue(':id', $userid);
        }
        $request->execute();
        $result = $request->fetch(PDO::FETCH_ASSOC);

        if($result){
            if($result['email'] === $email){
                var_dump($email);
                throw new Exception("email");
            }
            if($result['username'] === $username){
                var_dump($username);
                throw new Exception("username");
            }
        }
        return true;

    }

public function updateUser(array $userdatas,array $datas,?array $files) {
    

    if (!filter_var($datas['userEmailUpdate'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Le format n'est pas valide");
    } 

    $this->doesExistMailOrUsername($datas['usernameUpdate'],$datas['userEmailUpdate'],$userdatas['id']);
    
    if(!empty($files) && ($files['userImgUpdate']['size'] > 0)){
        $extension = pathinfo($_FILES['userImgUpdate']['name'], PATHINFO_EXTENSION);
        $fileName = $userdatas['id'] . '-profile-picture';
        $uploadDir = ".." . MY_RELATIVE_PATH_TO_USER_IMAGE;
        $uploadFile = $uploadDir . $fileName . '.'.$extension;

        array_map('unlink', glob($uploadDir . $fileName . '.*'));
        move_uploaded_file($_FILES['userImgUpdate']['tmp_name'], $uploadFile);

        $query = "UPDATE users SET profile_picture = :profile_picture WHERE id = :id";
        $request = $this->db->prepare($query);
        $request->execute([
            "profile_picture" => $uploadFile,
            "id" => $userdatas['id']
        ]);

    }
        
    $this->db->beginTransaction();

        $query = "UPDATE users SET email = :email, username = :username, gender = :gender, birth = :birth WHERE id = :id";
        $request = $this->db->prepare($query);
        $request->bindValue(":email", $datas['userEmailUpdate']);
        $request->bindValue(":username", $datas['usernameUpdate']);
        $request->bindValue(":gender", $datas['userGenderUpdate']);
        $request->bindValue(":birth", $datas['userBirthUpdate']);
        $request->bindValue(":id", $userdatas['id']);
        $request->execute();
    
        
        
    $this->db->commit();
    return true;
    
    }

    public function createAdminUser(array $datas){

        $uniqueId = uniqid('-',true);
        $token = $datas["createUsername"] . $uniqueId;
        $hashedPassword = password_hash($datas['newAdminUserPassword'],PASSWORD_DEFAULT);

        $sql = $this->db->prepare("INSERT INTO users (username, email, `password`, birth, `role`, gender, recover_token) 
        VALUES (:username, :email, :password, :birth, :role, :gender, :recover_token )");
        $sql->bindValue(':username', $datas['createUsername']);
        $sql->bindValue(':email', $datas['createUserEmail']);
        $sql->bindValue(':password', $hashedPassword);
        $sql->bindValue(':birth', $datas['createUserBirth']);
        $sql->bindValue(':role', $datas['newAdminUserRole']);
        $sql->bindValue(':gender', $datas['createUserGender']);
        $sql->bindValue(':recover_token', $token);
        $sql->execute();


    }

    public function getUsername(int $user_id){
        $sql = $this->db->prepare("SELECT username FROM users WHERE id = :id");
        $sql->bindValue(":id", $user_id);
        $sql->execute();
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
    }
}