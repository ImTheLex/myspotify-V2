<?php if($userdatas):?>
<article class="p-rel td-5 mb-2 body-grad-3 playlist-left-container">
    <div class="center-b gap-y-3 px-2 w-full rounded-2 pr-2 py-2 hovr-cus-7 hovr-bg-cus-8 br-a-1-s br-cus-c-7">
        <a href='<?= isset($playlistitem) && $playlistitem ? "/controllers/PlaylistController.php?bOpenPlaylist={$playlistitem['id']}" : ''?>' class="flex justify-content-c align-items-c gap-y-3 w-3/5">
            <img class="br-a-1-s w-12 h-12 c-p img-cov" src="<?= $playlistitem['img']?>" alt="Ceci est une image" loading="lazy">
            <div class="center-b w-3/5">
                <div class="max-cont-230:hidden c-p w-full">
                    <h4 class="truncate p-a text-cus-5"><?= $playlistitem['title'] ?></h4>
                    <p class="truncate"><?= $playlistitem['creator'] ?></p>
                </div>
            </div>
        </a>
        <form class="w-12 h-12 center c-p mr-4" action="/controllers/PlaylistController.php" method="post">
            <?php if ($playlistitem['user_id'] == $userdatas['id']):?>
                <input type="hidden" value="<?= $playlistitem['id'] ?>" name="deletePlaylistId">
                <button type="submit" class="c-p bg-transparent br-none appearance-none" aria-label="supprimer playlist" name="bDropPlaylist">
                    <svg class=" hovr-text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor"d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                    </svg>
                </button>
            <?php else:?>
            Tu n'es pas créateur
            <?php endif;?>
        </form>
    </div>
</article>

<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>