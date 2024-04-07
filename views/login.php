<?php include 'components/base_header.php';?> 

<?php if(!isset($userdatas)):?>

<section class="col-b gap-y-5" data-id="login">

    <h1 class="mx-auto ta-c w-fit rounded-s py-4 px-12 bg-cus-4 br-1-s br-cus-c-2 login-card">Se connecter</h1>

    <div class="  mx-auto rounded-s py-8 px-12 body-grad-2 br-1-s br-cus-c-2 login-card">
        <div class="max-w-80 mx-auto">
    
            <!-- Login form -->
            <form action="/controllers/AuthController.php"  method="post">
            <?= SessionManager::getSession('error')['logins'] ?? '' ?>
            <?= SessionManager::getSession('success')['create_user'] ?? '' ?>
                <label class="flex-col mb-5" for="loginInput" aria-label="Entrez nom d'utilisateur">Nom d'utilisateur ou email
                    <input class="input" type="text" name="loginInput">
                        <?= SessionManager::getSession('error')['loginInput'] ?? '' ?>

                </label>

                <label class="flex-col mb-5" for="loginPassword" aria-label="Entrez mot de passe">Entrez votre mot de passe
                    <input class="input"  type="password" name="loginPassword">
                    <?= SessionManager::getSession('error')['loginPassword'] ?? '' ?>
                    <?= SessionManager::getSession('error')['login_password'] ?? '' ?>
                </label>
                <div class="gap-x-4 mb-5 items-center">
                    <div class="w-10">
                        <label class="block bg-cus-4 br-1-s w-full loginToken-active py-1 px-1 rounded-full" for="loginTokenYes">
                            <span class="mr-auto block bg-white h-3 w-3 rounded-full"></span>
                            <input class="hidden" type="radio" name="loginToken" value="Oui" id="loginTokenYes">
                        </label>
                        <label class="bg-white w-full br-1-s br- hidden py-1 px-1 rounded-full" for="loginTokenNo">
                            <span class="block ml-auto bg-black h-3 w-3 rounded-full"></span>
                            <input class="hidden" type="radio" name="loginToken" value="Non" id="loginTokenNo" checked>
                        </label>
                    </div>
                    <p>Se souvenir de moi</p>
                </div>
                <button class="bLogin scale-1 td-3 c-p bg-cus-2 mb-5 mx-auto px-8 py-2 items-center br-none block rounded-2xl" type="submit" name="bLogin">Confirmer</button>
                <a class=" mx-auto block w-fit br-b-1-s hovr-white" href="forgot_password.php">Mot de passe oublié ?</a>
                <hr hr class="my-5">
                <a class="block  hovr-white mx-auto w-fit" href="signup.php">Pas encore inscrit ? <span class=" hovr-white br-b-1-s">S'incrire ici !</span></a>
            </form>
        </div>
    </div>
</section>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>  
<?php include 'components/base_footer.php' ?> 
