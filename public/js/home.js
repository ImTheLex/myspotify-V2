

// I know thoses 2 are "duplicates" for now it will remain like this.

/**
 * Function with the purpose to show a preview of the inserted image (input file)
 */
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

/**
 * Function with the purpose to show a preview of the inserted image (input file)
 */
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

/**
 * Reset the audio buttons to the play visual states
 */
function resetAudioButtons(){

    document.querySelectorAll('.pause-button').forEach(button => {
        button.style.display = ""
    })
    document.querySelectorAll('.play-button').forEach(button => {
        button.style.display = ""
    })
    document.querySelectorAll('.tracks-table tr .reading .orderNumber').forEach(p => {
        p.style.display = ""
    })
    document.querySelectorAll('.tracks-table tr .reading').forEach(td => {
        td.classList.remove('reading')
    })
}

/**
 * A bit complicated but will be triggered when relevant button is clicked, then will manage the buttons displays regarding to "play" status.
 * In this case the event is more important as its easier to locate the good url to play.
 * @param {*} event 
 */
function playAudio(event) {
    let audio = document.getElementById('audio');
    let audioVolume = document.getElementById('Volume');
    audioVolume.addEventListener('change', function(event){
        console.log(audioVolume, event.currentTarget);
        audio.volume = event.currentTarget.value
    })
    // let currentDuration = event.currentTarget.parentNode.parentNode.parentNode.querySelector('[data-id="duration"]').innerHTML
    // document.getElementById('currentTrackMaxLenght').innerHTML = currentDuration;

    audio.addEventListener('loadedmetadata', function() {
        let totalMinutes = Math.floor(audio.duration / 60);
        let totalSeconds = Math.floor(audio.duration - totalMinutes * 60);
        let formattedTotalTime = (totalMinutes < 10 ? '0' : '') + totalMinutes + ':' + (totalSeconds < 10 ? '0' : '') + Math.round(totalSeconds);
        document.getElementById('currentTrackMaxLenght').innerHTML = formattedTotalTime;
    });

    audio.addEventListener('timeupdate', function() {
        let minutes = Math.floor(audio.currentTime / 60);
        let seconds = Math.floor(audio.currentTime - minutes * 60);
        let formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        document.getElementById('currentTrackDuration').innerHTML = formattedTime;
    });

    if(!audio.querySelector('source')){
        audio.innerHTML = '<source src="" type="audio/mpeg">'
    }
    let source = audio.querySelector('source');
    if(source.getAttribute('src') === "" || source.getAttribute('src') !== event.currentTarget.value){
        source.src = event.currentTarget.value;
        audio.load()
    }
    resetAudioButtons();
    event.currentTarget.style.display = "none"
    event.currentTarget.parentNode.parentNode.classList.add('reading')
    event.currentTarget.parentNode.querySelector('.orderNumber').style.display="none"
    event.currentTarget.parentNode.querySelector('.pause-button').style.display="block"
    audio.play();
}
/**
 * A bit complicated but will be triggered when relevant button is clicked, then will manage the buttons displays regarding to "pause" status.
 * @param {*} event 
 */
function pauseAudio(event) {
    let audio = document.getElementById('audio');
    event.currentTarget.style.display = "none"
    event.currentTarget.parentNode.parentNode.classList.remove('reading')
    event.currentTarget.parentNode.querySelector('.orderNumber').style.display=""
    event.currentTarget.parentNode.querySelector('.play-button').style.display=""
    audio.pause();
}

document.addEventListener('DOMContentLoaded', function() {

    // In this block if we can find .tracks-table, then it probably means that we are visualizing either a playlist or an artist. So we look forward for the "audio" tag to attach an "ended" listener.
    if(document.querySelector('.tracks-table')){
        let audio = document.getElementById('audio')
        
        if(audio.getAttribute('src') !== ""){
            audio.addEventListener('ended', function(){
                resetAudioButtons();
            })
        } 
    }
    
    if(document.getElementById('createTrackForm')){

        let audio = new Audio();
        let duration;
      
        
        // Listen for changes on the audio link field
        // document.getElementById('createTrackLink').addEventListener('change', function() {
        //     let url = this.value;
        //     let proxy = 'https://cors-anywhere.herokuapp.com/'
        //     let proxyUrl = proxy + url;
        //     let body = document.querySelector('body')
        //     fetch(proxyUrl)
        //     .then(response => response.blob())
        //     // .then(blob => console.log(blob))

        //     .then(blob => blob.text())
        //     .then(text => body.innerHTML = text)
        //     // .then(text => console.log(text))
        //     // audio.src = ;
        // });

        // Listen for changes on the audio link field file
        document.getElementById('createTrackLinkFile').addEventListener('change', function() {

            let file = this.files[0];
            let url = URL.createObjectURL(file);
            audio.src = url;
            // console.log(file);
            document.getElementById('createTrackLink').value = file.name;
        });

        // Update the audio source
        audio.onerror = function() {

            console.log('Invalid audio source');
            if (audio.src === '') return;
            audio.src = ''; // Reset the audio source
            document.getElementById('createTrackDuration').value = 0;
            return; // Exit the function
        };
            
        // When the audio metadata is loaded, store the duration
        audio.onloadedmetadata = function(){
            console.log(audio.duration,audio.src,document.getElementById('createTrackForm'));
            duration = audio.duration * 1000;
            document.getElementById('createTrackDuration').value = duration;
        };
    }
    
    // Gère le l'animation du bouton search de left-container par application de classe
//     let leftSearchBox = document.querySelectorAll('.form-left-side-container form , .form-left-side-container form input')
//     let searchIcon = document.querySelector('#Search_Icon_2')
//     let searchInput = document.querySelector('#Search_Input')

//     searchIcon.addEventListener('click', () => {
//         let clientLibrary = document.querySelectorAll('.left-scrollable-container :is(.artist-name, .playlist-name)')
        
//         for (let item of leftSearchBox) {
//             item.classList.toggle('searching')           
//         }
//         if(searchInput.classList.contains('searching')){

//             // Gère la recherche dans la bibliothèque.                
//             searchInput.addEventListener('input', function () {
//             let inputLetters = searchInput.value.toLowerCase()
//             for (let data of clientLibrary){    
//                 let dataText = data.innerText.toLowerCase()              
//                 if (dataText.includes(inputLetters))
//                 {
//                     data.parentNode.parentNode.style.display= "flex"
//                 }                
//                 else {
//                     data.parentNode.parentNode.style.display = "none"
//                 }
//             }
//             })
//         }
//     })
});

            