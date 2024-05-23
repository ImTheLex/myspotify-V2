<?php if(!$userdatas):?>

<!-- Résumé -->
<h2 class="mx-auto mb-3">Resumé</h2>
<div class="grid mb-3 gap-x-2 gap-y-2 grid-col-2">

    <p id="userNameResume" class="max-cont-480:grid-col-span-2 truncate">Votre nom d'utilisateur: </p>
    <?= $signupStep1Datas  ?  '<p class="text-cus-2 max-cont-480:grid-col-span-2 truncate"> ' . $signupStep1Datas['createUsername'] . '</p>': '<p style="color:red;" Erreur"</p>'?>

    <p id="emailResume" class="max-cont-480:grid-col-span-2 truncate">Votre email: </p> 
    <?= $signupStep1Datas  ?  '<p class="text-cus-2 max-cont-480:grid-col-span-2 truncate"> ' . $signupStep1Datas['createUserEmail'] . '</p>': '<p style="color:red;" Erreur"</p>'?> 

    <p id="dateResume" class="max-cont-480:grid-col-span-2 max-cont-480:grid-col-span-2 truncate">Votre date de naissance: </p>
    <?= $signupStep2Datas  ?  '<p class="text-cus-2 max-cont-480:grid-col-span-2"> ' . $signupStep2Datas['createUserBirth'] . '</p>': '<p class="text-red"; >Erreur</p>'?> 

    <p id="sexResume" class="max-cont-480:grid-col-span-2 truncate">Votre genre: </p>
    <?= isset($signupStep2Datas)  ?  '<p class="text-cus-2 max-cont-480:grid-col-span-2"> ' . $signupStep2Datas['createUserGender'] . '</p>': '<p style="color:red;" Erreur"</p>'?> 

    <p id="sexResume" class="max-cont-480:grid-col-span-2 truncate">Compte artiste: </p>
    <?= isset($signupStep2Datas)  ?  '<p class="text-cus-2 max-cont-480:grid-col-span-2"> ' . $signupStep2Datas['signUpArtist'] . '</p>': '<p style="color:red;" Erreur"</p>'?> 

</div>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>