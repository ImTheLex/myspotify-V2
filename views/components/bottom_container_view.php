   <!-- --------------------------------------------------------------------Footer-------------------------------- -->
            <div class="flex-col gap-x-2 min-media-500:hidden gap-y-2 h-full">
                <div class="br-a-1-s p-2 bg-cus-6 rounded-2 flex gap-y-2 mx-4">
                    <img src="/public/ressources/Spotify_Images/Spotify_Image_2.jpeg" alt="artist image" loading="lazy" class="ml-1 img-cov w-12 h-12">
                    <div class="on-reading-artist">
                        <h4>Titre</h4>
                        <p>Artiste</p>
                    </div>
                </div>
                <div class=" br-t-1-s p-4 br-cus-5 bg-cus-1 text-cus-5 center-a ">
                    <a href='<?= "/controllers/RoutingController.php?accueil"?>'>
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="18" viewBox="0 0 576 512">
                            <path opacity="1" fill="currentColor" d="M575.8 255.5c0 18-15 32.1-32 32.1h-32l.7 160.2c0 2.7-.2 5.4-.5 8.1V472c0 22.1-17.9 40-40 40H456c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1H416 392c-22.1 0-40-17.9-40-40V448 384c0-17.7-14.3-32-32-32H256c-17.7 0-32 14.3-32 32v64 24c0 22.1-17.9 40-40 40H160 128.1c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2H104c-22.1 0-40-17.9-40-40V360c0-.9 0-1.9 .1-2.8V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z"/>
                        </svg>  
                    </a>
                    <a href='<?= "/controllers/RoutingController.php?biblio"?>'>
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                            <path opacity="1" fill="currentColor" d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                        </svg>
                    </a>
                    <p id="mobPlaylist">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M499.1 6.3c8.1 6 12.9 15.6 12.9 25.7v72V368c0 44.2-43 80-96 80s-96-35.8-96-80s43-80 96-80c11.2 0 22 1.6 32 4.6V147L192 223.8V432c0 44.2-43 80-96 80s-96-35.8-96-80s43-80 96-80c11.2 0 22 1.6 32 4.6V200 128c0-14.1 9.3-26.6 22.8-30.7l320-96c9.7-2.9 20.2-1.1 28.3 5z"/></svg>
                    </p>
                </div>
            </div>
            <div class=" max-media-500:hidden bg-cus-1 mx-4 mb-5 rounded-2 br-a-2-s px-4 py-3 center-b">
                <div class=" br-a-1-s p-2 bg-cus-6 rounded-2 center-b max-w-80 w-full">
                    <div class="center gap-y-2">
                        <img src="/public/ressources/Spotify_Images/Spotify_Image_2.jpeg" alt="artist image" loading="lazy" class="ml-1 img-cov w-12 h-12">
                        <div class="on-reading-artist">
                            <h4>Titre</h4>
                            <p>Artiste</p>
                        </div>
                    </div>
                    <div class=" center  mx-2 footer-on-reading-details">
                        <div class="play-pause-buttons">  
                            <p class=" center play-button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 512 512"><path opacity="1" fill="currentColor" d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9V344c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z"/></svg>
                            </p>
                            <!-- <p class="pause-button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 512 512"><path opacity="1" fill="#1E3050" d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm224-72V328c0 13.3-10.7 24-24 24s-24-10.7-24-24V184c0-13.3 10.7-24 24-24s24 10.7 24 24zm112 0V328c0 13.3-10.7 24-24 24s-24-10.7-24-24V184c0-13.3 10.7-24 24-24s24 10.7 24 24z"/></svg>
                            </p> -->
                        </div>
                    </div>
                </div>
                <div class="col-c mx-2 middle-footer-container">
                    <div class="center-b footer-top-middle-container">
                        <p class="previous-button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 320 512"><path opacity="1" fill="currentColor" d="M267.5 440.6c9.5 7.9 22.8 9.7 34.1 4.4s18.4-16.6 18.4-29V96c0-12.4-7.2-23.7-18.4-29s-24.5-3.6-34.1 4.4l-192 160L64 241V96c0-17.7-14.3-32-32-32S0 78.3 0 96V416c0 17.7 14.3 32 32 32s32-14.3 32-32V271l11.5 9.6 192 160z"/></svg>
                        </p>
                        <div class="play-pause-buttons">  
                            <p class="play-button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35" width="35" viewBox="0 0 512 512"><path opacity="1" fill="currentColor" d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9V344c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z"/></svg>
                            </p>
                            <!-- <p class="pause-button">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35" width="35" viewBox="0 0 512 512"><path opacity="1" fill="currentColor" d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm224-72V328c0 13.3-10.7 24-24 24s-24-10.7-24-24V184c0-13.3 10.7-24 24-24s24 10.7 24 24zm112 0V328c0 13.3-10.7 24-24 24s-24-10.7-24-24V184c0-13.3 10.7-24 24-24s24 10.7 24 24z"/></svg>
                            </p> -->
                        </div>
                        <p class="forward-button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 320 512"><path opacity="1" fill="currentColor" d="M52.5 440.6c-9.5 7.9-22.8 9.7-34.1 4.4S0 428.4 0 416V96C0 83.6 7.2 72.3 18.4 67s24.5-3.6 34.1 4.4l192 160L256 241V96c0-17.7 14.3-32 32-32s32 14.3 32 32V416c0 17.7-14.3 32-32 32s-32-14.3-32-32V271l-11.5 9.6-192 160z"/></svg>
                        </p>
                    </div>
                    <div class="center-b footer-bottom-middle-container">
                        <p id="currentTrackDuration">00:00</p>|
                            <!-- <form action="" class="current-footer-progression-bar">
                                <input type="range" min="0" max="100" step="1" value="0">
                            </form> -->
                        <p id="currentTrackMaxLenght">00:00</p>
                    </div>
                </div>
                <div class="right-footer-container">
                    <div class="center  gap-y-3 right-footer-icons">
                        <form action="" class="center volume"> 
                            <button type="button" class="text-cus-7 br-none bg-transparent c-p hovr-text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path opacity="1" fill="currentColor" d="M301.1 34.8C312.6 40 320 51.4 320 64V448c0 12.6-7.4 24-18.9 29.2s-25 3.1-34.4-5.3L131.8 352H64c-35.3 0-64-28.7-64-64V224c0-35.3 28.7-64 64-64h67.8L266.7 40.1c9.4-8.4 22.9-10.4 34.4-5.3zM412.6 181.5C434.1 199.1 448 225.9 448 256s-13.9 56.9-35.4 74.5c-10.3 8.4-25.4 6.8-33.8-3.5s-6.8-25.4 3.5-33.8C393.1 284.4 400 271 400 256s-6.9-28.4-17.7-37.3c-10.3-8.4-11.8-23.5-3.5-33.8s23.5-11.8 33.8-3.5z"/>
                                </svg>
                            </button>
                            <label class="w-3/5" for="Volume">
                                <input  class="w-full" type="range" name="volume" min="0" max="1" step="0.01" value="0.3"id="Volume">
                            </label>
                        </form>
                        <p class="options-footer">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                <path opacity="1" fill="currentColor" d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"/>
                            </svg>
                        </p>
                    </div>
                </div>
            </div>

