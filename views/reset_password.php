<?php include 'components/base_header.php' ?> 
<?php if(!isset($userdatas)):?>

<section data-id="forgot-password">

    <div class="  mx-auto rounded-s py-8 px-12 body-grad-2 br-1-s br-cus-c-2 login-card">
        <div class="max-w-80 mx-auto">
        <?php if (isset($_GET['token'])):?>

            <h2 class="mx-auto w-fit">Nouveau mot de passe</h2>
            <hr class="my-5">
    
            <form action="/controllers/AuthController.php"  method="post">
                <label class="flex-col mb-5" for="resetInput" aria-label="Entrez nom d'utilisateur">Introduisez un nouveau mot de passe
                    <input class="input" type="text" name="resetInput" id="resetInput">
                <?= $_SESSION['errors'][0] ?? '' ?>
                </label>
                <button class="bLogin scale-1 td-3 c-p bg-cus-2 mb-5 mx-auto px-8 py-2 items-center br-none block rounded-2xl" type="submit" name="bResetPassword">Confirmer la réinitialisation du mot de passe</button>
            </form>
            <?php else:?>
            <h3 class="mx-auto w-fit mb-5">Vous vous êtes perdu ?</h3>
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