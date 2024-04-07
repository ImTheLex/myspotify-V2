<?php if(isset($userdatas)):?>
<article class="mb-2 body-grad-4 rounded-s br-1-s br-cus-c-7">
    <a class="items-center gap-x-3 px-2 rounded-s pr-2 py-2 hovr-cus-7  hovr-bg-cus-8" href="<?= isset($playlistdatas,$playlistdatas[$i]['id']) && $playlistdatas ? "/controllers/PlaylistController.php?bOpenPlaylist={$playlistdatas[$i]['id']}" : ''?>">
        <div class="w-12 h-12 c-p">
            <img class="img-cov" src="<?= $playlistdatas[$i]['img'] ?? "" ?>" alt="Ceci est une image" loading="lazy">
        </div>
        <div class="center-b">
            <div class=" c-p ">
                <h4><?= $playlistdatas[$i]['title'] ?? '' ?></h4>
                <p><?= $playlistdatas[$i]['creator'] ?? '' ?></p>
            </div>
        </div>
    </a>
</article>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>