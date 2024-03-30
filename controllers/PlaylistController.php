<?php
session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/DatabaseConnection.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';
    require $_SERVER['DOCUMENT_ROOT'] . "/models/User.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/models/Playlist.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/models/Playlist_User_Relation.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/models/SessionManager.php";


    $client = new DatabaseConnection;
    $db = $client->get_pdo();
    $userdatas = SessionManager::getSession('userdatas');
    $playlist = new Playlist($db);
    $playlistrelation = new PlaylistUserRelation($db);

    
if(isset($_GET['bCreatePlaylist'])){

    $response = $playlist->create_playlist($userdatas['id']);
    $newRelationSubmit = $playlistrelation->make_subscribe_relation($userdatas['id'],$response);
    $result = $playlist->open_playlist($response);
    SessionManager::setSession('playlist_to_display',$result);
    header("Location: ../views/home.php");
    exit;

}   

if(isset($_POST['bDropPlaylist'])) {
    $playlist->delete_playlist($_POST['playlist_id']);
    if ($_POST['playlist_id'] == SessionManager::getSession('playlist_to_display')['id']){
        SessionManager::unsetSession('playlist_to_display');
    }                
}
if(isset($_POST['bUpdatePlaylist'])){

    unset($_POST['bUpdatePlaylist']);
    $validator = new Validator($_POST);
    $validator->validate_fields(["updatePlaylistPrivacy","updatePlaylistTitle","updatePlaylistDescription","updatePlaylstId"]);

    $errors = $validator->get_errors();
    $validatedRequest = $validator->get_request();

   
    if(!$errors) {
        
        $updated = $playlist->updatePlaylist($validatedRequest,$_FILES);
        SessionManager::setSession('playlist_to_display',$updated); 

    }else{

        SessionManager::setSession('error',$errors);
           
    }
    header('Location: /views/home.php');
    exit; 

    

}

if(isset($_POST['bOpenPlaylist'])){
    $playlistToDisplay = $playlist->open_playlist($_POST['playlist_id']);
    SessionManager::setSession('playlist_to_display',$playlistToDisplay);
}


header("Location: /views/home.php");