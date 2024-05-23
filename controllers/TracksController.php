<?php
session_start();

use myspotifyV2\models\Artist;
use myspotifyV2\models\Playlist;
use myspotifyV2\models\Track;
use myspotifyV2\models\User;
use myspotifyV2\Requests\Validator;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/requests/Validator.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Playlist.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Artist.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/Track.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/User.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/config/myfunctions.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/models/SessionManager.php";



    $userdatas = SessionManager::getSession('userdatas');
    $myartistid = SessionManager::getSession('my_artist_id');
    $playlist = new Playlist();
    $artist = new Artist;
    $user = new User();
    $track = new Track();

    // die(var_dump($_GET));

if($userdatas){

    if($_SERVER['REQUEST_METHOD'] === 'GET'){

        $validator = new Validator($_GET);
        $validator->validate_fields();

        $errors = $validator->get_errors();
        $validatedRequest = $validator->get_request();
  
        // }
        // elseif(isset($_GET['bDroptracks'])){

        //     if(empty($errors)){
        //         if($myartistid) {

        //             try{
        //                 $artistDeletion = $artist->dropMyArtist($myartistid);

        //             }catch(Exception $e){
        //                 header("Location: /views/home.php");
        //                 exit;
        //             }
        //             SessionManager::unsetSession('my_artist_id');
        //             SessionManager::unsetSession('artist_to_display');
        //         }
        //     }
        // }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $validator = new Validator($_POST);
        $validator->validate_fields();

        $errors = $validator->get_errors();
        $validatedRequest = $validator->get_request();
        // var_dump($_FILES);
        // dd($_POST, $errors,$_FILES);
        if(isset($_POST['bCreateTrack'])){
            
            if(empty($errors)) {
                try{      
                    $createdTrack = $track->createTrack($validatedRequest,$myartistid,$_FILES);
                }catch(Exception $e){          
                    SessionManager::setSession('error',["model_track_creation"=>"<p style='color:red' class='grid-col-span-2'>{$e->getMessage()}</p>"]);
                    header('Location: /views/home.php?create_track');
                    exit;
                }             
                SessionManager::setSession('artist_tracks',$track->getTracks($myartistid));                
                SessionManager::setSession('success',['create_track' => "<p class='text-cus-2 grid-col-span-2'> Création réussie,le morceau à été sauvegardé.</p>"]);              

            }else{

                SessionManager::setSession('error',$errors);
                
            }
            header('Location: /views/home.php?create_track');
            exit; 
        }
        elseif(isset($_POST['bCreateTrackRelation'])){
            if(empty($errors)){

                try {
                    $trackRelation = $track->createTrackRelation($validatedRequest['trackRelationId'],$validatedRequest['playlistRelationId']);

                }catch(Exception $e){
                    header("Location: /views/home.php");
                    exit;
                }
                SessionManager::setSession('artist_to_display',$artisttodisplay);
            }  
        }  
    }
}

header("Location: /views/home.php");
exit;