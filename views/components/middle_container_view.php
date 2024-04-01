<!------------------------------------------Partie Centrale---------------------------------------->
<section class="col-b p-rel w-full h-full br-cus-c-2 br-1-s rounded-sm middle-container">
    <?php if(isset($userdatas)): ?>
        <div class="py-2 px-6 p-abs d-fx jc-fe w-full top-middle-container">
            <?php if(isset($_GET['show-notif']) && !empty($unreadtickets)):?>
                    <div class="p-abs r-0 mr-20  w-fit bg-cus-5 rounded-s p-2 notification">
                        <ul class="flex-col gap-y-2">
                            <?php foreach($unreadtickets as $unreadticket):?>
                                <li class="bg-cus-6 gap-x-3 p-2 center-b">
                                    <div>
                                        <h5 class="">Sujet:</h5>
                                        <p class="text-cus-2"><?=$unreadticket['content']?></p>
                                        <h5 class="">Réponse:</h5>
                                        <p class="text-cus-2"><?= $unreadticket['response']?></p>
                                    </div>
                                    <a href="/controllers/TicketController.php?bIsReadTicket=<?=$unreadticket['id']?>" class="center bg-cus-10 br-2-s br-cus-c-5 rounded-xs">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
                                            <path opacity="1" fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach?>
                        </ul>
                    </div>
                <?php endif ?>
            <div class="items-center gap-x-1 top-middle-right-container">
                <p>
                    <a href="<?= empty($unreadtickets) ? '#' : '?show-notif'?>" class="bg-cus-1 h-8 w-8 center rounded-full p-rel">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                            <path opacity="1" fill="currentColor" d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416H424c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112v25.4c0 47.9 13.9 94.6 39.7 134.6H72.3C98.1 328 112 281.3 112 233.4V208c0-61.9 50.1-112 112-112zm64 352H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/>
                        </svg>
                        <?php if (isset($unreadtickets) && $unreadtickets !== false):?>
                            <span class="t-0 r-0 p-abs w-2 h-2 bg-cus-10  rounded-full block"></span>
                        <?php endif ?>
                    </a>
                </p>
            </div>
        </div>

        <div class="py-2 h-full overf-a body-grad-1 rounded-sm middle-scrollable-container">
            <div class="playlist-display <?= isset($playlisttodisplay) && $playlisttodisplay ? '' : 'hidden'?> ">
                <?php include 'components/middle_container_playlist_display.php'?>
            </div>
            <div class="artist-display">
            </div>
            <div class="audio-display">
            </div>
                <?php if (isset($playlistdatas)):?>
                    <div class="global-feed px-4 <?= isset($playlisttodisplay) && $playlisttodisplay ? 'hidden' : ''?>">
                        <div class="d-gd grid-col-2 pt-15">
                            <h2 class="col-span-2">Vue d'ensemble</h2>
                            <?php   
                                if ($playlistdatas):
                                $length = count($playlistdatas) ?? 0;?>
                                <?php for($i=0; $i < $length  &&  $i < 4 ; $i++):?>
                
                                <?php include 'components/middle_container_overview_playlists.php'?>

                                <?php endfor ?>

                                <?php else: ?>
                                    <p class="text-cus-2">Vous pouvez désormais créer une playlist !</p>
                            <?php endif?>
                        </div>
                        <div class="d-gd grid-col-2 pt-15">
                            <h2 class="col-span-2">Playlists publiques</h2>
                            <?php $publicPlaylists = $playlist->show_public_playlist() ?>
                            <?php for($i=0;  $i < count($publicPlaylists) && $i < 4 ; $i++):?>
                                <?php include 'components/middle_container_public_playlists.php'?>
                            <?php endfor?>
                        </div>
                        <?php if(isset($tracksDatas)):?>
                            <div class="d-gd grid-col-2 pt-15"> 
                            <h2 class="col-span-2">Playlists Spotify</h2>

                            <?php for($i=0;  $i < 4 ; $i++):?>
                                <?php include 'components/middle_container_spotify_artists.php'?>
                            <?php endfor?>
                            </div>
                        <?php endif?>
                    </div>
                <?php endif?>
    <?php else:?>
            <h2 class="mx-auto w-fit m-auto">Veuillez vous connecter pour accéder au contenu :)</h2>
    <?php endif ?>
        </div>
</section>


