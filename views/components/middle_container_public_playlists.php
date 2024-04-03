<?php if(isset($userdatas)):?>

<article class="mb-2 w-fit">
    <div class=" items-center gap-x-3 px-2 rounded-s pr-2 py-2 hovr-cus-7 hovr-bg-cus-8 br-1-s br-cus-c-7">
        <a href="<?= isset($publicplaylists) && $publicplaylists ? "/controllers/PlaylistController.php?bOpenPlaylist={$publicplaylists[$i]['id']}" : ''?>" >
            <div class="h-36 max-w-36 c-p mb-5">
                <img class="img-cov" src="<?= $publicplaylists[$i]['img'] ?? '' ?>" alt="Ceci est une image" loading="lazy">
            </div>
            <div class="ta-c w-full">
                <div class=" mx-auto c-p max-w-32">
                    <h4 class="text-cus-5 truncate"><?= $publicplaylists[$i]['title'] ?? '' ?></h4>
                    <p class="text-cus-7"><?= $publicplaylists[$i]['creator'] ?? '' ?></p>
                </div>
            </div>
        </a>
    </div>  
</article>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>