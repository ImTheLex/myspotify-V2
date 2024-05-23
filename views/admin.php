<?php require 'components/base_header.php' ?>
<?php if($userdatas && $userdatas['role'] === 9){
        $ticketsdatas = SessionManager::getSession('tickets_datas') ?? false;
        $tickettodisplay = SessionManager::getSession('ticket_to_display') ?? false;
    } 
?>
<?php if($userdatas && $userdatas['role'] === 9):?>


<section  data-id="admin" class="h-vh-7 max-media-680:h-full gap-x-8 max-media-680:col-c ">

    <div class="gap-y-4 mx-4 center-b max-media-680:flex-col max-media-680:h-full max-media-680:py-4 max-media-680:gap-x-4">
        <!-- Inbox -->
        <div class="col-b h-full gap-x-5 w-2/5 min-w-80  inbox-overview ">
            <h1 class="ta-c rounded-2 py-2 px-12 bg-cus-4 br-a-1-s br-cus-c-2"><?= isset($_GET['admin-create-user']) ? 'Créer' : 'Inbox' ?></h1>
            <div class="<?= isset($_GET['admin-create-user']) ? '' : 'ta-e' ?> flex-col gap-x-2 h-full rounded-2 py-4 px-12 bg-cus-4 br-a-1-s br-cus-c-2 h-vh-6 overf-a">
            <!-- If userCreation -->
            <?php if(isset($_GET['admin-create-user'])):?>
                <form action="/controllers/AuthController.php" method="post">
                    <label class="flex-col mb-5 fw-6 text-white" for="newAdminUserUsername">Pseudo
                    <?= SessionManager::getSession('error')["sign_up_username"] ?? ''?>                    
                    <?= SessionManager::getSession('error')["createUsername"] ?? ''?>                    
                        <input id="newAdminUserUsername" name="createUsername" class="input" type="text">
                    </label>
                    <label class="flex-col mb-5 fw-6 text-white" for="newAdminUserEmail">Email
                    <?= SessionManager::getSession('error')["sign_up_email"] ?? ''?>
                    <?= SessionManager::getSession('error')["createUserEmail"] ?? ''?>
                        <input class="input" id="newAdminUserEmail"  name="createUserEmail" type="text">
                    </label>
                    <label class="flex-col mb-5 fw-6 text-white" for="newAdminUserPassword">Mot de passe
                    <?= SessionManager::getSession('error')["createUserPassword"] ?? ''?>
                        <input class="input" id="newAdminUserPassword"  name="createUserPassword" type="text">
                    </label>
                    <label class="flex-col mb-5 fw-6 text-white" for="newAdminUserPassword1">Confirmer mot de passe
                    <?= SessionManager::getSession('error')["createUserPassword1"] ?? ''?>
                        <input class="input" id="newAdminUserPassword1"  name="createUserPassword1" type="text">
                    </label>
                    <!-- gender -->
                    <label class="flex-col mb-5 fw-6 text-white"  for="newAdminUserGender">Genre
                    <?= SessionManager::getSession('error')["newAdminUserGender"] ?? ''?>
                        <select class="input h-8 border-ridge px-2" name="createUserGender" id="newAdminUserGender">
                            <option class="text-black px-2" value="Male">M</option>
                            <option class="text-black px-2" value="Female">F</option>
                            <option class="text-black px-2" value="No-Binary">Non-binaire</option>
                            <option class="text-black px-2" value="Other">Autre</option>
                            <option class="text-black px-2" value="No-Comment">Ne se prononce pas</option>
                        </select>
                    </label>
                    <!-- Date -->
                    <label class="flex-col mb-5 fw-6 text-white"  for="newAdminUserBirth">Date de naissance
                    <?= SessionManager::getSession('error')["createUserBirth"] ?? ''?>
                        <input class="input h-8 border-ridge px-2" type="date" name="createUserBirth" id="newAdminUserBirth">
                    </label>
                    <label class="flex-col mb-5 fw-6 text-white"  for="newAdminUserRole">Role
                        <select class="input h-8 border-ridge px-2" name="createUserRole" id="newAdminUserRole">
                            <option class="text-black px-2" value="1">User</option>
                            <option class="text-black px-2" value="2">Artist</option>
                            <option class="text-black px-2" value="7">Support</option>
                            <option class="text-black px-2" value="8">Moderator</option>
                            <option class="text-black px-2" value="9">Admin</option>
                        </select>
                    </label>
                    <button name="bAdminCrud" type="submit" class="br-a-1-s br-cus-c-7 text-cus-1 rounded-1 c-p px-4 py-2 ta-c bg-cus-5 td-3 hovr-bg-black hovr-text-white w-full">Créer</button>
                </form>
            <?php else:?>
                <?php if(isset($ticketsdatas)):?>
                <?php foreach($ticketsdatas as $k => $ticketdata):?>
                <?php include 'components/ticket.php'?>
                <?php endforeach?>
                <?php endif?>             
            <?php endif?>
            </div>
        </div>

        <!-- Admin -->
        <div class="col-b h-full w-4/5 gap-x-5 min-w-80 max-media-680:max-w-80 admin-overview ">
            <h2 class="h1 ta-c w-full rounded-2 py-2 px-12 bg-cus-4 br-a-1-s br-cus-c-2">Admin</h2>
            <div class=" rounded-2 flex-col gap-x-5 h-vh-6 w-full py-4 px-12 body-grad-2 br-a-1-s br-cus-c-2 overf-a">
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
                    <button  
                        class="br-a-1-s br-cus-c-7 text-cus-1 rounded-1 px-4 py-2 ta-c w-full bg-cus-5 td-3 hovr-bg-black hovr-text-white <?= isset($tickettodisplay['state']) && (int)$tickettodisplay['state'] === 3 ? 'hidden c-na' : 'c-p' ?>" name="bRespondTicket" type="submit">
                        Répondre
                    </button>
                </form>
                <?php endif?>
            <?php if($_SERVER['REQUEST_URI'] !== "/views/admin.php"):?>
                <div>
                <?= SessionManager::getSession('success')['create_admin_user'] ?? ''?>
                <?= SessionManager::getSession('error')['model_user_creation'] ?? ''?>
                    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>" class="br-a-1-s br-cus-c-7 text-cus-1 rounded-1 px-4 py-2 ta-c min-cont-520:w-fit bg-cus-5 td-3 block hovr-bg-black hovr-text-white">Retour</a>
                </div>
            <?php else: ?>
                <form action="/controllers/AuthController.php" method="POST">
                    <div class="flex align-items-c wrap gap-y-2">
                    <?= SessionManager::getSession('error')['user_search'] ?? ''?>
                        <label class="flex-col mb-5 fw-6 text-cus-5 w-full" for="adminSearchUser">Rechercher un utilisateur
                            <input type="search" class="input  h-8 p-2" name="adminSearchUser"  id="adminSearchUser"/>
                        </label>
                        <button  
                            class="btn-1 center w-full" name="bAdminViewUserProfile" type="submit">
                            Consulter
                        </button>
                    </div>
                </form>
                <a class="btn-1 center" href="<?='?admin-create-user'?>">Creer un utilisateur</a>
            <?php endif?>
            </div>
        </div>
    </div>
</section>
<?php else:

header("Location: home.php");
endif
?>


<?php require 'components/base_footer.php' ?>
