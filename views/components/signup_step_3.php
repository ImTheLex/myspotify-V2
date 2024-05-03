<?php if(!$userdatas):?>

<!-- Résumé -->
<h2 class="mx-auto mb-3">Resumé</h2>
<div class="grid mb-3 gap-x-2 grid-col-2">
    <p id="userNameResume">Votre nom d'utilisateur: </p>
    <?= $signupStep1Datas  ?  '<p class="text-cus-2"> ' . $signupStep1Datas['createUsername'] . '</p>': '<p style="color:red;" Erreur"</p>'?>
    <p id="emailResume">Votre email: </p> 
    <?= $signupStep1Datas  ?  '<p class="text-cus-2"> ' . $signupStep1Datas['createUserEmail'] . '</p>': '<p style="color:red;" Erreur"</p>'?> 
    <p><?= SessionManager::getSession('createUserEmail') ?? '<p style="color:red;" Erreur"</p>'?></p>
    <p id="dateResume">Votre date de naissance: </p>
    <?= $signupStep2Datas  ?  '<p class="text-cus-2"> ' . $signupStep2Datas['createUserBirth'] . '</p>': '<p style="color:red;" Erreur"</p>'?> 
    <p><?= SessionManager::getSession('createUserBirth')?? '<p style="color:red;" Erreur"</p>' ?></p>
    <p id="sexResume">Votre genre: </p>
    <?= isset($signupStep2Datas)  ?  '<p class="text-cus-2"> ' . $signupStep2Datas['createUserGender'] . '</p>': '<p style="color:red;" Erreur"</p>'?> 
    <p><?= SessionManager::getSession('createUserBirth')  ?? '<p style="color:red;" Erreur"</p>'?></p>
</div>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>