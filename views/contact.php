<?php require 'components/base_header.php' ?>

<?php if($userdatas):?>
<section  data-id="contact">
    <div class="gap-y-4 mx-4 h-full center-b">
        <div class="flex-col w-4/12 gap-x-5 min-w-80 inbox">
            <h1 class="ta-c rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-c-2">Contact</h1>
            <div class="rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-c-2">
                <form action="/controllers/TicketController.php" method="post">
                    <label class="flex-col mb-5 fw-6 text-white" for="contactUsername">Votre nom d'utilisateur
                    <?= SessionManager::getSession('success')['create_ticket'] ?? ''?>
                    <?= SessionManager::getSession('error')['ticket_exists'] ?? ''?>
                        <input class="input" type="text" id="contactUsername" name="contactUsername">
                    </label>
                    <label class="flex-col mb-5 fw-6 text-white" for="contactUsername">Sujet
                        <input class="input" type="text" id="contactSubject" name="contactSubject">
                    </label>
                    <label class="flex-col mb-5 fw-6 text-white" for="contactContent">Votre demande
                        <textarea class=" input-height-l h-40 p-1" id="contactContent" name="contactContent"></textarea>
                    </label>
                    <button class="center w-full br-a-1-s br-cus-c-7 text-cus-1 rounded-1 c-p px-4 py-2 bg-cus-5 td-3 hovr-bx-shadow-cus-2" name="bSubmitTicket" type="submit">Envoyer</button>
                </form>
            </div>
        </div>    
        <div class="w-6/12 h-full flex-col min-w-80 gap-x-5 ta-c make-container:faq-container faq-container" id="faq">
            <h2 class="h1 ta-c  w-full  rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-c-2">FAQ</h2>
            <div class="grid grid-col-2 gap-y-12 gap-x-12 h-full">
                <a  class="body-grad-2 td-2 p-4 br-cus-2 br-a-1-s rounded-2 h4 center max-cont-450:fs-4 hovr-bg-cus-7 hovr-text-black" href="">Comment devenir artiste ?</a>
                <a class="body-grad-2 td-2 p-4 br-cus-2 br-a-1-s rounded-2 h4 center max-cont-450:fs-4 hovr-bg-cus-7 hovr-text-black"  href="">J'ai perdu un mot de passe ?</a>
                <a class="body-grad-2 td-2 p-4 br-cus-2 br-a-1-s rounded-2 h4 center max-cont-450:fs-4 hovr-bg-cus-7 hovr-text-black" href="">Puis-je avoir plusieurs comptes artiste ?</a>
                <a class="body-grad-2 td-2 p-4 br-cus-2 br-a-1-s rounded-2 h4 center max-cont-450:fs-4 hovr-bg-cus-7 hovr-text-black" href="">Comment supprimer mes données ?</a>
                <a class="body-grad-2 td-2 p-4 br-cus-2 br-a-1-s rounded-2 h4 center max-cont-450:fs-4 hovr-bg-cus-7 hovr-text-black" href="">Comment créer une playlist ?</a>
                <a class="body-grad-2 td-2 p-4 br-cus-2 br-a-1-s rounded-2 h4 center max-cont-450:fs-4 hovr-bg-cus-7 hovr-text-black" href="">Combien de temps avant une réponse ?</a>
            </div>
        </div>
    </div>
</section>
<?php else:

header("Location: home.php");
endif
?>
















<?php require 'components/base_footer.php' ?>
