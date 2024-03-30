<?php if(isset($userdatas)):?>

<article class="pt-16" >
    <div>
        <div class="mb-8 ml-4  gap-x-4 items-center">
            <div class="w-30 h-30">
                <img class="img-cov" src="<?= $playlisttodisplay['img']?>" alt="">
            </div>
            <div>
                <p><?= $playlisttodisplay['privacy']  === 1 ? "Playlist publique": "Playlist privée"?> </p>
                <h2><?= $playlisttodisplay['title']?></h2>
                <p><?= $playlisttodisplay['description']?></p>
            </div>
            <?php if ($playlisttodisplay['user_id'] === $userdatas['id']):?>
                <button class="flex-col br-1-s br-cus-c-7 text-cus-7 rounded-xs c-p px-4 py-2 ta-c w-fit bg-cus-3 td-3 hovr-bx-shadow-cus-2" onclick="display_edit_playlist(event)">Editer</button>
            <?php endif?>
        </div>
           
    </div>
    <div class="hidden" id="updatePlaylistForm">
        <form class="mb-8 ml-4  gap-x-4 items-center" method="post" action="/controllers/PlaylistController.php">
            <div class="w-30 h-30">
                <img class="img-cov" src="<?= $playlisttodisplay['img']?>" alt="">
                <label class="flex-col br-1-s br-cus-c-7 text-cus-7 rounded-xs c-p px-4 py-2 ta-c w-fit bg-cus-3 td-3 hovr-bx-shadow-cus-2" for="updatePlaylistPicture" onmouseup="remove_color(event)" onmousedown="add_color(event)">Modifier
                    <input class="hidden" type="file" name="updatePlaylistPicture" id="updatePlaylistPicture">
                </label>
            </div>
            <div>
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
            </div>
            <input type="hidden" name="updatePlaylstId" value="<?= $playlisttodisplay['id']?>">
            <button class="flex-col br-1-s br-cus-c-7 text-cus-7 rounded-xs c-p px-4 py-2 ta-c w-fit bg-cus-3 td-3 hovr-bx-shadow-cus-2" name="bUpdatePlaylist">Confirmer</button>
        </form>
    </div>
    <div>
        <table class="w-full br-col">
            <thead>
                <tr class="bg-black br-1-s w-full">
                    <th class="py-4 px-2 ta-s">#</th>
                    <th class=" py-4 px-2 ta-s">Titre</th>
                    <th class=" py-4 px-2 ta-s">duation</th>
                    <th class="py-4 px-2 ta-s">options</th>
                </tr>
            </thead>
            <tbody >
            <tr class="br-4-s-t br-cus-c-5">
                    <?php $tracks = ['John','Marc','Paul']?>
                    <?php foreach($tracks as $k => $track):?>
                        

                        <!-- <td> . track . </td><td> . track . </td></tr>   -->
                    <td class="bg-cus-3 py-2 mb-2 px-2 ta-s hovr-bg-cus-9"><?= $track[$k] ?></td>
                    <td class="bg-cus-3 py-2 mb-2 px-2 ta-s hovr-bg-cus-8"><?= $track ?></td>
                </tr> <tr class="br-1-s br-cus-c-5">

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