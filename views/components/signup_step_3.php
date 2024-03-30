<?php if(!isset($userdatas)):?>

<!-- Résumé -->
<h2 class="mx-auto mb-3">Resumé</h2>
<div class="d-gd mb-3 gap-y-2 grid-col-2">
    <p id="emailResume">Votre email: </p>
    <p id="userNameResume">Votre nom d'utilisateur: </p>
    <p id="sexResume">Votre genre: </p>
    <p id="dateResume">Votre date de naissance: </p>
</div>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>