<?php if($userdatas && $artisttodisplay):?>

<article class="">
    <div class="p-rel flex gap-y-4 h-vh-3 overlay-2/5">
        <img class="img-cov" src="<?= $artisttodisplay['profile_picture']?>" id="artistImg" alt="">
        <?php if (isset($_GET['edit']) && (($userdatas['id'] === $artisttodisplay['user_id']) || $userdatas['role'] === 9)):?>
        <form method="post" class="p-abs zi-1 grid grid-col-2 align-content-c gap-y-4 mx-4 mb-5 pt-15" action="/controllers/ArtistController.php" enctype="multipart/form-data" id="artistFormUpdate">
            <input class="hidden" type="file" onchange="previewImageArtist()" name="updateArtistPicture" id="updateArtistPicture">
            <label class=" flex-col fw-6 text-white" for="updateArtistName">Nom
                <input class="input" type="text" name="updateArtistName" id="updateArtistName" value="<?= $artisttodisplay['name']?>">
            </label>
            <label class="flex-col fw-6 text-white" for="updateArtistDescription">Description
                <input class="input" type="text" name="updateArtistDescription" id="updateArtistDescription" value="<?= $artisttodisplay['description']?>">
            </label>
            <input type="hidden" name="updateArtistId" value="<?= $artisttodisplay['id']?>">
        </form>
        <?php else:?>
        <div class="p-abs zi-1 text-cus-5 w-full h-full flex-col justify-content-c px-12 mb-5 pt-15">
            <p>Artiste</p>
            <h3 class="mb-5"><?= $artisttodisplay['name'] ?? ''?></h3>
            <p><?= $artisttodisplay['description'] ?? 'Coucou' ?></p>
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
                <?php if (($artisttodisplay['user_id'] === $userdatas['id']) ||  $userdatas['role'] === 9):?>
                <?php if($_SERVER['REQUEST_URI'] === "/views/home.php?edit"): ?>
                    <label class="btn-1" for="updateArtistPicture"> Modifier Image</label>
                    <a href="/views/home.php?create_track" class="btn-1">Ajouter un morceau</a>
                    <button class="btn-1" type="submit" name="bUpdateArtist" form="artistFormUpdate">Confirmer</button>
                <?php else:?>
                    <a href="/views/home.php?edit" class="btn-1" type="button" >Editer</a>
                <?php endif?>
                <?php endif?>
            </div>
        </div>
    </div>
    <?php if(isset($_GET['create_track'])):?>
    <form action="/controllers/TracksController.php" method="post" class="grid grid-col-2 align-content-c gap-y-4 mx-4 mb-5" id="createTrackForm">
        <?= SessionManager::getSession('error')['model_track_creation'] ?? false; ?>
        <?= SessionManager::getSession('success')['create_track'] ?? false; ?>
        <label class="flex-col mb-5 mt-2" for="createTrackTitle">Titre
            <input type="text" class="input" name="createTrackTitle" id="createTrackTitle">
        </label>
        <label class="flex-col mb-5 mt-2" for="createTrackLink">Lien audio
            <input type="text" class="input" name="createTrackLink" id="createTrackLink">
        </label>
        <input type="hidden" name="createTrackDuration" id="createTrackDuration">
        <button type="submit" class="btn-1 my-1" name="bCreateTrack">Confirmer</button>
    </form>
    <?php endif ?>  
    <table class="w-full collapse tracks-table">
        <thead class="">
            <tr class="bg-black br-b-2-s w-full">
                <th class=" px-2 ta-s">#</th>
                <th class=" px-2 ta-s">Titre</th>
                <th class=" px-2 ta-s">Durée</th>
                <th class=" px-2 ta-s"></th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($artisttodisplaytracks)):?>
        <?php foreach($artisttodisplaytracks as $k => $artisttodisplaytrack):?>
            <tr class="br-b-4-s br-cus-c-1 bg-cus-12 hovr-bg-cus-9 ">    
                <td class="py-2 px-2 ta-s">
                    <div class="flex align-items-c">
                    <p class="orderNumber w-5"><?= $k + 1?></p>
                        <button type="button"  class=" c-p bg-transparent border-none text-cus-7 hovr-text-cus-5 play-button  hidden"  value="<?= $artisttodisplaytrack['audio_link']?>" onclick="playAudio(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 384 512">
                                <path opacity="1" fill="currentColor" d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/>
                            </svg>
                        </button>
                        <button type="button"  class=" c-p bg-transparent border-none text-cus-7 hovr-text-cus-5 hidden pause-button" value="<?= $artisttodisplaytrack['audio_link']?>" onclick="pauseAudio(event)">
                            ok ?
                        </button>
                    </div>
                </td>
                <td class="py-2 px-2 ta-s "><?= $artisttodisplaytrack['title']?></td>
                <?php 
                $durationInMilliseconds = $artisttodisplaytrack['duration'];
                $seconds = $durationInMilliseconds / 1000;
                $roundedSeconds = round(fmod($seconds,60));
                $minutes = floor($seconds / 60);
                $hours = floor($minutes / 60);
                $trackDuration = sprintf('%02d:%02d:%02d',$hours,$minutes,$roundedSeconds);
                // var_dump($hours,$minutes,$seconds,$roundedSeconds,$trackDuration);

               ?>
                <td class="py-5 px-2  ta-s "><?= $trackDuration ?></td>
                <td class="py-2 px-2 ta-c ">
                    <?php if($_SERVER['REQUEST_URI'] === '/views/home.php?bAddTrackRelation'):?>
                    <?php if($playlistdatas):?>
                    <form action="/controllers/TracksController.php" method="post">
                        <input type="hidden" value="<?= $artisttodisplaytrack['id']?>" name="trackRelationId">
                        <select class="input border-ridge px-2" name="playlistRelationId">
                        <?php foreach($playlistdatas as $playlistdata):?>
                            <option class="text-black px-2" value="<?=$playlistdata['id']?>"><?=$playlistdata['title']?></option>
                        <?php endforeach?>
                        </select>
                        <button class="btn-1" type="submit" name="bCreateTrackRelation">Add</button>
                    </form>
                    <?php else:?>
                    <p>Veuillez créer une playlist</p>
                    <?php endif;?>
                    <?php else:?>                 
                    <a class="btn-1" href='<?= "/views/home.php?bAddTrackRelation"?>'>Ajoute</a>
                    <?php endif?> 
                </td>
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