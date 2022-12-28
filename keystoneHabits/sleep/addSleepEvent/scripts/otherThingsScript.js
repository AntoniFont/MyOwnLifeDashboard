/*MISCELANEOUS FEATURES */
let username;
$(document).ready(function(){
    //GET THE NAME OF THE USER
    let params = new URLSearchParams(document.location.search);
    username = params.get("name"); 
});