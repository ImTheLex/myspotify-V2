<?php include 'components/base_header.php' ?> 
<?php if(!isset($userdatas) || $userdatas["role"] === 9):?>

<section data-id="signup">

    <div class="mx-auto  rounded-s py-8 px-12 br-1-s br-cus-c-2 body-grad-2 login-card">
            <div class="max-w-80 mx-auto">
                <h1 class="mx-auto w-fit">S'inscrire</h1>
                <hr class="my-5">
                <ul style="counter-reset: auto-increment-numbers;" class="flex-col gap-y-3" id="consentSignUpRisk">
                    <li class="increment" >
                        Il est important de mentionner que ce site ne fait <b class="br-b-1-s">pas partie du groupe spotify.</b>
                    </li>
                    <li class="increment">
                        Il ne relève que de la création d’un fan.
                    </li> 
                    <li class="increment">
                        Il est donc préférable de renseigner des identifiants <b class="br-b-1-s">“bidon” afin d’éviter tout risque.</b>
                    </li>
                    <li class="increment">
                        Merci de votre lecture, et passez un bon moment !
                    </li>
                    <li class="increment">
                        En cliquant sur ce bouton vous consentez à avoir pris connaissance du message-ci dessus.
                    </li>
                    <hr class="my-5">
                    <button class="bConsentSignupRisk c-p mb-5 bg-cus-2 scale-1 td-3 mx-auto px-8 py-2 items-center br-none block rounded-2xl" type="button" name="bConsentSignupRisk" id="bConsentSignUpRisk" onclick="consentSignUpRisk()">Je confirme avoir pris connaissance  de ce message.</button>
                    <?=SessionManager::getSession('error')['model'] ?? '' ?>
                </ul>                
                <!-- Form Signup -->
                <form action="/controllers/AuthController.php"  method="post">
                    <div class="hidden" id="signUpStep1">
                        <?php include 'components/signup_step_1.php' ?>
                    </div>
                    <div class="hidden" id="signUpStep2">
                        <?php include 'components/signup_step_2.php' ?>
                    </div>
                    <div class="hidden" id="signUpStep3">
                        <?php include 'components/signup_step_3.php' ?>
                    </div>
                <div class="hidden" id="pursueSignUpDiv">
                    <button class="bSignUp mb-5 mx-auto c-na px-8 py-2 items-center br-none block rounded-2xl" type="button" name="bSignUp" id="bSignUp" onclick="pursueSignUp()" disabled>Poursuivre (1/3)</button>
                    <hr hr class="my-5">
                    <a class="w-fit mx-auto  hovr-white block" href="login.php">As-tu un compte ? <span class="br-b-1-s">Connecte toi!</span></a>
                </div>

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