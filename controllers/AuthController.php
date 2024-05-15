<?php

use myspotifyV2\models\Artist;
use myspotifyV2\models\Playlist;
use myspotifyV2\models\Ticket;
use myspotifyV2\models\Track;
use myspotifyV2\models\User;
use myspotifyV2\Requests\Validator;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/SessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/myfunctions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Ticket.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Track.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Artist.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Playlist.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';

$user = new User();
$track = new Track();
$ticket = new Ticket();
$playlist = new Playlist();
$artist = new Artist();
$userdatas = SessionManager::getSession('userdatas');




if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $validator = new Validator($_POST);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if(isset($_POST['bLogin'])){
     
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
            $is_User['role'] >= 2 ? SessionManager::setSession('my_artist_id',$artist->getMyArtistId($is_User['id'])) : false;
            $myartistid = SessionManager::getSession('my_artist_id');
            $is_User['role'] >= 2 ? SessionManager::setSession('my_tracks',$track->getTracks($myartistid)) : false;
            $is_User['role'] === 9 ? SessionManager::setSession("tickets_datas",$ticket->getAllTickets()) : false;
            SessionManager::setSession('playlists_datas',$playlist->getMyPlaylistRelations($is_User['id']));
            SessionManager::setSession('our_artists_datas',$artist->showArtists());
            SessionManager::setSession('public_playlists_datas',$playlist->showPublicPlaylists());
            SessionManager::setSession('unread_tickets', $ticket->getUnreadTickets($is_User['id']));
            SessionManager::setSession('userdatas',$is_User);
            header('Location: /views/home.php');
            exit;   
        }
        SessionManager::setSession('error',$errors);
        header('Location: /views/login.php');
        exit;
    }
    
    // Signup Step 1
    elseif (isset($_POST['bSignUpStep1'])){
        if(empty($errors)){
            SessionManager::setSession('signupDatasStep1',$validatedRequest);
            header("Location: /views/signup.php?signupStep2");
            exit;
        }
    }
    // Signup Step 2
    elseif (isset($_POST['bSignUpStep2'])){
        if(empty($errors)){

            SessionManager::setSession('signupDatasStep2',$validatedRequest);
            header("Location: /views/signup.php?signupStep3");
            exit;
        }      
    }
    // Signup
    elseif (isset($_POST['bSignUp'])){
    
        if(empty($errors)){
            // var_dump($_SESSION,$validatedRequest);
            // die;
            $validatedRequest = array_merge(SessionManager::getSession('signupDatasStep1'),SessionManager::getSession('signupDatasStep2'));
            SessionManager::unsetSession('signupDatasStep2');SessionManager::unsetSession('signupDatasStep1');
    
            try {
                $responseSignUp = $user->searchUser($validatedRequest['createUsername'],$validatedRequest['createUserEmail'],null);
            }catch(Exception $e){
                if ($e->getMessage() === "email"){
                    SessionManager::setSession('error',["sign_up_email"=>"<p style='color:red'>L'email existe déjà</p>"]);
    
                }elseif ($e->getMessage() === "username"){
                    SessionManager::setSession('error',['sign_up_username' => "<p style='color:red'>Le username existe déjà</p>"]);
                }
                header('Location: /views/signup.php?signupStep1');
                exit;
            }
            if ($responseSignUp){
                try{
                    $user_id = intval($user->createUser($validatedRequest));
                }catch(Exception $e){
                    SessionManager::setSession('error',['model_user_creation' => "<p style='color:red'>{$e->getMessage()}</p>"]);
                    header('Location: /views/signup.php');
                    exit;
                }
                $recoverTokenTicket = $ticket->createTicket(['user_id'=>$user_id,'contactSubject'=>'Recover Token', 'contactContent'=>'Auto Message']);
                if($validatedRequest['signUpArtist'] === "oui"){
                    $artistCreated = $artist->createArtist($user_id,$validatedRequest['createUsername']);
                    if($artistCreated){
                        $user->setNewUserRole($user_id,2);
                    }
                }
                $ticket->closeTicket($recoverTokenTicket,$user->getUserinfos($user_id,null)['recover_token']);
                SessionManager::setSession('success',['create_user' => "<p class='text-cus-2'> Création réussie, vous pouvez vous connecter</p>"]);
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
        // Admin user update
        if (empty($errors)) {
            if(strpos($_SERVER['HTTP_REFERER'],'profile.php?userProfile')){
                $viewUserProfile = SessionManager::getSession('adminViewUserProfileInfos') ?? false;
                try{
                    $updated = $user->updateUser($viewUserProfile,$validatedRequest,$_FILES);
                }catch(Exception $e){
                    if ($e->getMessage() === "email"){
                        SessionManager::setSession('error',["update_email"=>"<p style='color:red'>L'email existe déjà</p>"]);
                    }
                    if ($e->getMessage() === "username"){
                        SessionManager::setSession('error',['update_username' => "<p style='color:red'>Le username existe déjà</p>"]);
                    }
                    header('Location: /views/profile.php?userProfile');
                    exit;
                }
                if($updated){
                    $viewUserProfile = $user->getUserInfos($_POST['usernameUpdate'],null);
                    $message['update_user'] = "<p class='text-cus-2'> Mise à jour des informations réussie.</p>" ;
                    SessionManager::setSession('adminViewUserProfileInfos',$viewUserProfile);
                    SessionManager::setSession('success',$message);
                    header('Location: /views/profile.php?userProfile');
                    exit;
                } 
            }
            // Normal user update
            else{
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
                    $userinfo = $user->getUserInfos($_POST['usernameUpdate'],null);
                    $message['update_user'] = "<p class='text-cus-2'> Mise à jour des informations réussie.</p>" ;
                    SessionManager::setSession('userdatas',$userinfo);
                    SessionManager::setSession('success',$message);
                    header('Location: /views/profile.php');
                    exit;
                } 
            }

        }
        SessionManager::setSession('error',$errors);
        header('Location: /views/profile.php');
        exit; 
        
    }
    // Forgot password
    elseif (isset($_POST['bForgotPassword'])){
    
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
    // Reset Password
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

    // Delete user
    elseif(isset($_POST['bUserDelete'])){

            if(empty($errors) && (((int)$userdatas['id'] === (int)$validatedRequest['user_id']) || $userdatas['role'] === 9)){
            try{
                $is_Not_User = $user->deleteUser($validatedRequest['user_id']);
            }catch(Exception $e){
                echo $e;
            }
            if($is_Not_User && ((int)$userdatas['id'] === (int)$validatedRequest['user_id'])) {
                $_SESSION = array();
            }

        }
    }

    // Admin crud
    elseif(isset($_POST['bAdminCrud']) && $userdatas['role'] == 9){
        try {
            $responseSignUp = $user->searchUser($validatedRequest['createUsername'],$validatedRequest['createUserEmail'],null);
        }catch(Exception $e){
            if ($e->getMessage() === "email"){
                SessionManager::setSession('error',["sign_up_email"=>"<p style='color:red'>L'email existe déjà</p>"]);

            }elseif ($e->getMessage() === "username"){
                SessionManager::setSession('error',['sign_up_username' => "<p style='color:red'>Le username existe déjà</p>"]);
            }
            header('Location: /views/admin.php?admin-create-user');
            exit;
        }
        if($responseSignUp){
            try{
                $user_id = intval($user->createUser($validatedRequest));
            }catch(Exception $e){
                SessionManager::setSession('error',['model_user_creation' => "<p style='color:red'>{$e->getMessage()}</p>"]);
                header('Location: /views/admin.php?admin-create-user');
                exit;
            }
            $recoverTokenTicket = $ticket->createTicket(['user_id'=>$user_id,'contactSubject'=>'Recover Token', 'contactContent'=>'Auto Message']);
            if(intval($validatedRequest['createUserRole']) === 2){
                $artistCreated = $artist->createArtist($user_id,$validatedRequest['createUsername']);
            }
            $user->setNewUserRole($user_id,intval($validatedRequest['createUserRole']));
            $ticket->closeTicket($recoverTokenTicket,$user->getUserinfos($user_id,null)['recover_token']);
            SessionManager::setSession('success',['create_admin_user' => "<p class='text-cus-2'> Création réussie.</p>"]);
            header('Location: /views/admin.php?admin-create-user');
            exit;

        }
    }
    elseif(isset($_POST['bAdminViewUserProfile'])){
        try {
            $userToShow = $user->getUserInfos($validatedRequest['adminSearchUser'],null);
        }
        catch(Exception $e){
            echo $e;
            exit;
        }
        SessionManager::setSession('adminViewUserProfileInfos',$userToShow);
        header('Location: /views/profile.php?userProfile');
        exit;
    }
    


}


header("Location: /views/home.php");
exit;




