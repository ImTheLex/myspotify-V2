    

// Gère la création d'un menu d'options de création de playlist sur base de l'interaction avec le bouton create-playlist.
if(document.querySelector('.left-container')){
// console.log('coucou')
let createPlaylistContainer = document.querySelector('.create-playlist')
let createPlaylistOptions = document.getElementById('Create_Playlist_Options')

    createPlaylistContainer.addEventListener('click', function() {

            createPlaylistOptions.classList.toggle('hidden')

    })
}


// 2024 : Création playlist.

    // function create_playlist (){   
    //     let formData = new FormData();
    //     formData.append('bCreatePlaylist',true)
    //     fetch( '../controllers/PlaylistController.php',{

    //         method: 'POST',
    //         body: formData
    //     }).then(response => {

    //         window.location.reload();
    //     })
    // }

// 2024 : Open playlist.

    function open_playlist(playlist_id){ 
        let formData = new FormData();
        formData.append('bOpenPlaylist',true)
        formData.append('playlist_id',playlist_id)
        fetch( '/controllers/PlaylistController.php',{

            method: 'POST',
            body: formData
        }).then(response => {

            window.location.reload();
        })
    }

// 2024: drop playlist
function call_drop_playlist(event,playlistId) {

    let formData = new FormData();
    formData.append('bDropPlaylist', true);
    formData.append('playlist_id', playlistId);
    fetch('/controllers/PlaylistController.php', {
        method: 'POST',
        body: formData
    }).then(response => {

        window.location.reload();
    })
    event.currentTarget.parentNode.parentNode.remove()

}


// 2024: Toggle playlist display

    function toggle_playlists_display(){
        let playlistDisplayContainer = document.querySelector('.playlist-display')
        let globalFeedDisplayContainer = document.querySelector('.global-feed')
        globalFeedDisplayContainer.classList.remove('hidden')
        playlistDisplayContainer.classList.add('hidden')
    }

    function display_edit_playlist(event){
        event.currentTarget.parentNode.parentNode.classList.toggle('hidden');
        document.getElementById('updatePlaylistForm').classList.toggle('hidden');
    }



    function add_color(event){
        event.currentTarget.classList.add("bg-cus-8 text-black")
    }
    // Gère les coeurs roses
    if(document.querySelector('.left-container')){

    function togglePinkHearts() {

        let heartSvg = event.target.children[0];

            if(heartSvg.style.fill === 'fuchsia') {

                heartSvg.style.fill = 'var(--Light_White)'

            }else{

                    heartSvg.style.fill = 'fuchsia'
            }
    }


    // Gère le display et responsive du left container
        
    let leftContainer = document.querySelector('.left-container')
    let observerLeftContainer = new ResizeObserver(entries => {
        
        // for(let entry of entries){
        //     if (entry.target.clientWidth < 370){
        //         document.querySelector('.middle-container').classList.replace('col-b','hidden');
        //     }
        //     else{
        //         document.querySelector('.middle-container').classList.add('col-b');
        //     }
        // }

        for (let entry of entries) {
            let removedElements = leftContainer.querySelectorAll('.h2, h2 , h3 , h4 , p, .form-left-side-container, .biblio-icons')
            let allOptimizableElements = leftContainer.querySelectorAll('.left-scrollable-container .artist , .left-scrollable-container .new-playlist , a , .bottom-left-top-container , .left-scrollable-container>div>div');

            if(entry.target.clientWidth < 210) {

                

                removedElements.forEach(item => {
                    item.style.display = "none";
                
                    allOptimizableElements.forEach(el => {
                        if (el !== item) {
                            el.style.justifyContent="center"
                            el.style.columnGap="0px"
                        }
                    });
                })
            

            
            } else {

                
                removedElements.forEach(item => {
                    item.style.display =""

                    allOptimizableElements.forEach(el => {
                        if (el !== item) {
                            el.style.justifyContent=""
                            el.style.columnGap=""

                        }
                    });
                })
            }
        }
    })

    observerLeftContainer.observe(leftContainer)

    // Gère le l'animation du bouton search de left-container par application de classe
        let leftSearchBox = document.querySelectorAll('.form-left-side-container form , .form-left-side-container form input')
        let searchIcon = document.querySelector('#Search_Icon_2')
        let searchInput = document.querySelector('#Search_Input')

        searchIcon.addEventListener('click', () => {
            let clientLibrary = document.querySelectorAll('.left-scrollable-container :is(.artist-name, .playlist-name)')
            
            for (let item of leftSearchBox) {
                item.classList.toggle('searching')           
            }
            if(searchInput.classList.contains('searching')){

                // Gère la recherche dans la bibliothèque.                
                searchInput.addEventListener('input', function () {
                let inputLetters = searchInput.value.toLowerCase()
                for (let data of clientLibrary){    
                    let dataText = data.innerText.toLowerCase()              
                    if (dataText.includes(inputLetters))
                    {
                        data.parentNode.parentNode.style.display= "flex"
                    }                
                    else {
                        data.parentNode.parentNode.style.display = "none"
                    }
                }
                })
            }
        })
    }
            