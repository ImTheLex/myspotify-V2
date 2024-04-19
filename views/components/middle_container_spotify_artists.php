<?php if($userdatas):?>
<article class="w-fit our-artist max-cont-500:w-full">
    <a class="block px-2 bg-cus-3 gap-y-4 rounded-2 pr-2 py-2 hovr-bg-cus-8 br-a-1-s br-cus-c-7 max-cont-500:flex max-cont-500:align-items-c  " href="<?= $ourartists ? "/controllers/ArtistController.php?bOpenArtist={$ourartists[$i]['id']}" : ''?>">
        <div class="w-36 h-36 c-p mb-5 max-cont-500:mb-0  max-cont-500:h-12 max-cont-500:w-12">
            <img class="img-cov rounded-1 br-a-1-s br-cus-c-7" src="<?= $tracksDatas ? $tracksDatas->tracks[$i]->album->images[0]->url : 'No image found' ?>" alt="Ceci est une image" loading="lazy">
        </div>
        <div class="ta-c max-cont-500:ta-s">
            <div class=" mx-auto c-p max-w-32">
                <h4 class="text-cus-5 truncate"><?= $tracksDatas->tracks[$i]->name ?? '' ?></h4>
                <p class="text-cus-7 truncate">Im a spotify artist come check us on the real site !</p>
            </div>
        </div>
    </a>  
</article>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>