<?php if(isset($userdatas)):?>

<article class="pt-16" >
    <div>
        <div class="mb-8 ml-4  gap-x-4 items-center">
            <div class="h-30 w-30">
                <img class="img-cov br-1-s" src="<?= $playlisttodisplay['img']?>" id="playlistUpdatePicture" alt="">
            </div>
            <div> 
                <?php if (isset($_GET['edit']) && ($userdatas['id'] === $playlisttodisplay['user_id'])):?>
                    <form method="post" action="/controllers/PlaylistController.php" enctype="multipart/form-data">
                        <input class="hidden" type="file" onchange="previewImagePlaylist()" name="updatePlaylistPicture" id="updatePlaylistPicture">
                        <label class="flex-col" for="updatePlaylistPrivacy">Privacy
                            <select  class="input" name="updatePlaylistPrivacy" id="updatePlaylistPrivacy" value ="<?= $playlisttodisplay['privacy'] == 0 ? 0  : 1 ?>" >
                                <option class="text-black px-2" value="0" <?= $playlisttodisplay['privacy'] == 0 ? "selected"  : "" ?>  >Privée</option>
                                <option class="text-black px-2" value="1" <?= $playlisttodisplay['privacy'] == 1 ? "selected"  : "" ?>  >Publique</option>
                            </select>
                        </label>
                        <label class="flex-col" for="updatePlaylistTitle">Title
                            <input class="input" type="text" name="updatePlaylistTitle" id="updatePlaylistTitle" value="<?= $playlisttodisplay['title']?>">
                        </label>
                        <label class="flex-col" for="updatePlaylistDescription">Description
                            <input class="input" type="text" name="updatePlaylistDescription" id="updatePlaylistDescription" value="<?= $playlisttodisplay['description']?>">
                        </label>
                        <input type="hidden" name="updatePlaylstId" value="<?= $playlisttodisplay['id']?>">
                        <button class=" hidden br-a-1-s br-cus-c-7 text-cus-7 rounded-1 c-p px-4 py-2 ta-c w-fit bg-cus-3 td-3 hovr-bx-shadow-cus-2" name="bUpdatePlaylist">Confirmer</button>
                    </form>
                <?php else:?>
                    <p><?= $playlisttodisplay['privacy'] === 1 ? 'Playlist privée' : 'Playlist publique' ?></p>
                    <h3><?= $playlisttodisplay['title'] ?? '' ?></h3>
                    <p><?= $playlisttodisplay['description'] ?? '' ?></p>
                <?php endif ?>
            </div>
        </div>
        <div class="bg-cus-9 py-4 px-8 br-y-2-s control-pannel">
            <form class="center-b w-full" action="">
                <button class="bg-cus-2 h-12 w-12 rounded-100 br-none pl-1 center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 384 512">
                        <path opacity="1" fill="black" d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/>
                    </svg>
                </button>
                <div>
                    <button class="btn-1" type="submit">S'abonner</button>
                    <?php if (($playlisttodisplay['user_id'] === $userdatas['id']) ||  $userdatas['role'] === 9):?>
                        <label class="btn-1" for="updatePlaylistPicture"> Modifier Image</label>
                        <button class="btn-1" type="button" onclick="display_edit_playlist()">Editer</button>
                    <?php endif?>
                </div>
            </form>
        </div>      
    </div>
    <div class="hidden" id="updatePlaylistForm">
        <!-- <form class="mb-8 ml-4  gap-x-4 items-center" method="post" action="/controllers/PlaylistController.php" enctype="multipart/form-data">
            <div class="w-30 h-30">
                <img class="img-cov" src="<?php $playlisttodisplay['img']?>" id="playlistUpdatePicture" alt="">
                <input class="hidden" type="file" onchange="previewImagePlaylist()" name="updatePlaylistPicture" id="updatePlaylistPicture">
                <label class="flex-col br-a-1-s br-cus-c-7 text-cus-7 rounded-1 c-p px-4 py-2 ta-c w-fit bg-cus-3 td-3 hovr-bx-shadow-cus-2" for="updatePlaylistPicture">Modifier</label>
            </div> -->
            <!-- <div>
                <label class="flex-col" for="updatePlaylistPrivacy">Privacy
                    <select  class="input" name="updatePlaylistPrivacy" id="updatePlaylistPrivacy" value ="<?php $playlisttodisplay['privacy'] == 0 ? 0  : 1 ?>" >
                        <option class="text-black px-2" value="0" <?php $playlisttodisplay['privacy'] == 0 ? "selected"  : "" ?>  >Privée</option>
                        <option class="text-black px-2" value="1" <?php $playlisttodisplay['privacy'] == 1 ? "selected"  : "" ?>  >Publique</option>
                    </select>
                </label>
                <label class="flex-col" for="updatePlaylistTitle">Title
                    <input class="input" type="text" name="updatePlaylistTitle" id="updatePlaylistTitle" value="<?php $playlisttodisplay['title']?>">
                </label>
                <label class="flex-col" for="updatePlaylistDescription">Description
                    <input class="input" type="text" name="updatePlaylistDescription" id="updatePlaylistDescription" value="<?php $playlisttodisplay['description']?>">
                </label>
            </div>
            <input type="hidden" name="updatePlaylstId" value="<?php $playlisttodisplay['id']?>">
            <button class="flex-col br-a-1-s br-cus-c-7 text-cus-7 rounded-1 c-p px-4 py-2 ta-c w-fit bg-cus-3 td-3 hovr-bx-shadow-cus-2" name="bUpdatePlaylist">Confirmer</button>
        </form> -->
    </div>
    <div>
        <table class="w-full br-col">
            <thead>
                <tr class="bg-black br-b-2-s w-full">
                    <th class="py-4 px-2 ta-s">#</th>
                    <th class=" py-4 px-2 ta-s">Titre</th>
                    <th class=" py-4 px-2 ta-s">duration</th>
                    <th class="py-4 px-2 ta-s">options</th>
                </tr>
            </thead>
            <tbody >
                <?php $tracks = ['John','Marc','Paul']?>
                <?php foreach($tracks as $k => $track):?>
                    <tr class="br-4-s-t br-cus-c-5">    
                        <td class="bg-cus-3 py-2 br-b-1-s br-cus-5 px-2 ta-s hovr-bg-cus-9"><?= $track[$k]?></td>
                        <td class="bg-cus-3 py-2 px-2 ta-s hovr-bg-cus-9"><?= $track[$k]?></td>
                        <td class="bg-cus-3 py-2 px-2 ta-s hovr-bg-cus-8"><?= $track ?></td>
                    </tr>
            <!-- <tr class="br-a-1-s br-cus-c-5"> -->

                <?php endforeach?>
            </tbody>
        </table>   
    </div>
</article>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>