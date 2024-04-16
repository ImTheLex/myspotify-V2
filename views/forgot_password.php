<?php include 'components/base_header.php' ?> 

<?php if(!$userdatas):?>

    <section data-id="forgot-password">
        <div class="col-b gap-x-2 mx-auto w-1/2 make-container:login-container login-container min-w-80 ">
            <h1 class="ta-c text-white rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-2 ">Mot de passe oublié</h1>
            <form action="/controllers/AuthController.php" class="rounded-2 py-4 px-12 body-grad-2 br-a-1-s br-cus-2 "  method="post">
                <?= SessionManager::getSession('error')['forgotInvalid'] ?? '' ?>
                <label class="flex-col mb-5 fw-6 text-white" for="forgotInput" aria-label="Entrez nom d'utilisateur">Entrez votre mail ou username
                    <input class="input" type="text" name="forgotInput" id="forgotInput" required autofocus>
                <?= SessionManager::getSession('error')['forgotInput'] ?? '' ?>
                </label>
                <label class="flex-col mb-5 fw-6 text-white" for="forgotToken" aria-label="Entrez nom d'utilisateur">Entrez votre clé d'identification
                    <input class="input" type="text" name="forgotToken" id="forgotToken"required>
                <?= SessionManager::getSession('error')['forgotToken'] ?? '' ?>
                </label>
                <button class="btn-signup" type="submit" name="bForgotPassword">Demander un nouveau mot de passe</button>
            </form>
        </div>
    </section>
    
<?php include 'components/base_footer.php' ?>

<?php else:
    header("Location: login.php");
    endif;    
    ?>
