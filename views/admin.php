<?php require 'components/base_header.php' ?>
<?php if($userdatas && $userdatas['role'] === 9){
        $ticketsdatas = SessionManager::getSession('tickets_datas') ?? false;
        $tickettodisplay = SessionManager::getSession('ticket_to_display') ?? false;
    } 
?>
<?php if($userdatas && $userdatas['role'] === 9):?>


<div class="flex mx-4 gap-y-4">
    <!-- Section inbox -->
    <section class="w-2/5 col-b"  data-id="inbox">
        <div class="flex-col h-full gap-x-5 inbox">
            <h1 class="ta-c rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-c-2">Inbox</h1>
            <div class="ta-e flex-col gap-x-2 h-full rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-c-2">
                <?php if(isset($ticketsdatas)):?>
                <?php foreach($ticketsdatas as $k => $ticketdata):?>
                <?php include 'components/ticket.php'?>
                <?php endforeach?>
                <?php endif?>
            </div>
        </div>
    </section>

    <!-- Section admin -->
    <section class=" w-4/5 col-b" data-id="admin">
        <!-- If inbox-view -->
        <div class="flex-col h-full gap-x-5 inbox-view">
            <h2 class="h1 ta-c w-full rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-c-2">Inbox-view</h2>
            <div class=" rounded-2 h-full w-full py-4 px-12 body-grad-2 br-a-1-s br-cus-c-2">
            <?php if(isset($_GET['ticket'])):?>
                <form action="/controllers/TicketController.php" method="post">
                    <div class="grid grid-col-2 mb-5">
                        <p class="fw-6 text-cus-5"> Auteur:</p> 
                        <p class="text-cus-2"><?= $tickettodisplay['contactUsername']?></p>
                    </div>
                    <div class="mb-5"> 
                        <p class="fw-6 text-cus-5">Contenu:</p>
                        <p class="input flex align-items-c h-10"><?= $tickettodisplay['content']?>
                        </p>
                    </div>
                    <div> 
                        <label class="flex-col mb-5 fw-6 text-cus-5" for="ticketResponse">Réponse:
                            <textarea type="text" class="input h-20 p-2" name="ticketResponse"  id="ticketResponse" <?= $tickettodisplay['state'] !== 3 ? 'autofocus' : 'disabled'?> value="<?=$tickettodisplay['response'] ?? ''?>"></textarea>
                        </label>
                    </div>
                    <input type="hidden" name="ticketId" value="<?= $tickettodisplay['id']?>">       
            <!-- If userCreation -->
                <?php elseif(isset($_GET['admin-create-user'])):?>
                <form action="/controllers/AuthController.php" method="post">
                    <label class="flex-col mb-5" for="newAdminUserUsername">Pseudo
                        <input id="newAdminUserUsername" name="createUsername" class="input" type="text">
                    </label>
                    <label class="flex-col mb-5" for="newAdminUserEmail">Email
                        <input class="input" id="newAdminUserEmail"  name="createUserEmail" type="text">
                    </label>
                    <label class="flex-col mb-5" for="newAdminUserPassword">Mot de passe
                        <input class="input" id="newAdminUserPassword"  name="createUserPassword" type="text">
                    </label>
                    <label class="flex-col mb-5" for="newAdminUserPassword1">Mot de passe
                        <input class="input" id="newAdminUserPassword1"  name="createUserPassword1" type="text">
                    </label>
                    <!-- gender -->
                    <label class="flex-col mb-5"  for="newAdminUserGender">Genre
                        <select class="input h-8 border-ridge px-2" name="newAdminUserGender" id="newAdminUserGender">
                            <option class="text-black px-2" value="Male">M</option>
                            <option class="text-black px-2" value="Female">F</option>
                            <option class="text-black px-2" value="No-Binary">Non-binaire</option>
                            <option class="text-black px-2" value="Other">Autre</option>
                            <option class="text-black px-2" value="No-Comment">Ne se prononce pas</option>
                        </select>
                    </label>
                    <!-- Date -->
                    <label class="flex-col mb-5"  for="newAdminUserBirth">Date de naissance
                        <input class="input h-8 border-ridge px-2" type="date" name="newAdminUserBirth" id="newAdminUserBirth">
                    </label>
                    <label class="flex-col mb-5"  for="newAdminUserRole">Role
                        <select class="input h-8 border-ridge px-2" name="newAdminUserRole" id="newAdminUserRole">
                            <option class="text-black px-2" value="1">User</option>
                            <option class="text-black px-2" value="2">Artist</option>
                            <option class="text-black px-2" value="7">Support</option>
                            <option class="text-black px-2" value="8">Moderator</option>
                            <option class="text-black px-2" value="9">Admin</option>
                        </select>
                    </label>                                        
                <?php endif?>
                <?php if($_SERVER['REQUEST_URI'] !== "/views/admin.php"):?>
                    <div class="flex justify-content-b">
                        <button  
                            class="br-a-1-s br-cus-c-7 text-cus-1 rounded-1 px-4 py-2 ta-c min-cont-520:w-fit bg-cus-5 td-3 hovr-bg-black hovr-text-white <?= isset($tickettodisplay['state']) && (int)$tickettodisplay['state'] === 3 ? 'hidden c-na' : 'c-p' ?>" name="<?= $_SERVER['REQUEST_URI'] === '/views/admin.php?admin-create-user' ?  'bAdminCrud' : 'bRespondTicket'?>" type="submit">
                            <?= $_SERVER['REQUEST_URI'] === '/views/admin.php?admin-create-user' ?  'Créer utilisateur' : 'Répondre'?>
                        </button>
                        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>" class="br-a-1-s br-cus-c-7 text-cus-1 rounded-1 px-4 py-2 ta-c min-cont-520:w-fit bg-cus-5 td-3 hovr-bg-black hovr-text-white">Retour</a>
                    </div>
                <?php else: ?> 
                    <a class="btn-1 center" href="<?='?admin-create-user'?>">Creer un utilisateur</a>
                <?php endif?>
                </form>
            </div>
        </div>
    </section>
</div>
<?php else:

header("Location: home.php");
endif
?>
















<?php require 'components/base_footer.php' ?>
