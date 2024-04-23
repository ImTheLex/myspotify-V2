<?php if(!$userdatas):?>
<!-- Username -->
<label class="flex-col mb-5" for="createUsername">Choisissez un nom d'utilisateur
    <input class="input" type="text" name="createUsername" id="createUsername" value="<?= SessionManager::getSession('createUsername') ?? ''?>" required autofocus>
    <p style="color: red;" id="createUsernameError" class="hidden">Username invalide</p>
    <?= SessionManager::getSession('error')['sign_up_username'] ?? ""?> 
</label>

<!-- Mail -->
<label class="flex-col mb-5" for="createUserEmail">Entrez une adresse mail valide
    <input class="input"  type="email" name="createUserEmail" id="createUserEmail" value="<?= SessionManager::getSession('createUserEmail') ?? ''?>" required>
    <p style="color: red;" id="createUserEmailError" class="hidden">Email invalide</p> 
    <?= SessionManager::getSession('error')['sign_up_email'] ?? ""?> 
</label>

<!-- Password -->
<label class="flex-col mb-5" for="createUserPassword">Choisissez un mot de passe
    <input class="input" type="password" name="createUserPassword" id="createUserPassword" required>
</label>

<label class="flex-col mb-5" for="createUserPassword1">Confirmez votre mot de passe
    <input class="input" type="password" name="createUserPassword1" id="createUserPassword1" required>
    <p style="color: red;" id="signUpPasswordsError" class="hidden">Les mots de passes ne sont pas identiques </p>
</label>



<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>