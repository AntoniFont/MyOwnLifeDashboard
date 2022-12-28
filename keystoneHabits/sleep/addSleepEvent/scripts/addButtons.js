$(document).ready(function(){

    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            let responseJSON;
            responseJSON = JSON.parse(this.responseText);
            createButtons(responseJSON)
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/getTypesOfSleepEvents.php", true);
    xmlhttpGetOptions.send();

    function createButtons(data){
        for(let i = 0; i<data.length;i++){
            let text = data[i][1];
            let id = data[i][0]
            let string = "<li onclick=\"buttonClicked(" + id+ ")\">" + "<button class = \"btn btn-primary mt-3\">" + text + " </button></li> "; 
            $("#buttonsContainer").append(string)
        }
    }


});

function buttonClicked(id){
    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            alert("Enviado!");
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/saveSleepEvent.php?name=" +username + "&id=" + id , true);
    console.log("./backend/saveSleepEvent.php?name=" +username + "&id=" + id);
    xmlhttpGetOptions.send();
}