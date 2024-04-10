<?php if(isset($userdatas)):?>

<article class="mb-2" onclick="open_playlist()">
    <div class="flex justify-content-c align-items-cgap-x-3 px-2 rounded-2 pr-2 py-2 hovr-cus-7 hovr-bg-cus-8 br-a-1-s br-cus-c-7">
        <div class="w-12 h-12 c-p">
            <img class="img-cov" src="<?php echo $tracksDatas->tracks[$i]->album->images[2]->url ?>" alt="Ceci est une image" loading="lazy">
        </div>
        <div class="center-b w-full">
            <div class=" c-p ">
                <h4><?php echo $tracksDatas->tracks[$i]->name ?></h4>
                <p><?php echo $tracksDatas->tracks[$i]->artists[0]->name ?></p>
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