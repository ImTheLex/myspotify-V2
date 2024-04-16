<article class="py-4 px-6 br-a-1-s rounded-2  <?= $ticketdata['state'] == 1 ? 'ticket-grad-1' : ($ticketdata['state'] == 2 ? 'ticket-grad-2' : 'ticket-grad-3')?> ">
    <a class="w-full h-full" href="/controllers/TicketController.php?bUpdateState=<?=$ticketdata['id']?>">
        <p class="h4"><?= $ticketdata['subject']?></p>
    </a>
</article>