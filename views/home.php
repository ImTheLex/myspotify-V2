<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/components/base_header.php' ?>

<?php 
// require_once $_SERVER['DOCUMENT_ROOT'] . "/config/spotify_access.php"
    
    
    // var_dump($_SESSION);
    ?>

    <!-- <div class="h-full"> -->

        <main class="gap-x-4 mx-4 center-b">
            <?php include './components/left_container_view.php'?>


            <?php include './components/middle_container_view.php'?>
        </main>
        
    <!-- </div> -->
<?php require $_SERVER['DOCUMENT_ROOT'] . '/views/components/base_footer.php' ?>
