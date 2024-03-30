<?php require 'components/base_header.php' ?>

<?php if(isset($userdatas) && $userdatas['role'] === 9):?>

<div class="d-fx mx-4 gap-x-4 h-full">
    <!-- Section inbox -->
    <section class="w-2/5  col-b"  data-id="inbox">
        <div class="flex-col h-full gap-y-5 inbox">
            <h1 class="ta-c rounded-s py-4 px-12 bg-cus-4 br-1-s br-cus-c-2">Inbox</h1>
            <div class="ta-e flex-col gap-y-2 h-full rounded-s py-4 px-12 bg-cus-4 br-1-s br-cus-c-2">
                <?php $ticketdatas = $ticket->getAllTickets();
                    foreach($ticketdatas as $k => $ticketdata):
                ?>
                    <?php include 'components/ticket.php'?>
                <?php endforeach?>
            </div>
        </div>
    </section>

    <!-- Section admin -->
    <section class=" w-4/5 col-b" data-id="admin">
        <!-- If inbox-view -->
        <div class="flex-col h-full gap-y-5 inbox-view">
            <h2 class="h1 ta-c w-full rounded-s py-4 px-12 bg-cus-4 br-1-s br-cus-c-2">Inbox-view</h2>
            <div class=" rounded-s h-full w-full py-4 px-12 body-grad-2 br-1-s br-cus-c-2">
                    <?php if(isset($_GET['ticket'])):?>
                        <?php $tickettodisplay = $ticket->getTicket($_GET['ticket'])?>
                        <form action="/controllers/TicketController.php" method="post">
                            <div class="d-gd grid-col-2 mb-5">
                                <p> Auteur:</p> 
                                <p class="text-cus-2"><?= $user->getUserName($tickettodisplay['user_id'])?>
                                </p>
                            </div>
                            <div class="mb-5"> 
                                <p>Contenu:</p>
                                <p class="input"><?= $tickettodisplay['content']?>
                                </p>
                            </div>
                            <div> 
                                <label class="flex-col mb-5" for="ticketResponse">Réponse:
                                    <input type="text" class="input" name="ticketResponse"  id="ticketResponse" <?= $tickettodisplay['state'] !== 3 ? 'autofocus' : 'disabled'?> value="<?=$tickettodisplay['response'] ?? ''?>">
                                </label>
                            </div>
                            <input type="hidden" name="ticketId" value="<?= $tickettodisplay['id']?>">       
                    <!-- If userCreation -->
                    <?php elseif(isset($_GET['admin-create-user'])):?>
                        <form action="/controllers/AuthController.php" method="post">

                            <label class="flex-col mb-5" for="newAdminUserUsername">Pseudo
                                <input id="newAdminUserUsername" name="newAdminUserUsername" class="input" type="text">
                            </label>
                            <label class="flex-col mb-5" for="newAdminUserEmail">Email
                                <input class="input" id="newAdminUserEmail"  name="newAdminUserEmail" type="text">
                            </label>
                            <label class="flex-col mb-5" for="newAdminUserPassword">Mot de passe
                                <input class="input" id="newAdminUserPassword"  name="newAdminUserPassword" type="text">
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
                                    <option class="text-black px-2" value="2">Support</option>
                                    <option class="text-black px-2" value="3">Moderator</option>
                                    <option class="text-black px-2" value="9">Admin</option>
                                </select>
                            </label>                                        
                    <?php endif?>

                    <?php if($_SERVER['REQUEST_URI'] !== "/views/admin.php"):?>
                    <div class="d-fx jc-sb">
                        <button   class=" br-1-s br-cus-c-7 text-cus-1 rounded-xs <?= (int)$tickettodisplay['state'] === 3 ? 'hidden c-na' : 'c-p'?>  px-4 py-2 w-fit bg-cus-5 td-3 hovr-bx-shadow-cus-2" name="<?= $_SERVER['REQUEST_URI'] === '/views/admin.php?admin-create-user' ?  'bAdminCrud' : 'bRespondTicket'?>" type="submit" 
                    >
                            <?= $_SERVER['REQUEST_URI'] === '/views/admin.php?admin-create-user' ?  'Créer utilisateur' : 'Répondre'?>
                        </button>
                        <a href="<?= $_SERVER['SCRIPT_NAME']?>" class="br-1-s br-cus-c-7 text-cus-1 rounded-xs c-p px-4 py-2 w-fit bg-cus-5 td-3 hovr-bx-shadow-cus-2">Retour</a>
                    </div>
                    <?php else: ?> 
                        <a class="center br-1-s br-cus-c-7 text-cus-1 rounded-xs c-p px-4 py-2 w-fit bg-cus-5 td-3 hovr-bx-shadow-cus-2" href="<?='?admin-create-user'?>">Creer un utilisateur</a>
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
