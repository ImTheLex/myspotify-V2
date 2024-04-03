<?php include 'components/base_header.php' ?> 

<?php if(!isset($userdatas)):?>

    <section data-id="forgot-password">
        <div class="mx-auto rounded-s py-8 px-12 body-grad-2 br-1-s br-cus-c-2 login-card">
            <div class="max-w-80 mx-auto">
                <h1 class="mx-auto w-fit">Vos identifiants</h1>
                <hr class="my-5">
                <form action="/controllers/AuthController.php"  method="post">
                    <?= SessionManager::getSession('error')['forgotInvalid'] ?? '' ?>
                    <label class="flex-col mb-5" for="forgotInput" aria-label="Entrez nom d'utilisateur">Entrez votre mail ou username
                        <input class="input" type="text" name="forgotInput" id="forgotInput" required autofocus>
                    <?= SessionManager::getSession('error')['forgotInput'] ?? '' ?>
                    </label>
                    <label class="flex-col mb-5" for="forgotToken" aria-label="Entrez nom d'utilisateur">Entrez votre clé d'identification;
                        <input class="input" type="text" name="forgotToken" id="forgotToken"required>
                    <?= SessionManager::getSession('error')['forgotToken'] ?? '' ?>
                    </label>
                    <button class="bLogin scale-1 td-3 c-p bg-cus-2 mb-5 mx-auto px-8 py-2 items-center br-none block rounded-2xl" type="submit" name="bForgotPassword">Demander un nouveau mot de passe</button>
                </form>
            </div>
        </div>
    </section>
    
<?php include 'components/base_footer.php' ?>

<?php else:
    header("Location: login.php");
    endif;    
    ?>
