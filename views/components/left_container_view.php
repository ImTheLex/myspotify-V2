<!--------------------------------------Partie Gauche-------------------------------------------->
        <section class="col-b rounded-s h-full left-container m-lm:bg-cus-5">
            <div class="col-c rounded-s p-2 gap-y-2 br-cus-c-2 br-1-s  bg-cus-6 border top-left-container">
                <div class="icon-accueil">
                    <a onclick="toggle_playlists_display()" class="  gap-x-2 px-1 items-center" href="#" aria-label="Lien vers la page home">
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                            <path opacity="1" fill="currentColor" d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                        </svg> 
                        <h2>Accueil</h2>
                    </a>
                </div>
                </div>
                <div class="br-1-s br-cus-c-2 bg-cus-6 rounded-s p-2 bottom-left-container">
                    <div class=" center-b px-1 fw-w bottom-left-top-container">
                        <button class="c-p bg-trans h2 gap-x-2 items-center text-cus-7 br-none biblio" >
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                <path opacity="1" fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                            </svg>
                            Biblio
                        </button>
                        <div class="gap-x-2 items-center biblio-icons">
                            <div class="p-rel rounded-full create-playlist">
                                <a href="../controllers/PlaylistController.php?bCreatePlaylist">
                                    <div class="w-8 h-8 c-p hovr-cus-2 hovr-bg-cus-7  rounded-full center">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                            <path opacity="1" fill="currentColor" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                                        </svg>
                                    </div>
                                </a>          
                            </div>
                                        
                            <div class="rounded-full toggle-biblio">
                                <div class="w-8 h-8 c-p center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                        <path opacity="1" fill="currentColor" d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" gap-x-6 py-2 px-1 br-b-1-s gap-y-4 m-lm:fw-w center  left-container-filter">
                        <button type="button" class="bg-cus-3 h4 text-cus-7 br-1-s br-cus-c-7 rounded-sm p-1 c-p">Playlists</button>
                        <button type="button" class=" bg-cus-3 h4 text-cus-7 br-1-s br-cus-c-7 rounded-sm p-1 c-p">Artistes</button>
                    </div>      
                    <div class="overf-a left-scrollable-container">
                        <div class="p-rel px-2 gap-x-2 py-1 center-b form-left-side-container">
                            <div class=" p-abs zi-2 h-8 w-8 center c-p rounded-full" id="Search_Icon_2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                    <path opacity="1" fill="currentColor" d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/>
                                </svg>
                            </div>
                            <form class=" bg-trans ml-10 rounded-xs center" action="">
                                <input class="bg-trans text-white" type="search" name="Search" placeholder="Search here" autocomplete="off" id="Search_Input" value="">
                            </form>
                            <div class=" filter-text">
                                <p>Récent</p>
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                    <path opacity="1" fill="currentColor" d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/>
                                </svg>
                            </div>
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