<?php
session_start();

use myspotifyV2\models\Playlist;
use myspotifyV2\models\Track;
use myspotifyV2\Requests\Validator;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Playlist.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Track.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/SessionManager.php";


    $userdatas = SessionManager::getSession('userdatas');
    $playlist = new Playlist();
    $track = new Track();

    // die(var_dump($_GET));

if($userdatas){

    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        $validator = new Validator($_GET);
        $validator->validate_fields();

        $errors = $validator->get_errors();
        $validatedRequest = $validator->get_request();

        if(isset($_GET['bCreatePlaylist'])){

            
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
        elseif(isset($_GET['bOpenPlaylist'])){

            if(empty($errors)){
                
                try{
                    $playlistToDisplay = $playlist->openPlaylist($_GET['bOpenPlaylist'],$userdatas['id']);
                }catch(Exception $e){
                    header("Location: /views/home.php");
                    exit;
                }
                SessionManager::unsetSession('artist_to_display');
                SessionManager::setSession('playlist_tracks',$track->getPlaylistTracks($validatedRequest['bOpenPlaylist']));
                SessionManager::setSession('playlist_to_display',$playlistToDisplay);
            }
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $validator = new Validator($_POST);
        $validator->validate_fields();

        $errors = $validator->get_errors();
        $validatedRequest = $validator->get_request();

        if(isset($_POST['bDropPlaylist'])) {

            if(empty($errors)){
                $playlist->deletePlaylist($validatedRequest['deletePlaylistId'],$userdatas['id']);
                SessionManager::setSession('playlists_datas',$playlist->getMyPlaylistRelations($userdatas['id']));
                if ($validatedRequest['deletePlaylistId'] == SessionManager::getSession('playlist_to_display')['id']){
                    SessionManager::unsetSession('playlist_to_display');
                }  
            }              
        }

        elseif(isset($_POST['bUpdatePlaylist'])){
            
            if(empty($errors)) {

                try{
                
                    $updated = $playlist->updatePlaylist($validatedRequest,$_FILES);
                }catch(Exception $e){
                    
                    SessionManager::setSession('error',["model_playlist_update"=>"<p style='color:red'>{$e->getMessage()}</p>"]);

                }
                SessionManager::setSession('playlist_to_display',$updated);
                SessionManager::setSession('playlists_datas',$playlist->getMyPlaylistRelations($userdatas['id']));
                

            }else{

                SessionManager::setSession('error',$errors);
                
            }
            header('Location: /views/home.php');
            exit; 
        }
    }
}

header("Location: /views/home.php");
exit;