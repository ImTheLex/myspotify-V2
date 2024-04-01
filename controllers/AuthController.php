<?php

use myspotifyV2\models\User;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/SessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/DatabaseConnection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Ticket.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';

$db = new DatabaseConnection();
$user = new User();
$userdatas = SessionManager::getSession('userdatas');
$ticket = new Ticket($db->get_pdo());


// Login
if(isset($_POST['bLogin'])){

    $validator = new Validator($_POST);
    $validator->validate_fields(['loginInput', 'loginPassword']);

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if (empty($errors)) {

        try{
            $is_User = $user->authUser($validatedRequest['loginInput'], $validatedRequest['loginPassword']);
        }catch(Exception $e){
            if($e->getMessage() === "get_auth_no_match"){

                SessionManager::setSession('error',["logins" => "<p style='color:red'>Les identifiants n'existent pas.</p>"]);
                
            }
            if($e->getMessage() === "get_auth_wrong_password"){
                SessionManager::setSession('error',["login_password" => "<p style='color:red'>Le password est incorrect.</p>"]);
            } 
            header('Location: /views/login.php');
            exit;  
        }
        SessionManager::setSession('unread_tickets', $ticket->getUnreadTickets($is_User['id']));
        SessionManager::setSession('userdatas',$is_User);
        header('Location: /views/home.php');
        exit;   
    }
    SessionManager::setSession('error',$errors);
    header('Location: /views/login.php');
    exit;
}
    
// Signup
elseif (isset($_POST['bSignUp'])){

    $validator = new Validator($_POST);
    $validator->validate_fields(['signUpUsername','signUpEmail','signUpPassword1','signUpPassword2','signUpBirth','signUpGender']);

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    try {
        $responseSignUp = $user->searchUser($validatedRequest['signUpUsername'],$validatedRequest['signUpEmail'],null);
    }catch(Exception $e){
        if ($e->getMessage() === "email"){
            SessionManager::setSession('error',["signUpEmail"=>"<p style='color:red'>L'email existe déjà</p>"]);
        }
        if ($e->getMessage() === "username"){
            SessionManager::setSession('error',['signUpUsername' => "<p style='color:red'>Le username existe déjà</p>"]);
        }
        header('Location: /views/signup.php');
        exit;
    }
    if ($responseSignUp){
        try{
            $datas = intval($user->createUser($validatedRequest));
        }catch(Exception $e){
            SessionManager::setSession('error',['model' => "<p style='color:red'>{$e->getMessage()}</p>"]);
            header('Location: /views/signup.php');
            exit;
        }
        $recoverTokenTicket = $ticket->createTicket($datas,'RecoverToken');
        $ticket->closeTicket($recoverTokenTicket,$user->getUserinfos($datas,null)['recover_token']);
        $message['create_user'] = "<p class='text-cus-2'> Création réussie, vous pouvez vous connecter</p>" ;
        SessionManager::setSession('success',$message);
        header('Location: /views/login.php');
        exit;
    }

}

elseif (isset($_POST['bUserUpdate'])){

    $validator = new Validator($_POST);
    $validator->validate_fields(['usernameUpdate', 'userEmailUpdate', 'userBirthUpdate','userGenderUpdate']);

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();
    

    if (empty($errors)) {
        try {
            $updated = $user->updateUser($userdatas,$validatedRequest,$_FILES);
        }catch(Exception $e){
            if ($e->getMessage() === "email"){
                SessionManager::setSession('error',["updateEmail"=>"<p style='color:red'>L'email existe déjà</p>"]);
            }
            if ($e->getMessage() === "username"){
                SessionManager::setSession('error',['updateUsername' => "<p style='color:red'>Le username existe déjà</p>"]);
            }
            header('Location: /views/profile.php');
            exit;
        } 
        if($updated){
            $user = $user->getUserInfos($_POST['usernameUpdate'],null);
            $message['update_user'] = "<p class='text-cus-2'> Mise à jour des informations réussie.</p>" ;
            SessionManager::setSession('userdatas',$user);
            SessionManager::setSession('success',$message);
            header('Location: /views/profile.php');
            exit;
        } 
        // die('COUCOU'); 
    }
    SessionManager::setSession('error',$errors);
    header('Location: /views/profile.php');
    exit; 
    
    
}

elseif (isset($_POST['bForgotPassword'])){


    $validator = new Validator($_POST);
    $validator->validate_fields(['forgotInput', 'forgotToken']);

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    $response = $user->resetPassword($validatedRequest['forgotInput'],$validatedRequest['forgotToken']);

    if($response) {

        SessionManager::setSession('user_recover_datas',$response);      
        header('Location: /views/reset_password.php?token');
        exit;

    } 
    if(empty($errors)){

        $errors['forgotInvalid'] = "<p style='color:red'>Les champs sont invalides</p>";

    }else{

        SessionManager::setSession('error',$errors);
        header('Location: /views/forgot_password.php');
        exit;
    }
    SessionManager::setSession('error',$errors);
    header('Location: /views/forgot_password.php');
    exit;
}

elseif(isset($_POST['bResetPassword'])){

    $password = htmlspecialchars(trim($_POST['resetInput']));
    try{
        $user->initiatePassword($_SESSION['user_recover_datas'],$password);
    }catch(Exception $e){

        if($e->getMessage() === 'resetPasswordFailed'){
            SessionManager::setSession('error',['resetPassword' => "<p style='color:red'>Update failed.</p>"]);
        }
        SessionManager::setSession('error',['model' => "<p style='color:red'>{$e->getMessage()}</p>"]);
        header('Location: /views/reset_password.php?token');
        exit;


    }
}

// elseif(isset($_POST['bAdminCrud']) && $userdatas['role'] == 9){

//     $validator = new Validator($_POST);
//     $validator->validate_fields(['newAdminUserUsername','newAdminUserEmail','newAdminUserPassword','newAdminUserGender','newAdminUserBirth','newAdminUserRole']);

//     $errors = $validator->get_errors();
//     $validatedRequest = $validator->get_request();
//     $user->createAdminUser($validatedRequest);
// }




header("Location: /views/home.php");
exit;




