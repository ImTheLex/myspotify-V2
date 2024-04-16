<?php 
session_start();

use myspotifyV2\models\Artist;
use myspotifyV2\models\Playlist;
use myspotifyV2\models\Ticket;

require_once $_SERVER['DOCUMENT_ROOT'] . '/models/SessionManager.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Ticket.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Artist.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/Playlist.php';

$ticket = new Ticket();
$playlist = new Playlist();
$artist = new Artist();
$userdatas = SessionManager::getSession('userdatas') ?? '';

if($userdatas){
    if(isset($_GET['accueil'])){
        SessionManager::unsetSession('playlist_to_display');
        SessionManager::unsetSession('artist_to_display');
        SessionManager::setSession('playlists_datas',$playlist->getMyPlaylistRelations($userdatas['id']));
        SessionManager::setSession('public_playlists_datas',$playlist->showPublicPlaylists());
        SessionManager::setSession('our_artists_datas',$artist->showArtists());
        SessionManager::setSession('unread_tickets', $ticket->getUnreadTickets($userdatas['id']));
        SessionManager::setSession('mob_home',true);
        SessionManager::unsetSession('mob_biblio');


        header('Location: /views/home.php');
        exit;   
    }
    elseif(isset($_GET['biblio'])){
        SessionManager::setSession('mob_biblio',true);
        SessionManager::unsetSession('mob_home');
        SessionManager::unsetSession('mob_playlist');
        
    }
    elseif($userdatas['role'] === 9 && isset($_GET['admin'])){

        SessionManager::setSession("tickets_datas",$ticket->getAllTickets()) ?? false;
        header('Location: /views/admin.php');
        exit;  

    }
}


header('Location: /views/home.php');
exit;