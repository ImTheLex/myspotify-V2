<?php if(isset($userdatas)):?>

<article class="mb-2 w-fit public-playlist">
    <a class="block px-2 bg-cus-3 rounded-s pr-2 py-2 hovr-bg-cus-8 br-1-s br-cus-c-7" href="<?= isset($publicplaylists) && $publicplaylists ? "/controllers/PlaylistController.php?bOpenPlaylist={$publicplaylists[$i]['id']}" : ''?>">
        <div class="w-36 h-36 c-p mb-5 ">
            <img class="img-cov rounded-xs br-1-s br-cus-c-7" src="<?= $publicplaylists[$i]['img'] ?? '' ?>" alt="Ceci est une image" loading="lazy">
        </div>
        <div class="ta-c">
            <div class=" mx-auto c-p max-w-32">
                <h4 class="text-cus-5 truncate"><?= $publicplaylists[$i]['title'] ?? '' ?></h4>
                <p class="text-cus-7"><?= $publicplaylists[$i]['creator'] ?? '' ?></p>
            </div>
        </div>
    </a>  
</article>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>