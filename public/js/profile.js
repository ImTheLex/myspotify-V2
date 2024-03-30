function previewImage() {
    let reader = new FileReader();
    let fileTarget = document.getElementById('userImgUpdate')
    reader.onload = function(){
        let output = document.getElementById('profileUpdatePicture');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(fileTarget.files[0]);
}
function add_color(event){
    let classestoreplace = ["bg-cus-3", "text-cus-7"]
    let newclass= ["bg-cus-7","text-black","br-cus-c-7"]
    classestoreplace.forEach((oldclass,index) => {
        event.currentTarget.classList.replace(oldclass,newclass[index])
    });
    event.currentTarget.classList.replace()
}
function remove_color(event){
    let newclass = ["bg-cus-3", "text-cus-7"]
    let classestoreplace= ["bg-cus-7","text-black","br-cus-c-7"]
    classestoreplace.forEach((oldclass,index) => {
        event.currentTarget.classList.replace(oldclass,newclass[index])
    });
    event.currentTarget.classList.replace()
    
}