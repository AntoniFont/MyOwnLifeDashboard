/*MISCELANEOUS FEATURES */
$(document).ready(function(){
    //GET THE NAME OF THE USER
    let params = new URLSearchParams(document.location.search);
    username = params.get("name"); 
    //UPDATE THE (current) IN THE NAVBAR
    $("#academicMainPage").html("Main page <span class=\"sr-only\">(current)");
});