// 2024 : If on login page.
if (document.querySelector('section[data-id="login"]')){

    // loginToken.
    let tokenNo = document.getElementById('loginTokenNo');
    let tokenYes = document.getElementById('loginTokenYes');
    console.log(tokenNo,tokenNo.labels);
    let tokenNoLabel = tokenNo.labels[0];
    let tokenYesLabel = tokenYes.labels[0];

    // If clicked is no then showing yes
    // LoginToken-active only shows on the html which one is chosen.
    tokenNo.addEventListener('click',function(){
        tokenYesLabel.classList.replace('hidden','block')
        tokenNoLabel.classList.replace('block','hidden')

    })
    // If clicked is yes then showing no
    tokenYes.addEventListener('click',function(){
        tokenYesLabel.classList.replace('block','hidden')
        tokenNoLabel.classList.replace('hidden','block')
    })
    // Results in small indication whether wish to remember or not with a token.

}