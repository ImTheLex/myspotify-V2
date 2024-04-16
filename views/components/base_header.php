<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/models/SessionManager.php';

    $jsfiles = glob($_SERVER['DOCUMENT_ROOT'].'/public/js/*.js');
    foreach($jsfiles as $jsfile):
        if (pathinfo($jsfile,PATHINFO_FILENAME) === pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME)):
            $js = basename($jsfile); 
        endif; 
    endforeach;

    if(strpos($_SERVER['REQUEST_URI'],'/views/signup.php') === false){

        SessionManager::unsetSession('signupDatasStep1')  ?? '';
        SessionManager::unsetSession('signupDatasStep2') ?? '' ;
        
    }
    $userdatas = SessionManager::getSession('userdatas') ?? false;
    $myartist =  SessionManager::getSession('my_artist_id') ?? false;
    $playlistdatas =  SessionManager::getSession('playlists_datas') ?? false; 
    $playlisttodisplay = SessionManager::getSession('playlist_to_display') ?? false;
    $ourartists = SessionManager::getSession('our_artists_datas') ?? false;
    $artisttodisplay = SessionManager::getSession('artist_to_display') ?? false;
    $publicplaylists = SessionManager::getSession('public_playlists_datas') ?? false;
    
    $unreadtickets = SessionManager::getSession('unread_tickets') ?? false;
    if($userdatas && $userdatas['role'] === 9){
        $ticketsdatas = SessionManager::getSession('tickets_datas') ?? false;
        $tickettodisplay = SessionManager::getSession('ticket_to_display') ?? false;
    }   
    // var_dump($_SESSION);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ce site est une reproduction non certifiée du site de streaming audio Spotify">
    <link rel="stylesheet" href="/public/css/left_container.css">
    <link rel="stylesheet" href="/public/css/new.css">
    <link rel="stylesheet" href="/public/css/main-generated-V3.css">

    <?= isset($js)  && $js ? "<script src='/public/js/$js'; defer></script>" : "" ?>
    <!-- <script src='/public/js/Spotify.js' type="module" defer></script> -->
    <script src='/public/js/generate_css_php.js' type="module" defer></script>

    <title><?= ucfirst(basename(dirname(__DIR__) . DIRECTORY_SEPARATOR . $_SERVER['SCRIPT_NAME'],'.php'))?></title>
</head>
<body  class="gap-y-5 col-b <?= $_SERVER['SCRIPT_NAME'] == '/views/home.php' ? 'body-grad-2' : 'body-grad-1'?>">
    <header class="bg-cus-1 br-b-2-s make-container:header header">
        <nav class="px-4 py-4 center-b">
            <div class="logo-spotify">
               
            </div>
            <ul class="gap-y-8 flex justify-content-c align-items-c">  
            <?php if($userdatas && $userdatas['role'] === 9):?>
                <li class="max-cont-1100:hidden">
                    <a class=" hovr-text-white center gap-y-2" href="<?= "/controllers/RoutingController.php?admin" ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M309 106c11.4-7 19-19.7 19-34c0-22.1-17.9-40-40-40s-40 17.9-40 40c0 14.4 7.6 27 19 34L209.7 220.6c-9.1 18.2-32.7 23.4-48.6 10.7L72 160c5-6.7 8-15 8-24c0-22.1-17.9-40-40-40S0 113.9 0 136s17.9 40 40 40c.2 0 .5 0 .7 0L86.4 427.4c5.5 30.4 32 52.6 63 52.6H426.6c30.9 0 57.4-22.1 63-52.6L535.3 176c.2 0 .5 0 .7 0c22.1 0 40-17.9 40-40s-17.9-40-40-40s-40 17.9-40 40c0 9 3 17.3 8 24l-89.1 71.3c-15.9 12.7-39.5 7.5-48.6-10.7L309 106z"/>
                        </svg>Admin
                    </a>                   
                </li>
                <?php endif?>
                <?php if($myartist && $userdatas['role'] > 1 ):?>
                <li class="max-cont-1000:hidden">
                    <a href="<?= "/controllers/ArtistController.php?bOpenArtist={$myartist}"?>" class=" hovr-text-white center gap-y-2">
                        <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M512 256c0 .9 0 1.8 0 2.7c-.4 36.5-33.6 61.3-70.1 61.3H344c-26.5 0-48 21.5-48 48c0 3.4 .4 6.7 1 9.9c2.1 10.2 6.5 20 10.8 29.9c6.1 13.8 12.1 27.5 12.1 42c0 31.8-21.6 60.7-53.4 62c-3.5 .1-7 .2-10.6 .2C114.6 512 0 397.4 0 256S114.6 0 256 0S512 114.6 512 256zM128 288a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm0-96a32 32 0 1 0 0-64 32 32 0 1 0 0 64zM288 96a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm96 96a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
                        </svg>Compte artiste
                    </a>   
                </li>
                <?php endif?>
                <li class="max-cont-900:hidden">            
                    <a class=" hovr-text-white center gap-y-2" href='<?= "/controllers/RoutingController.php?accueil"?>'> 
                        <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 576 512">
                            <path opacity="1" fill="currentColor" d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                        </svg>Accueil
                    </a>
                </li>
                <li class="max-cont-800:hidden">
                    <a class=" hovr-text-white center gap-y-2" href="/views/contact.php">
                        <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/>
                        </svg>Contact
                    </a>
               </li>
                <li class="max-cont-750:hidden">
                    <?php if($userdatas):?>
                        <a class=" hovr-text-white center gap-y-2" href="logout.php">
                        <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                        </svg>Se déconnecter</a> 
                </li>
                <li>
                     <a class=" gap-y-3 flex align-items-c" href="/views/profile.php">
                           <div class="w-10 h-10">
                              <img class=" rounded-100 profile-picture" src=" <?=  DIRECTORY_SEPARATOR . $userdatas['profile_picture'] ?>" alt="Image de profile">
                           </div>
                           <p class="hovr-text-white">Profile</p>
                     </a>
                    <?php else: ?>
                        <a class=" hovr-text-white" href="/views/login.php">Se connecter</a>
                    <?php endif ?>
                </li>
                <li>
                    <button type="button" id="menuBurger" class="center br-none bg-transparent text-cus-7 hovr-text-white c-p">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path opacity="1" fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
                    </button>
                </li>
            </ul>
        </nav>
    </header>
                        