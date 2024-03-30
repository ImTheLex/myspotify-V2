<?php if(isset($userdatas)):?>

<article class="mb-2" onclick="open_playlist(<?= $publicPlaylists[$i]['id'] ?>)">
    <div class="items-center gap-x-3 px-2 rounded-s pr-2 py-2 hovr-cus-7 hovr-bg-cus-8 br-1-s br-cus-c-7">
        <div class="w-12 h-12 c-p">
            <img class="img-cov" src="<?= $publicPlaylists[$i]['img'] ?? $images[rand(0,4)] ?>" alt="Ceci est une image" loading="lazy">
        </div>
        <div class="center-b w-full">
            <div class=" c-p ">
                <h4><?= $publicPlaylists[$i]['title'] ?? '' ?></h4>
                <p><?= $playlist->get_creator_name($publicPlaylists[$i]['user_id'])?? '' ?></p>
            </div>
                <div class="center mr-4">
                    ookok
                </div>
        </div>
    </div>
</article>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>