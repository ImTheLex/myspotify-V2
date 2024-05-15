<?php include 'components/base_header.php' ?> 
<?php if($userdatas):
    if($userdatas['role'] === 9 && $_SERVER['REQUEST_URI'] === '/views/profile.php?userProfile'){
        $viewUserProfile = SessionManager::getSession('adminViewUserProfileInfos') ?? false;
    }
    else{
        SessionManager::unsetSession('adminViewUserProfileInfos');
    }
    // var_dump($viewUserProfile);

    
    ?>
    <section data-id="profile">
        <div class="col-b gap-x-2 mx-auto w-1/2 make-container:profile-container profile-container min-w-80 ">
            <h1 class=" rounded-2 br-cus-2 br-a-1-s px-12 py-2 text-cus-5 bg-cus-4 ta-c truncate">Bonjour <?= $viewUserProfile['username'] ?? $userdatas['username']?>!</h1>

            <form class="rounded-2 p-2 br-cus-2 br-a-1-s text-cus-5 px-12 py-8 body-grad-2 h-vh-6 overf-a" action="/controllers/AuthController.php" method="post" enctype="multipart/form-data">
                <div class="flex justify-content-b">
                    <div class="flex gap-y-3 ml-auto">
                        <div class="col-a">
                            <h2 class="max-cont-370:fs-5">Ma photo</h2>
                            <input class="hidden" type="file" name="userImgUpdate" id="userImgUpdate" onchange="previewImage()">
                            <label class="br-a-1-s br-cus-c-7 text-cus-1 rounded-1 c-p px-4 py-2 ta-c bg-cus-5 td-3 hovr-bg-black hovr-text-white" for="userImgUpdate">
                                Modifier
                            </label>
                        </div>         
                        <div class="w-28 h-28 max-w-28 max-h-28 br-cus-c-7 br-a-1-s rounded-3 overf-h" >
                            <img id="profileUpdatePicture"class=" profile-picture" src="<?= DIRECTORY_SEPARATOR . ($viewUserProfile['profile_picture'] ?? $userdatas['profile_picture']) ?>" alt="Image de profile">
                        </div>
                    </div>
                </div>
                <?= SessionManager::getSession('success')['update_user'] ?? '' ?>
                <?= SessionManager::getSession('error')['usernameUpdate'] ?? '' ?>
                <?= SessionManager::getSession('error')['userEmailUpdate'] ?? '' ?>
                <!-- Username -->
                <label class="flex-col mb-3 fw-6" for="usernameUpdate">Votre nom d'utilisateur
                    <input class="input" type="text" name="usernameUpdate"id="usernameUpdate" value="<?= $viewUserProfile['username'] ?? $userdatas['username'] ?>">
                <?= SessionManager::getSession('error')['update_username'] ?? '' ?>
                </label>
                <!-- Mail -->
                <label class="flex-col mb-3 fw-6" for="userEmailUpdate">Votre adresse mail
                    <input class="input" type="email" name="userEmailUpdate" id="userEmailUpdate" value="<?= $viewUserProfile['email'] ?? $userdatas['email']?>">
                <?= SessionManager::getSession('error')['update_email'] ?? ''?>
                </label>
                <!-- Date -->
                <label class="flex-col mb-3 fw-6"  for="userBirthUpdate">Votre date de naissance
                    <input class="input" type="date" name="userBirthUpdate" id="userBirthUpdate" value="<?= $viewUserProfile['birth'] ?? $userdatas['birth']?>">
                </label>
                <!-- gender -->
                <label class="flex-col mb-3 fw-6"  for="userGenderUpdate">Votre genre
                    <select class="input" name="userGenderUpdate" id="userGenderUpdate">
                        <option <?= ($viewUserProfile['gender'] ?? $userdatas['gender']) === 'Male' ? 'selected' : '' ?> class="text-black px-2" value="Male">M</option>
                        <option <?= ($viewUserProfile['gender'] ?? $userdatas['gender']) === 'Female' ? 'selected' : '' ?> class="text-black px-2" value="Female">F</option>
                        <option <?= ($viewUserProfile['gender'] ?? $userdatas['gender']) === 'No-binary' ? 'selected' : '' ?> class="text-black px-2" value="No-binary">Non-binaire</option>
                        <option <?= ($viewUserProfile['gender'] ?? $userdatas['gender']) === 'Other' ? 'selected' : '' ?> class="text-black px-2" value="Other">Autre</option>
                        <option <?= ($viewUserProfile['gender'] ?? $userdatas['gender']) === 'No-comment' ? 'selected' : '' ?> class="text-black px-2" value="No-comment">Ne se prononce pas</option>
                    </select>
                </label> 
                <a class="mb-1 block" href="<?= $myartist ? '/controllers/ArtistController.php?bDropArtist' : '/controllers/ArtistController.php?bCreateArtist'?>"><?= $myartist ? 'Supprimer mon compte artiste' : 'Créer un compte artiste' ?></a>
                <div class="max-cont-520:flex-col gap-x-1 min-cont-520:center-b">
                    <button class="br-a-1-s br-cus-c-7 text-cus-1 rounded-1 c-p px-4 py-2 ta-c min-cont-520:w-fit bg-cus-5 td-3 hovr-bg-black hovr-text-white" type="submit" name="bUserUpdate">Confirmer</button>
                    <button class=" br-a-1-s br-cus-c-7 text-cus-5 rounded-1 c-p px-4 py-2 ta-c min-cont-520:w-fit bg-cus-3 td-3" type="submit" name="bPasswordUpdate">Changer Mot de passe</button>
                    <button class=" br-a-1-s br-cus-c-7 text-cus-5 rounded-1 c-p px-4 py-2 ta-c min-cont-520:w-fit bg-cus-10 td-3 hovr-bg-darkred hovr-text-white" type="submit" name="bUserDelete">Supprimer le compte</button>
                </div>
                <input type="hidden" value="<?= $userdatas['id']?>" name="user_id">
            </form>
        </div>
</section>
    <?php else:
    header("Location: /views/home.php");
    exit;
endif; 
    ?>
<?php include 'components/base_footer.php' ?>
