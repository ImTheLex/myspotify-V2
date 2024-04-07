<footer class="flex-col" >     
       <?php if($_SERVER['SCRIPT_NAME'] !== "/views/home.php"):?>   
            <div class="bg-cus-1 mt-auto br-t-2-s pb-2 pt-4 px-4">
                <a class="mx-auto w-fit block hovr-white" href="/views/terms_of_services.php">Terms Of Service</a>
            </div>
            <?php  else: ?>

                <?php include 'bottom_container_view.php' ?>

            <?php endif;
            if(!empty(SessionManager::getSession('error'))):
                SessionManager::unsetSession('error');
            endif;
            if(!empty(SessionManager::getSession('success'))):
                SessionManager::unsetSession('success');
            endif;
            if(!empty(SessionManager::getSession('errors'))):
                SessionManager::unsetSession('errors');
            endif;
            ?>

            
        </footer>
    </body>
</html>