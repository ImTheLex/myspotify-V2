<?php include 'components/base_header.php';?> 

<?php if(!$userdatas):?>

<section data-id="login">

    <div class="col-b gap-x-2 mx-auto w-1/2 make-container:login-container login-container min-w-80 ">

        <h1 class="ta-c text-white rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-2 ">Se connecter</h1>
    
        <!-- Login form -->
        <form class="rounded-2 p-2 br-cus-2 br-a-1-s text-cus-5 px-12 py-8 body-grad-2"  action="/controllers/AuthController.php"  method="post">
        <?= SessionManager::getSession('error')['logins'] ?? '' ?>
        <?= SessionManager::getSession('success')['create_user'] ?? '' ?>
            <label class="flex-col mb-5 fw-6 text-white" for="loginInput" aria-label="Entrez nom d'utilisateur">Nom d'utilisateur ou email
                <input class="input" type="text" name="loginInput">
                    <?= SessionManager::getSession('error')['loginInput'] ?? '' ?>

            </label>

            <label class="flex-col mb-5 fw-6 text-white" for="loginPassword" aria-label="Entrez mot de passe">Entrez votre mot de passe
                <input class="input"  type="password" name="loginPassword">
                <?= SessionManager::getSession('error')['loginPassword'] ?? '' ?>
            </label>
            <div class="gap-y-4 mb-5 flex align-items-c">
                <div class="w-10">
                    <label class="block bg-cus-4 br-a-1-s w-full loginToken-active py-1 px-1 rounded-100" for="loginTokenYes">
                        <span class="mr-auto block bg-white h-3 w-3 rounded-100"></span>
                        <input class="hidden" type="radio" name="loginToken" value="Oui" id="loginTokenYes">
                    </label>
                    <label class="bg-cus-2 w-full br-a-1-s br- hidden py-1 px-1 rounded-100" for="loginTokenNo">
                        <span class="block ml-auto bg-black h-3 w-3 rounded-100"></span>
                        <input class="hidden" type="radio" name="loginToken" value="Non" id="loginTokenNo" checked>
                    </label>
                </div>
                <s class="text-white" style="text-decoration: line-through;">Se souvenir de moi</s>
            </div>
            <button class="bLogin br-a-1-s hovr-bg-darkgreen  hovr-text-white c-p bg-cus-2 mb-5 mx-auto px-8 py-2 w-full rounded-9" type="submit" name="bLogin">Confirmer</button>
            <a class=" mx-auto block text-cus-7 w-fit br-b-1-s hovr-text-white" href="forgot_password.php">Mot de passe oublié ?</a>
            <hr hr class="my-5">

            <div class="mx-auto w-fit">
                <p class="w-fit max-cont-350:block inline-block" >Pas encore inscrit ?</p>
                <a href="signup.php" class=" hovr-text-white  text-cus-7 br-b-1-s max-cont-350:block">S'inscrire ici !</a>
            </div>

        </form>
    </div>
</section>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>  
<?php include 'components/base_footer.php' ?> 
