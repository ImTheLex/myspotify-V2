    <div class="p-abs mt-12 w-full bg-cus-8 rounded-2 p-2 notification zi-10">
        <ul class="flex-col gap-x-2">
            <?php foreach($unreadtickets as $unreadticket):?>
                <li class="br-l-4-s br-cus-c-10 bg-cus-6 gap-x-3 p-2 rounded-2 center-b">
                    <div>
                        <h5 class="">Sujet:</h5>
                        <p class="text-cus-2"><?=$unreadticket['subject']?></p>
                        <h5 class="">Réponse:</h5>
                        <p class="text-cus-2"><?= $unreadticket['response']?></p>
                    </div>
                    <a href="/controllers/TicketController.php?bIsReadTicket=<?=$unreadticket['id']?>" class="center hovr-text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
                            <path opacity="1" fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                        </svg>
                    </a>
                </li>
            <?php endforeach?>
        </ul>
    </div>
</div>