<?php

use myspotifyV2\models\Playlist;
use myspotifyV2\models\User;
use myspotifyV2\Requests\Validator;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/SessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Ticket.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Playlist.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';

$user = new User();
$userdatas = SessionManager::getSession('userdatas');
// $ticket = new Ticket($db->get_pdo());


// Login
if(isset($_POST['bLogin'])){

    $validator = new Validator($_POST);
    $validator->validate_fields();

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
        $playlist = new Playlist();
        SessionManager::setSession('playlists_datas',$playlist->getMyPlaylistRelations($is_User['id']));
        SessionManager::setSession('public_playlists_datas',$playlist->showPublicPlaylists());
        // SessionManager::setSession('unread_tickets', $ticket->getUnreadTickets($is_User['id']));
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
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if(empty($errors)){

        try {
            $responseSignUp = $user->searchUser($validatedRequest['signUpUsername'],$validatedRequest['signUpEmail'],null);
        }catch(Exception $e){
            if ($e->getMessage() === "email"){
                SessionManager::setSession('error',["sign_up_email"=>"<p style='color:red'>L'email existe déjà</p>"]);

            }elseif ($e->getMessage() === "username"){
                SessionManager::setSession('error',['sign_up_username' => "<p style='color:red'>Le username existe déjà</p>"]);
            }
            header('Location: /views/signup.php');
            exit;
        }
        if ($responseSignUp){
            try{
                $datas = intval($user->createUser($validatedRequest));
            }catch(Exception $e){
                SessionManager::setSession('error',['model_user_creation' => "<p style='color:red'>{$e->getMessage()}</p>"]);
                header('Location: /views/signup.php');
                exit;
            }
            // $recoverTokenTicket = $ticket->createTicket($datas,'RecoverToken');
            // $ticket->closeTicket($recoverTokenTicket,$user->getUserinfos($datas,null)['recover_token']);
            $message['create_user'] = "<p class='text-cus-2'> Création réussie, vous pouvez vous connecter</p>" ;
            SessionManager::setSession('success',$message);
            header('Location: /views/login.php');
            exit;
        }
    }
    SessionManager::setSession('error',$errors);
    header('Location: /views/login.php');
    exit;
}

// Update
elseif (isset($_POST['bUserUpdate'])){

    $validator = new Validator($_POST);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();
    die(var_dump($_POST));
    if (empty($errors)) {
        try {
            $updated = $user->updateUser($userdatas,$validatedRequest,$_FILES);
        }catch(Exception $e){
            if ($e->getMessage() === "email"){
                SessionManager::setSession('error',["update_email"=>"<p style='color:red'>L'email existe déjà</p>"]);
            }
            if ($e->getMessage() === "username"){
                SessionManager::setSession('error',['update_username' => "<p style='color:red'>Le username existe déjà</p>"]);
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
    }
    SessionManager::setSession('error',$errors);
    header('Location: /views/profile.php');
    exit; 
    
}

elseif (isset($_POST['bForgotPassword'])){


    $validator = new Validator($_POST);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if(empty($errors)){

        try{
            $response = $user->resetPassword($validatedRequest['forgotInput'],$validatedRequest['forgotToken']);
        }catch(Exception $e){
            if ($e->getMessage() === 'reset_password'){
                SessionManager::setSession('error',['reset_password' => "<p style='color:red'>Aucune correspondance.</p>"]);
            }
        }

        if($response) {

            SessionManager::setSession('user_recover_datas',$response);      
            header('Location: /views/reset_password.php?token');
            exit;
        }

        SessionManager::setSession('error',['forgotInvalid'=>"<p style='color:red'>Aucune correspondance.</p>"]);
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

        if($e->getMessage() === 'reset_password_failed'){
            SessionManager::setSession('error',['reset_password_failed' => "<p style='color:red'>Update failed.</p>"]);
        }else {

            SessionManager::setSession('error',['model' => "<p style='color:red'>{$e->getMessage()}</p>"]);
            header('Location: /views/reset_password.php?token');
            exit;
        }
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




