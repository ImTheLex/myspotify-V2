<?php if($userdatas && $artisttodisplay):?>

<article class="" >
    <div class="p-rel flex gap-y-4 h-vh-3">
        <img class="img-cov" src="<?= $artisttodisplay['profile_picture']?>" id="artistImg" alt="">
        <?php if (isset($_GET['edit']) && ($userdatas['id'] === $artisttodisplay['user_id'])):?>
        <form method="post" class="p-abs grid grid-col-2 align-content-c gap-y-4 mx-4 mb-5 pt-15" action="/controllers/ArtistController.php" enctype="multipart/form-data" id="artistFormUpdate">
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
        <div class="p-abs w-full h-full flex-col justify-content-c px-12 mb-5 pt-15">
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
                    <button class="btn-1" type="submit" name="bUpdateArtist" form="artistFormUpdate">Confirmer</button>
                <?php else:?>
                    <a href="/views/home.php?edit" class="btn-1" type="button" >Editer</a>
                <?php endif?>
                <?php endif?>
            </div>
        </div>
    </div>      
    <table class="w-full collapse">
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
        <?php foreach($tracks as $k => $track):?>
            <tr class="br-b-4-s br-cus-c-1 bg-cus-12 hovr-bg-cus-9">    
                <td class="py-2 px-2 ta-s "><?= $track[$k]?></td>
                <td class="py-2 px-2 ta-s"><?= $track[$k]?></td>
                <td class="py-2 px-2 ta-s "><?= $track ?></td>
                <td class="py-2 px-2 ta-c ">...</td>
            </tr>
        <!-- <tr class="br-a-1-s br-cus-c-5"> -->
        <?php endforeach?>
        </tbody>
    </table>   
</article>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>