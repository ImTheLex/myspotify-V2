// 2024 : If on signup page.
if (document.querySelector('section[data-id="signup"]')){

    // function pursueSignUp() {
    //     let signUpButton = document.getElementById('bSignUp')
    //     counter ++
        
    //     if (counter === 2){
    //         updateButtonStatus(signUpButton,false)
    //     }
    //     if (counter > 2 ){
    //         pursueSignUpButton.innerText = "Terminer"
    //     }
    //     if (counter > 3){
    //         pursueSignUpButton.setAttribute('type','submit')
    //     }
    //     if (counter < 3){

    //         signUpStep1.classList.add('hidden');
    //         pursueSignUpButton.innerText = "Poursuivre (" + counter + "/3)"
    //         signUpStep2.classList.remove('hidden');

    //     }
    //     if (counter === 3){
    //         signUpStep2.classList.add('hidden');
    //         signUpStep3.classList.remove('hidden');
    //         let datasTab = document.querySelectorAll('section[data-id="signup"] input:not([type="password"]), section[data-id="signup"] select')
    //         let resumeValuesTab = Array.from(datasTab).map(input => input.value);
    //         let resumeTab = document.querySelectorAll('#emailResume,#userNameResume,#sexResume,#dateResume,#roleResume')
    //         resumeValuesTab.forEach((value,index) => resumeTab[index].outerHTML += `<p style="color:green;">${value || "<p style='color:green' Ce champ n'a pas été rempli!"}</p>`)
    //     }           
    // }


    
    function validateEmail(email) {
        return /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/i.test(email);
    }
    function validateUsername(username) {
        return /^[a-zA-Z0-9_-]{2,}$/i.test(username);
    }
    function validatePassword(password1,password2) {
        return password1 == password2;
    }
    function validateDateNaissance(event){
    
        let inputDate = event.currentTarget.value
        let now = new Date()
        now.getFullYear();
        let date = new Date(inputDate)

        // console.log(now.getFullYear(),date.getFullYear());
        let dateError = document.getElementById('signupDateNaissanceError')

        if ((date.getFullYear() < now.getFullYear()) && date.getFullYear() > 1900){
           
            dateError.classList.replace('block','hidden')
            return true;
        }
        dateError.classList.replace('hidden','block')
        return false;
        
    }

    if(document.getElementById('signUpArtistYes')){

        let artistNo = document.getElementById('signUpArtistNo');
        let artistYes = document.getElementById('signUpArtistYes');
        let artistNoLabel = artistNo.labels[0];
        let artistYesLabel = artistYes.labels[0];

        // If clicked is no then showing yes
        // LoginToken-active only shows on the html which one is chosen.
        artistNoLabel.addEventListener('click',function(){

            artistNoLabel.classList.add('bg-white')
            artistYesLabel.classList.remove('bg-white')

        })
        // If clicked is yes then showing no
        artistYesLabel.addEventListener('click',function(){
            artistNoLabel.classList.remove('bg-white')
            artistYesLabel.classList.add('bg-white')

        })

    }
    

}

