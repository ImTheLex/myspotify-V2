<?php include 'components/base_header.php' ?> 
<?php if(isset($userdatas)):
    
    
    ?>
    <!-- Form profile -->
    <h1 class="login-card rounded-s br-cus-c-2 br-1-s px-12 py-2 text-cus-5 bg-cus-6 mx-auto ta-c">Bonjour <?= $userdatas['username']?>!</h1>

    <form class="login-card rounded-s p-2 gap-y-2 br-cus-c-2 br-1-s text-cus-5 px-12 py-8 bg-cus-6 border mx-auto " action="/controllers/AuthController.php" method="post" enctype="multipart/form-data">
        <div class="d-fx jc-sb">
            <div class="d-fx gap-x-3 ml-auto">
                <div class="d-fx col-a">
                    <h2>Ma photo</h2>
                    <input class="hidden" type="file" name="userImgUpdate" id="userImgUpdate" onchange="previewImage()">
                    <label class="br-1-s br-cus-c-7 text-cus-1 rounded-xs c-p px-4 py-2 ta-c w-fit bg-cus-5 td-3 hovr-bx-shadow-cus-2" for="userImgUpdate">
                        Modifier
                    </label>
                </div>         
                <div class="w-28 h-28 max-w-28 max-h-28 br-cus-c-7 br-1-s rounded-sm overf-h" >
                    <img id="profileUpdatePicture"class=" profile-picture" src="<?= DIRECTORY_SEPARATOR .  $userdatas['profile_picture'] ?>" alt="Image de profile">
                </div>
            </div>
        </div>
        <?= SessionManager::getSession('success')['update_user'] ?? '' ?>
        <?= SessionManager::getSession('error')['usernameUpdate'] ?? '' ?>
        <?= SessionManager::getSession('error')['userEmailUpdate'] ?? '' ?>
        <!-- Username -->
        <label class="flex-col mb-5 fw-6" for="usernameUpdate">Votre nom d'utilisateur
            <input class="input" type="text" name="usernameUpdate"id="usernameUpdate" value="<?= $userdatas['username'] ?>">
        <?= SessionManager::getSession('error')['update_username'] ?? '' ?>
        </label>
        <!-- Mail -->
        <label class="flex-col mb-5 fw-6" for="userEmailUpdate">Votre adresse mail
            <input class="input" type="email" name="userEmailUpdate" id="userEmailUpdate" value="<?= $userdatas['email']?>">
        <?= SessionManager::getSession('error')['update_email'] ?? ''?>
        </label>
        <!-- Date -->
        <label class="flex-col mb-5 fw-6"  for="userBirthUpdate">Votre date de naissance
            <input class="input" type="date" name="userBirthUpdate" id="userBirthUpdate" value="<?= $userdatas['birth']?>">
        </label>
        <!-- gender -->
        <label class="flex-col mb-5 fw-6"  for="userGenderUpdate">Votre genre
            <select class="input" name="userGenderUpdate" id="userGenderUpdate" value="<?= $userdatas['gender']?>">
                <option <?= $userdatas['gender'] === 'Male' ? 'selected' : '' ?> class="text-black px-2" value="Male">M</option>
                <option <?= $userdatas['gender'] === 'Female' ? 'selected' : '' ?> class="text-black px-2" value="Female">F</option>
                <option <?= $userdatas['gender'] === 'No-binary' ? 'selected' : '' ?> class="text-black px-2" value="No-binary">Non-binaire</option>
                <option <?= $userdatas['gender'] === 'Other' ? 'selected' : '' ?> class="text-black px-2" value="Other">Autre</option>
                <option <?= $userdatas['gender'] === 'No-comment' ? 'selected' : '' ?> class="text-black px-2" value="No-comment">Ne se prononce pas</option>
            </select>
        </label> 
        <div class="center-b">
            <button class="br-1-s br-cus-c-7 text-cus-1 rounded-xs c-p px-4 py-2 ta-c w-fit bg-cus-5 td-3 hovr-bx-shadow-cus-2" type="submit" name="bUserUpdate">Confirmer</button>
            <button class=" br-1-s br-cus-c-7 text-cus-7 rounded-xs c-p px-4 py-2 ta-c w-fit bg-cus-3 td-3 hovr-bx-shadow-cus-2" type="submit" name="bPasswordUpdate">Changer Mot de passe</button>
            <button class=" br-1-s br-cus-c-7 text-cus-7 rounded-xs c-p px-4 py-2 ta-c w-fit bg-cus-10 td-3 hovr-bx-shadow-cus-2" type="submit" name="bUserDelete">Supprimer le compte</button>
        </div>
        <input type="hidden" value="<?= $userdatas['id']?>" name="user_id">
    </form>
    <?php else:
    header("Location: /views/home.php");
    exit;
endif; 
    ?>
<?php include 'components/base_footer.php' ?>
