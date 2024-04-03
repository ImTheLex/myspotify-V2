// 2024 : If on signup page.
if (document.querySelector('section[data-id="signup"]')){

    const signUpStep1 = document.getElementById('signUpStep1');
    const signUpStep2 = document.getElementById('signUpStep2');
    const signUpStep3 = document.getElementById('signUpStep3');
    const pursueSignUpDiv = document.getElementById('pursueSignUpDiv');
    let pursueSignUpButton = pursueSignUpDiv.querySelector('button');
    var counter = 1;

    function consentSignUpRisk() {
        let consentSignUpRiskContainer = document.getElementById('consentSignUpRisk');
        consentSignUpRiskContainer.remove();
        signUpStep1.classList.remove('hidden');
        pursueSignUpDiv.classList.remove('hidden')
    }

    function pursueSignUp() {
        let signUpButton = document.getElementById('bSignUp')
        counter ++
        
        if (counter === 2){
            updateButtonStatus(signUpButton,false)
        }
        if (counter > 2 ){
            pursueSignUpButton.innerText = "Terminer"
        }
        if (counter > 3){
            pursueSignUpButton.setAttribute('type','submit')
        }
        if (counter < 3){

            signUpStep1.classList.add('hidden');
            pursueSignUpButton.innerText = "Poursuivre (" + counter + "/3)"
            signUpStep2.classList.remove('hidden');

        }
        if (counter === 3){
            signUpStep2.classList.add('hidden');
            signUpStep3.classList.remove('hidden');
            let datasTab = document.querySelectorAll('section[data-id="signup"] input:not([type="password"]), section[data-id="signup"] select')
            let resumeValuesTab = Array.from(datasTab).map(input => input.value);
            let resumeTab = document.querySelectorAll('#emailResume,#userNameResume,#sexResume,#dateResume,#roleResume')
            resumeValuesTab.forEach((value,index) => resumeTab[index].outerHTML += `<p style="color:green;">${value || "<p style='color:green' Ce champ n'a pas été rempli!"}</p>`)
        }           
    }


    function validateForm(){

        let signUpButton = document.getElementById('bSignUp')
        let email = document.getElementById('signUpEmail').value;
        let emailError = document.getElementById('signupEmailError');
        let isValid = true;

        if(email !== ""){
            if(validateEmail(email)){
                emailError.classList.replace('block','hidden');
            }   
            else{
                emailError.classList.replace('hidden','block');
                isValid = false;
            }
        }

        let password1 = document.getElementById('signUpPassword1').value
        let password2 = document.getElementById('signUpPassword2').value
        let passwordsError = document.getElementById('signUpPasswordsError')


        if(password1 !== "" && password2  !== ""){
            if(validatePassword(password1,password2)){
                passwordsError.classList.replace('block','hidden');
            }
            else{
                passwordsError.classList.replace('hidden','block');
                isValid = false;
            }
        }

        let username = document.getElementById('signUpUsername').value
        let usernameError = document.getElementById('signUpUsernameError')

        if(username !== ""){
            if(validateUsername(username)){
                usernameError.classList.replace('block','hidden');
            }
            else{
                usernameError.classList.replace('hidden','block');
                isValid = false;                
            }
        }  

        if(isValid && (email !== "") && (password1 !== "") && (password2 !== "") && (username !== "")){
            updateButtonStatus(signUpButton,true)
        } else {
            updateButtonStatus(signUpButton,false)
        }

        
    }

    function updateButtonStatus(button, isEnabled) {
        console.log(button)
        if (isEnabled) {
            button.classList.replace('c-na','c-p');
            button.disabled = false;

        } else {
            
            button.classList.replace('c-p','c-na');
            button.disabled = true;


        }
    }
    
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
    
        let signUpButton = document.getElementById('bSignUp')
        let inputDate = event.currentTarget.value
        let now = new Date()
        now.getFullYear();
        let date = new Date(inputDate)

        console.log(now.getFullYear(),date.getFullYear());
        let dateError = document.getElementById('signupDateNaissanceError')

        if ((date.getFullYear() < now.getFullYear()) && date.getFullYear() > 1900){
           
            dateError.classList.replace('block','hidden')
            updateButtonStatus(signUpButton,true)
            return true;
        }
        dateError.classList.replace('hidden','block')
        updateButtonStatus(signUpButton,false)
        return false;
        
    }
}
