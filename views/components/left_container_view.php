<!--------------------------------------Partie Gauche-------------------------------------------->
        <section class="col-b rounded-2 max-w-120  w-full <?= SessionManager::getSession('mob_biblio') ?  '' : 'max-media-500:hidden' ?> min-media-500:w-3/10 min-w-30 h-full make-container:left-container left-container">
            <div class="col-c rounded-2 p-2 br-cus-2 br-a-1-s bg-cus-6 top-left-container">
                <div class="icon-accueil">
                    <a href='<?= "/controllers/RoutingController.php?accueil"?>' class="  gap-y-2 px-1 center" aria-label="Lien vers la page home">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                            <path opacity="1" fill="currentColor" d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                        </svg> 
                        <h2 class="max-cont-250:hidden">Accueil</h2>
                    </a>
                </div>
                </div>
                <div class="br-a-1-s br-cus-2 bg-cus-6 rounded-2 p-2 overf-a bottom-left-container">
                    <div class=" center min-cont-250:center-b px-1 mb-2 bottom-left-top-container">
                        <button class="max-cont-250:hidden c-p bg-transparent h2 gap-y-2 flex center-b text-cus-7 br-none biblio" >
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                <path opacity="1" fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                            </svg>
                            Biblio
                        </button>
                        <div class="gap-x-2 flex justify-content-c align-items-c biblio-icons">
                            <div class="p-rel rounded-100 create-playlist">
                                <a href="../controllers/PlaylistController.php?bCreatePlaylist">
                                    <div class="w-8 h-8 c-p hovr-text-cus-2 hovr-bg-cus-7  rounded-100 center">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                            <path opacity="1" fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                                        </svg>
                                    </div>
                                </a>          
                            </div>
                                        
                            <div class="rounded-100 toggle-biblio">
                                <div class="w-8 h-8 c-p center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                        <path opacity="1" fill="currentColor" d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" gap-y-6 pb-2 px-1 br-b-1-s flex max-cont-250:center gap-x-4 max-cont-200:wrap  left-container-filter">
                        <button type="button" class="bg-cus-3  h4  max-cont-200:w-full text-cus-7 br-a-1-s br-cus-c-7 rounded-3 p-1 c-p">Playlists</button>
                        <button type="button" class="bg-cus-3 h4  max-cont-200:w-full text-cus-7 br-a-1-s br-cus-c-7 rounded-3 p-1 c-p">Artistes</button>
                    </div>      
                    <div class="max-cont-250:pt-2 left-scrollable-container">
                        <div class="p-rel px-2 gap-x-2 py-1 hidden min-cont-250:center-b form-left-side-container">
                            <div class=" p-abs zi-2 h-8 w-8 center c-p rounded-100" id="Search_Icon_2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                    <path opacity="1" fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                                </svg>
                            </div>
                            <form class=" bg-transparent ml-10 rounded-1 center my-2" action="">
                                <input class="bg-transparent text-white" type="search" name="Search" placeholder="Search here" autocomplete="off" id="Search_Input" value="">
                            </form>
                        </div>
                        <?php
                            
                            
                            if(isset($playlistdatas) && $playlistdatas):
                            foreach($playlistdatas as $playlistitem){
                                include 'playlist.php';
                            }                  
                            endif;

                        ?>
                        
                    </div>
                    </div>
                </section>