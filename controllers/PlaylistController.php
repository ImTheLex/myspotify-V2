<?php
session_start();

use myspotifyV2\models\Playlist;
use myspotifyV2\Requests\Validator;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';
    require $_SERVER['DOCUMENT_ROOT'] . "/models/Playlist.php";

    require $_SERVER['DOCUMENT_ROOT'] . "/models/SessionManager.php";


    $userdatas = SessionManager::getSession('userdatas');
    $playlist = new Playlist();

    // die(var_dump($_GET));

if(isset($_GET['accueil'])){
    SessionManager::unsetSession('playlist_to_display');
    header('Location: /views/home.php');
    exit;
}
elseif(isset($_GET['bCreatePlaylist'])){

    $validator = new Validator($_GET);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();
    if(empty($errors)){

        try {
            $created = $playlist->createPlaylist($userdatas['id']);
        }catch(Exception $e){
            SessionManager::setSession('error',['model_playlist_creation'=>"<p style='color:red'>{$e->getMessage()}</p>"]);
        }

        $opened = $playlist->openPlaylist($created,$userdatas['id']);
        if($opened){
            $relations = $playlist->getMyPlaylistRelations($userdatas['id']);
        }
        SessionManager::setSession('playlists_datas',$relations);
        SessionManager::setSession('playlist_to_display',$opened);
        header("Location: ../views/home.php");
        exit;
    }
    
}


if(isset($_POST['bDropPlaylist'])) {

    $validator = new Validator($_POST);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();
    if(empty($errors)){
        $playlist->deletePlaylist($validatedRequest['deletePlaylistId'],$userdatas['id']);
        $playlists_datas = SessionManager::getSession('playlists_datas');
        foreach($playlists_datas as $key => $playlist_data) {
            if($playlist_data['id'] == $validatedRequest['deletePlaylistId']) {
                unset($playlists_datas[$key]);
                break;
            }
        }
        
        SessionManager::setSession('playlists_datas',$playlists_datas);
        if ($validatedRequest['deletePlaylistId'] == SessionManager::getSession('playlist_to_display')['id']){
            SessionManager::unsetSession('playlist_to_display');
        }  
    }              
}

if(isset($_POST['bUpdatePlaylist'])){

    $validator = new Validator($_POST);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();
    
    if(empty($errors)) {

        $updated = $playlist->updatePlaylist($validatedRequest,$_FILES);
        SessionManager::setSession('playlist_to_display',$updated);
        $playlists_datas = SessionManager::getSession('playlists_datas');
        foreach($playlists_datas as $key => $playlist_data) {
            if($playlist_data['id'] == $validatedRequest['updatePlaylstId']) {
            die(var_dump($validatedRequest,$playlist_data['id'],$playlists_datas[$key],$_FILES));

                // SessionManager::setSession('playlists_datas',$playlists_datas[$key]);
                break;
            }
        } 

    }else{

        SessionManager::setSession('error',$errors);
           
    }
    header('Location: /views/home.php');
    exit; 

    

}

if(isset($_GET['bOpenPlaylist'])){

    $validator = new Validator($_GET);
    $validator->validate_fields();

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

    if(empty($errors)){
        
        try{
            $playlistToDisplay = $playlist->openPlaylist($_GET['bOpenPlaylist'],$userdatas['id']);
        }catch(Exception $e){
            header("Location: /views/home.php");
            exit;
        }
        SessionManager::setSession('playlist_to_display',$playlistToDisplay);
    }
}


header("Location: /views/home.php");
exit;