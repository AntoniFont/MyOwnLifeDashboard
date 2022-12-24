/*MISCELANEOUS FEATURES */

let username;
$(document).ready(function () {
    //GET THE NAME OF THE USER
    let params = new URLSearchParams(document.location.search);
    username = params.get("name"); 
    //UPDATE THE (current) IN THE NAVBAR
    $("#unplannedActivityNavbar").html("Unplanned activity <span class=\"sr-only\">(current)");
    //THE QUESTION 1 AND 2 LOGIC
    //if the question1 == yes,  then the second question should be displayed. 
    //if the questio1 == no, then the second question should be displayed.

    $("#question1Yes").click(function (){
        $("#secondQuestion").show();
    });
    
    $("#question1No").click(function (){
        $("#secondQuestion").hide();
    });

});