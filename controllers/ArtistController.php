<?php
session_start();

use myspotifyV2\models\Artist;
use myspotifyV2\models\Playlist;
use myspotifyV2\models\User;
use myspotifyV2\Requests\Validator;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Playlist.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Artist.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/User.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config/myfunctions.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/SessionManager.php";



    $userdatas = SessionManager::getSession('userdatas');
    $playlist = new Playlist();
    $artist = new Artist;
    $user = new User();

    // die(var_dump($_GET));

if($userdatas){

    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        $validator = new Validator($_GET);
        $validator->validate_fields();

        $errors = $validator->get_errors();
        $validatedRequest = $validator->get_request();

        if(isset($_GET['bCreateArtist'])){

            
            if(empty($errors)){

                if($userdatas['role'] < 2){

                    try {
                        $createArtist = $artist->createArtist($userdatas['id'],$userdatas['username']);
                    }catch(Exception $e){
                        echo $e->getMessage();
                        header("Location: /views/home.php");
                        exit;
                    }
                        $user->setNewUserRole($userdatas['id'],2);
                        $userdatas = $user->getUserInfos($userdatas['id'],null);
                        SessionManager::setSession('userdatas',$userdatas);
                        SessionManager::setSession('my_artist_id',$artist->getMyArtistId($userdatas['id']));

                }

            }      
        }

        elseif(isset($_GET['bOpenArtist'])){

            if(empty($errors)){

                try {
                    $artisttodisplay = $artist->openArtist($validatedRequest['bOpenArtist']);

                }catch(Exception $e){
                    header("Location: /views/home.php");
                    exit;
                }
                SessionManager::setSession('artist_to_display',$artisttodisplay);
            }      
        }
        // elseif(isset($_GET['bOpenPlaylist'])){

        //     if(empty($errors)){
                
        //         try{
        //             $playlistToDisplay = $playlist->openPlaylist($_GET['bOpenPlaylist'],$userdatas['id']);
        //         }catch(Exception $e){
        //             header("Location: /views/home.php");
        //             exit;
        //         }
        //         SessionManager::setSession('playlist_to_display',$playlistToDisplay);
        //     }
        // }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $validator = new Validator($_POST);
        $validator->validate_fields();

        $errors = $validator->get_errors();
        $validatedRequest = $validator->get_request();

        // if(isset($_POST['bDropPlaylist'])) {

        //     if(empty($errors)){
        //         $playlist->deletePlaylist($validatedRequest['deletePlaylistId'],$userdatas['id']);
        //         SessionManager::setSession('playlists_datas',$playlist->getMyPlaylistRelations($userdatas['id']));
        //         if ($validatedRequest['deletePlaylistId'] == SessionManager::getSession('playlist_to_display')['id']){
        //             SessionManager::unsetSession('playlist_to_display');
        //         }  
        //     }              
        // }

        if(isset($_POST['bUpdateArtist'])){
            
            if(empty($errors)) {

                try{
                
                    $updated = $artist->updateArtist($validatedRequest,$_FILES);
                }catch(Exception $e){
                    
                    SessionManager::setSession('error',["model_artist_update"=>"<p style='color:red'>{$e->getMessage()}</p>"]);

                }
                SessionManager::setSession('artist_to_display',$updated);                

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