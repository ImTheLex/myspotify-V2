<!------------------------------------------Partie Centrale---------------------------------------->
<section class="col-b p-rel min-w-80 w-full <?= SessionManager::getSession('mob_biblio') ? 'max-media-500:hidden' :'' ?> gap  h-full br-cus-2 br-a-1-s rounded-3 make-container:middle-container middle-container" data-id="middle-container">
    <?php if($userdatas): ?>
    <?php if(isset($_GET['show-notif']) && !empty($unreadtickets)):?>
    <?php include 'components/notifications.php'?>
    <?php endif ?>
    <div class="py-2 px-6 p-abs zi-10 flex <?= isset(SessionManager::getSession('error')["model_playlist_update"]) ? 'justify-content-b':'justify-content-fe'?> w-full top-middle-container">
    <?= SessionManager::getSession('error')["model_playlist_update"] ?? '';?>
        <div class="center gap-x-1 top-middle-right-container">
            <p>
                <a href="<?= empty($unreadtickets) ? '#' : '?show-notif'?>" class="bg-cus-1 h-8 w-8 center rounded-100 p-rel">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                        <path opacity="1" fill="currentColor" d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416H424c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112v25.4c0 47.9 13.9 94.6 39.7 134.6H72.3C98.1 328 112 281.3 112 233.4V208c0-61.9 50.1-112 112-112zm64 352H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/>
                    </svg>
                    <?php if (isset($unreadtickets) && $unreadtickets !== false):?>
                    <span class="t-0 r-0 p-abs w-2 h-2 bg-cus-10  rounded-100 block"></span>
                    <?php endif ?>
                </a>
            </p>
        </div>
    </div>
    <div class="pb-2 h-full overf-a body-grad-1 rounded-3 middle-scrollable-container">
    <?php if(isset($playlisttodisplay) && $playlisttodisplay):?>
        <div class="playlist-display">
        <?php include 'components/middle_container_playlist_display.php'?>
        </div>
    <?php elseif(isset($artisttodisplay) && $artisttodisplay): ?>
        <div  class="artist-display <?= $artisttodisplay ? '' : 'hidden'?>">
        <?php include 'components/middle_container_artist_display.php'?>
        </div>
    <?php endif ?>
        <div class="audio-display">
        </div>      
        <div class="global-feed px-4 <?= $playlisttodisplay || $artisttodisplay ? 'hidden' : ''?>">
            <div class="grid grid-col-2 gap-x-4 gap-y-4 pt-15 max-cont-500:grid-col-1">
                <h2 class="grid-col-span-2 max-cont-500:grid-col-span-1">Vue d'ensemble</h2>
                <?php 
                if(isset($playlistdatas) && !empty($playlistdatas)):
                    for($i=0; $i < count($playlistdatas) && $i < 4; $i++):
                        $playlistdata = $playlistdatas[$i]; 
                        include 'components/middle_container_overview_playlists.php';
                    endfor;
                else: 
                ?>
                <p class="text-cus-2">Vous pouvez désormais créer une playlist !</p>
                 <?php endif?>
            </div>
            <div class="grid grid-col-4 gap-x-4 gap-y-4 pt-15 max-cont-750:grid-col-2 justify-items-c max-cont-500:grid-col-1">
                <h2 class="grid-col-span-4 max-cont-750:grid-col-span-2 max-cont-500:grid-col-span-1">Playlists publiques</h2>
                <?php for($i=0;  $i < count($publicplaylists) && $i < 4 ; $i++):?>
                <?php include 'components/middle_container_public_playlists.php'?>
                <?php endfor?>
            </div>
            <?php if(isset($tracksDatas)):?>
            <div class="grid grid-col-2 pt-15"> 
                <h2 class="grid-col-span-2">Playlists Spotify</h2>
                <?php for($i=0;  $i < 4 ; $i++):?>
                <?php include 'components/middle_container_spotify_artists.php'?>
                <?php endfor?>
            </div>
            <?php endif?>
            <div class="grid grid-col-4 gap-x-4 gap-y-4 pt-15 max-cont-750:grid-col-2 justify-items-c max-cont-500:grid-col-1">
                <h2 class="grid-col-span-4 max-cont-750:grid-col-span-2 max-cont-500:grid-col-span-1">Nos artistes</h2>
                <?php for($i=0;  $i < count($ourartists) && $i < 4 ; $i++):?>
                <?php include 'components/middle_container_our_artists.php'?>
                <?php endfor?>
            </div>
        </div>
        <?php else:?>
        <h2 class="mx-auto w-fit m-auto">Veuillez vous connecter pour accéder au contenu :)</h2>
        <?php endif ?>
    </div>
</section>


