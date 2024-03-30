<?php require 'components/base_header.php' ?>

<?php if(isset($userdatas)):?>

<div class="d-fx mx-4 gap-x-4 h-full">
    <section class="w-2/5 col-b"  data-id="contact">
        <div class="flex-col gap-y-5 inbox">
        <h1 class="ta-c rounded-s py-4 px-12 bg-cus-4 br-1-s br-cus-c-2">Contact</h1>
        <div class="rounded-s py-4 px-12 bg-cus-4 br-1-s br-cus-c-2">
            <form action="/controllers/TicketController.php" method="post">
                <label class="flex-col mb-5" for="contactUsername">Nom d'utilisateur
                    <?= SessionManager::getSession('success')['create_ticket'] ?? ''?>
                    <?= SessionManager::getSession('error')['ticket_exists'] ?? ''?>
                    <input class="input" type="text" id="contactUsername" name="contactUsername">
                </label>
                <label class="flex-col mb-5" for="contactContent">Votre message
                    <textarea class=" input-height-l h-40 p-1" id="contactContent" name="contactContent"></textarea>
                </label>
                <button class="center w-full br-1-s br-cus-c-7 text-cus-1 rounded-xs c-p px-4 py-2 bg-cus-5 td-3 hovr-bx-shadow-cus-2" name="bSubmitTicket" type="submit">Envoyer</button>
            </form>
        </div>
        
            
        </div>
    </section>
    <section class=" w-4/5 col-b" data-id="faq">
      
        <div class="admin">
            <h2 class="h1 ta-c rounded-s py-4 px-12 bg-cus-4 br-1-s br-cus-c-2">Admin</h2>
            <div>
                
            </div>
        </div>

    </section>
</div>
<?php else:

header("Location: home.php");
endif
?>
















<?php require 'components/base_footer.php' ?>
