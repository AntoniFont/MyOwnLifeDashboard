/*MISCELANEOUS FEATURES */
$(document).ready(function(){
    //HOUR
    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });
    //GET THE NAME OF THE USER
    let params = new URLSearchParams(document.location.search);
    username = params.get("name"); 
});