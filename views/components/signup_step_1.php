<?php if(!isset($userdatas)):?>
<!-- Mail -->
<label class="flex-col mb-5" for="signUpEmail">Entrez une adresse mail valide
    <input class="input"  type="email" name="signUpEmail" id="signUpEmail" required title="Attention, le formulaire ne correspond pas aux attentes." onchange="validateForm()">
    <p style="color: red;" id="signupEmailError" class="hidden">Email invalide</p> 
    <?= SessionManager::getSession('error')['signUpEmail'] ?? ""?> 
</label>

<!-- Password -->
<label class="flex-col mb-5" for="signUpPassword1">Choisissez un mot de passe
    <input class="input" type="password" name="signUpPassword1" id="signUpPassword1" onchange="validateForm()" required>
</label>

<label class="flex-col mb-5" for="signUpPassword2">Confirmez votre mot de passe
    <input class="input" type="password" name="signUpPassword2" id="signUpPassword2" onchange="validateForm()" required>
    <p style="color: red;" id="signUpPasswordsError" class="hidden">Les mots de passes ne sont pas identiques </p>
</label>


<!-- Username -->
<label class="flex-col mb-5" for="signUpUsername">Choisissez un nom d'utilisateur
    <input class="input" type="text" name="signUpUsername" id="signUpUsername" onchange="validateForm()" required>
    <p style="color: red;" id="signUpUsernameError" class="hidden">Username invalide</p>
    <?= SessionManager::getSession('error')['signUpUsername'] ?? ""?> 
</label>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>