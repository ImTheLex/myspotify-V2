<?php if($userdatas):?>
    
<article class="pt-16" >
    <div class="flex gap-y-4 mx-4 mb-5">
        <img class="img-cov br-a-1-s h-30 w-30" src="<?= $playlisttodisplay['img']?>" id="playlistUpdatePicture" alt="">
        <?php if (isset($_GET['edit']) && (($userdatas['id'] === $playlisttodisplay['user_id']) || $userdatas['role'] === 9)):?>
        <form method="post" class="grid grid-col-2 gap-y-4" action="/controllers/PlaylistController.php" enctype="multipart/form-data" id="playlistFormUpdate">
            <input class="hidden" type="file" onchange="previewImagePlaylist()" name="updatePlaylistPicture" id="updatePlaylistPicture">
            <label class="flex-col fw-6 text-white" for="updatePlaylistPrivacy">Privacy
                <select  class="input" name="updatePlaylistPrivacy" id="updatePlaylistPrivacy" value ="<?= $playlisttodisplay['privacy'] == 0 ? 0  : 1 ?>" >
                    <option class="text-black px-2" value="0" <?= $playlisttodisplay['privacy'] == 0 ? "selected"  : "" ?>  >Privée</option>
                    <option class="text-black px-2" value="1" <?= $playlisttodisplay['privacy'] == 1 ? "selected"  : "" ?>  >Publique</option>
                </select>
            </label>
            <label class=" flex-col fw-6 text-white" for="updatePlaylistTitle">Title
                <input class="input" type="text" name="updatePlaylistTitle" id="updatePlaylistTitle" value="<?= $playlisttodisplay['title']?>">
            </label>
            <label class="flex-col fw-6 text-white" for="updatePlaylistDescription">Description
                <input class="input" type="text" name="updatePlaylistDescription" id="updatePlaylistDescription" value="<?= $playlisttodisplay['description']?>">
            </label>
            <input type="hidden" name="updatePlaylstId" value="<?= $playlisttodisplay['id']?>">
            <button class=" hidden br-a-1-s br-cus-c-7 text-cus-7 rounded-1 c-p px-4 py-2 ta-c w-fit bg-cus-3 td-3 hovr-bx-shadow-cus-2" name="bUpdatePlaylist">Confirmer</button>
        </form>
        <?php else:?>
        <div>
            <p><?= $playlisttodisplay['privacy'] === 1 ? 'Playlist publique' : 'Playlist privée'  ?></p>
            <h3><?= $playlisttodisplay['title'] ?? '' ?></h3>
            <p><?= $playlisttodisplay['description'] ?? '' ?></p>
        </div>
        <?php endif ?>
    </div>
    <div class="bg-cus-9 py-4 px-8 br-y-2-s control-pannel">
        <div class="center-b w-full">
            <form  method="post" action="/controllers/TrackController.php">
                <button class="bg-cus-2 h-12 w-12 rounded-100 br-none pl-1 center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 384 512">
                        <path opacity="1" fill="black" d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/>
                    </svg>
                </button>
            </form>
            <div class="flex gap-y-2" >
                <button class="btn-1" type="submit">S'abonner</button>
                <?php if (($playlisttodisplay['user_id'] === $userdatas['id']) ||  $userdatas['role'] === 9):?>
                <?php if($_SERVER['REQUEST_URI'] === "/views/home.php?edit"): ?>
                    <label class="btn-1" for="updatePlaylistPicture"> Modifier Image</label>
                    <button class="btn-1" type="submit" name="bUpdatePlaylist" form="playlistFormUpdate">Confirmer</button>
                <?php else:?>
                    <a href="/views/home.php?edit" class="btn-1" type="button" >Editer</a>
                <?php endif?>
                <?php endif?>
            </div>
        </div>
    </div>      
    <table class="w-full collapse  tracks-table">
        <thead class="">
            <tr class="bg-black br-b-2-s w-full">
                <th class=" px-2 ta-s">#</th>
                <th class=" px-2 ta-s">Titre</th>
                <th class=" px-2 ta-s">Durée</th>
                <th class=" px-2 ta-s"></th>
            </tr>
        </thead>
        <tbody>
        <?php $tracks = ['John','Marc','Paul']?>
        <?php if($playlisttodisplaytracks):?>
        <?php foreach($playlisttodisplaytracks as $k => $playlisttodisplaytrack):?>
            <tr class="br-b-4-s br-cus-c-1 bg-cus-12 hovr-bg-cus-9 ">    
                <td class="py-2 px-2 ta-s">
                    <div class="flex align-items-c">
                    <p class="orderNumber w-5"><?= $k + 1?></p>
                        <button type="button"  class=" c-p bg-transparent border-none text-cus-7 hovr-text-cus-5 play-button  hidden"  value="<?= $playlisttodisplaytrack['audio_link']?>" onclick="playAudio(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 384 512">
                                <path opacity="1" fill="currentColor" d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/>
                            </svg>
                        </button>
                        <button type="button"  class=" c-p bg-transparent border-none text-cus-7 hovr-text-cus-5 hidden pause-button" value="<?= $playlisttodisplaytrack['audio_link']?>" onclick="pauseAudio(event)">
                            ok ?
                        </button>
                    </div>
                </td>
                <td class="py-2 px-2 ta-s "><?= $playlisttodisplaytrack['title']?></td>
                <?php 
                $durationInMilliseconds = $playlisttodisplaytrack['duration'];
                $seconds = $durationInMilliseconds / 1000;
                $roundedSeconds = round(fmod($seconds,60));
                $minutes = floor($seconds / 60);
                $hours = floor($minutes / 60);
                $trackDuration = sprintf('%02d:%02d:%02d',$hours,$minutes,$roundedSeconds);
                // var_dump($hours,$minutes,$seconds,$roundedSeconds,$trackDuration);

               ?>
                <td class="py-2 px-2 ta-s "><?= $trackDuration ?></td>
                <td class="py-2 px-2 ta-c ">...</td>
            </tr>
        <!-- <tr class="br-a-1-s br-cus-c-5"> -->
        <?php endforeach?>
        <?php endif ?>
        </tbody>
    </table>   
</article>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>