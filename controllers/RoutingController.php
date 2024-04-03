<?php 
session_start();

use myspotifyV2\models\Playlist;
use myspotifyV2\models\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/SessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Ticket.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Playlist.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/User.php';

$playlist = new Playlist();
$userdatas = SessionManager::getSession('userdatas') ?? '';

if($userdatas){
    if(isset($_GET['accueil'])){
        SessionManager::unsetSession('playlist_to_display');
        SessionManager::setSession('playlists_datas',$playlist->getMyPlaylistRelations($userdatas['id']));
        SessionManager::setSession('public_playlists_datas',$playlist->showPublicPlaylists());

        header('Location: /views/home.php');
        exit;   
    }
}


header('Location: /views/home.php');
exit;