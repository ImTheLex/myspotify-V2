<?php

use myspotifyV2\models\Playlist;

    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/SessionManager.php';
    // require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Ticket.php';

    $jsfiles = glob($_SERVER['DOCUMENT_ROOT'].'/public/js/*.js');
    foreach($jsfiles as $jsfile):
        if (pathinfo($jsfile,PATHINFO_FILENAME) === pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME)):
            $js = basename($jsfile); 
        endif; 
    endforeach;

    // var_dump($_SESSION);
    

    $userdatas = SessionManager::getSession('userdatas') ?? null;
    $playlistdatas =  SessionManager::getSession('playlists_datas') ?? false; 
    $playlisttodisplay = SessionManager::getSession('playlist_to_display') ?? false;
    // var_dump($playlisttodisplay,$playlistdatas);
    $publicplaylists = SessionManager::getSession('public_playlists_datas') ?? false;

    $unreadtickets = SessionManager::getSession('unread_tickets') ?? false;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ce site est une reproduction non certifiée du site de streaming audio Spotify">
    <!-- <link rel="stylesheet" href="/public/new.css"> -->
    <link rel="stylesheet" href="/public/css/main-generated-V2.css">
    <?= isset($js)  && $js ? "<script src='/public/js/$js'; defer></script>" : "" ?>
    <!-- <script src='/public/js/Spotify.js' type="module" defer></script> -->
    <script src='/public/js/generate_css_php.js' type="module" defer></script>

    <title><?= ucfirst(basename(dirname(__DIR__) . DIRECTORY_SEPARATOR . $_SERVER['SCRIPT_NAME'],'.php'))?></title>
</head>
<body  class="gap-y-5 col-b <?= $_SERVER['SCRIPT_NAME'] == '/views/home.php' ? 'body-grad-2' : 'body-grad-1'?>">
    <header class="bg-cus-1 br-b-2-s">
        <nav class="px-4 py-4 center-b">
            <div class="logo-spotify">
               
            </div>
            <ul class="gap-x-8 items-center ">  
                <?php if(isset($userdatas) && $userdatas['role'] === 9):?>
                <li>
                    <a class=" hovr-white" href="/views/admin.php">Admin</a>   
                    <?php
                    //  $ticket = new Ticket();
                     ?>         
                     
                </li>
                <?php endif?>
                <li>
                    <!-- <a class=" hovr-white" href="/views/home.php">Accueil</a>     -->
                    <a href='<?= isset($playlisttodisplay) && $playlisttodisplay ? "/controllers/PlaylistController.php?accueil" : ''?>'> Accueil</a>
                </li>
                <li>
                  <a class=" hovr-white" href="/views/contact.php">Contact</a>
               </li>
                <li>
                    <?php if(isset($userdatas)):?>
                        <a class=" hovr-white" href="logout.php">Se déconnecter</a> 
                </li>
                <li>
                     <a class=" gap-x-3 items-center" href="/views/profile.php">
                           <div class="w-10 h-10">
                              <img class=" rounded-full profile-picture" src=" <?=  DIRECTORY_SEPARATOR . $userdatas['profile_picture'] ?>" alt="Image de profile">
                           </div>
                           <p class="hovr-white">Profile</p>
                     </a>

                    <?php else: ?>
                        <a class=" hovr-white" href="/views/login.php">Se connecter</a>
                    <?php endif ?>
                </li>
            </ul>
        </nav>
    </header>
                        