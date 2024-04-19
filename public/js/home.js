    

function previewImagePlaylist() {
    let reader = new FileReader();
    let fileTarget = document.getElementById('updatePlaylistPicture')
    reader.onload = function(){
        let output = document.getElementById('playlistUpdatePicture');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(fileTarget.files[0]);
}

function previewImageArtist() {
    let reader = new FileReader();
    let fileTarget = document.getElementById('updateArtistPicture')
    reader.onload = function(){
        let output = document.getElementById('artistImg');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(fileTarget.files[0]);
}

function playAudio(event) {
    let audio = event.currentTarget.parentNode.querySelector('audio');
    audio.play();
}
function pauseAudio(event) {
    let audio = event.currentTarget.parentNode.querySelector('audio');
    audio.pause();
}

document.addEventListener('DOMContentLoaded', function() {
    
    
    if(document.getElementById('createTrackLink')){

        var audio = new Audio();
        var duration;
      
        // Listen for changes on the audio link field
        document.getElementById('createTrackLink').addEventListener('change', function() {
            // Update the audio source
            audio.src = this.value;

            audio.onerror = function() {
                console.log('Invalid audio source');
                audio.src = ''; // Reset the audio source
                document.getElementById('createTrackDuration').value = 0;
                return; // Exit the function
            };
            
            // When the audio metadata is loaded, store the duration
            audio.onloadedmetadata = function(){
                console.log(audio.duration,audio.src,document.getElementById('createTrackForm'));
                duration = audio.duration;
                document.getElementById('createTrackDuration').value = duration;
            };
        });

    }
    
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
});

            