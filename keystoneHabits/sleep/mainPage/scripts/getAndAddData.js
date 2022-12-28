$(document).ready(function(){

    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            $("#mainText").text(this.responseText); 
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/backend.php?name=" + name, true);
    xmlhttpGetOptions.send();

});