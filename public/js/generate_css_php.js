/**
 * Generate_css_V2 This one gets all the classes from html current file  and sends a request with all the filtered used classes.
 * Once again, the purpose of it is for dev only.
 */
function generate_css_v2 (){
    let htmlnodes = document.querySelectorAll('[class]');

    let set = new Set()
    for(let htmlnode of htmlnodes){
        htmlnode.getAttribute('class').trim().split(' ').forEach(className => set.add(className))
    }
    let tableau = Array.from(set)    
    let formData = new FormData();

    tableau.forEach(function(value, index) {
        formData.append('rGenerateCss[]', value);
    });
        fetch('/../generate_css.php',{

            method: 'POST',
            body: formData
        })
}
document.addEventListener('DOMContentLoaded',function(){

    generate_css_v2();

})