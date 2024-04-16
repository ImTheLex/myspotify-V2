<?php include 'components/base_header.php' ?> 
<?php if(!$userdatas):?>

<section data-id="forgot-password">

    <div class="col-b gap-x-2 mx-auto w-1/2 make-container:login-container login-container min-w-80 ">
        <?php if (isset($_GET['token'])):?>

            <h1 class="ta-c text-white rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-2 ">Nouveau mot de passe</h1>        
            <form action="/controllers/AuthController.php" class="rounded-2 py-4 px-12 body-grad-2 br-a-1-s br-cus-2 "  method="post">
                <label class="flex-col mb-5 fw-6 text-white" for="resetInput" aria-label="Entrez nom d'utilisateur">Introduisez un nouveau mot de passe
                    <input class="input" type="text" name="resetInput" id="resetInput">
                <?= $_SESSION['errors'][0] ?? '' ?>
                <?= SessionManager::getSession('error')['model'] ?? ''?>

                </label>

                <button class="btn-signup" type="submit" name="bResetPassword">Confirmer la réinitialisation du mot de passe</button>
            </form>
            <?php else:?>
            <h2 class="mx-auto w-fit mb-5">Vous vous êtes perdu ?</h2>
            <p>On peut vous offrir un café si le coeur vous en dit ? :)</p>

            <?php endif ?>

        </div>
    </div>
</section>
<?php else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>
    
<?php include 'components/base_footer.php' ?>