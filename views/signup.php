<?php include 'components/base_header.php'; 
    // var_dump($_SESSION,$_POST,$_SERVER);
    $signupStep1Datas = SessionManager::getSession('signupDatasStep1') ?? ''; 
    $signupStep2Datas = SessionManager::getSession('signupDatasStep2') ?? '';

?> 
<?php if(!$userdatas || $userdatas["role"] === 9):?>

<section data-id="signup">

    <div class="col-b gap-x-2 mx-auto w-1/2 make-container:login-container login-container min-w-80 ">

        <h1 class="ta-c text-white rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-2 ">S'inscrire</h1>
        <div class="rounded-2 p-2 br-cus-2 br-a-1-s text-cus-5 px-12 py-8 body-grad-2 h-vh-6 overf-a <?= $_SERVER['REQUEST_URI'] === '/views/signup.php' ? 'ta-c' : ''?>">          

        <?php if($_SERVER['REQUEST_URI'] === '/views/signup.php'):?>
            <p class="max-w-80 mx-auto mb-2">Il est important de mentionner que ce site ne fait <b class="br-b-1-s">pas partie du groupe spotify.</b></p>
            <p class="max-w-80 mx-auto mb-2">Il ne relève que de la création d’un fan.</p>
            <p class="max-w-80 mx-auto mb-2">Il est donc préférable de renseigner des identifiants <b class="br-b-1-s">“bidon” afin d’éviter tout risque.</b></p>
            <p class="max-w-80 mx-auto mb-2">Merci de votre lecture, et passez un bon moment !</p>
            <p class="max-w-80 mx-auto mb-2">En cliquant sur ce bouton vous consentez à avoir pris connaissance du message-ci dessus.</p>

            <hr class="my-5">
            <a href="signup.php?signupStep1" class="btn-signup block">Je confirme avoir pris connaissance  de ce message.</a>
            <?=SessionManager::getSession('error')['model_user_creation'] ?? '' ?>

        <?php else: ?>                
                <!-- Form Signup -->
                <form action="/controllers/AuthController.php"  method="post">

                    <?php if(!$signupStep1Datas):?>

                    <?php include 'components/signup_step_1.php' ?>
                    <button class="btn-signup" type="submit" name="bSignUpStep1">Poursuivre (1/3)</button>

                    <?php elseif(!$signupStep2Datas):?>

                        <?php include 'components/signup_step_2.php' ?>
                        <button class="btn-signup" type="submit" name="bSignUpStep2"  >Poursuivre (2/3)</button>

                    <?php elseif($signupStep2Datas):?>

                        <?php include 'components/signup_step_3.php' ?>
                        <button class="btn-signup mt-8" type="submit" name="bSignUp">Terminer</button>

                    <?php endif ?>

            </form>
            <hr class="my-5">
            <div class="mx-auto w-fit">
                    <p class="w-fit text-cus-7 max-cont-350:block inline-block" >Déjà un compte ?</p>
                    <a href="login.php" class=" hovr-text-white  text-cus-7 br-b-1-s max-cont-350:block">Connecte toi !</a>
                </div>
            <?php endif?>
                
            
            </div>
        </div>
    </div>
</section>

     
<?php 
            // SessionManager::unsetSession('signupDatasStep1');
            // SessionManager::unsetSession('signupDatasStep2');

else: 
    header("Location: /views/home.php");
    exit;
endif; 
    ?>
<?php include 'components/base_footer.php' ?>