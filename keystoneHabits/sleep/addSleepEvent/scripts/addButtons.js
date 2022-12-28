$(document).ready(function () {


    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            let responseJSON;
            responseJSON = JSON.parse(this.responseText);
            $("#contenedorItems").html(""); //empty everything
            for (let i = 0; i < responseJSON.length; i++) {
                let onclickHtml = "onclick=\"categorySelected('" + responseJSON[i][0] + "','" + responseJSON[i][1] + "')\""
                let fullHtml = "<li><a class=\"dropdown-item\"" + onclickHtml + ">" + responseJSON[i][0] + "</a></li>"
                $("#contenedorItems").append(fullHtml);
            }
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/getCategoriesOfSleepEventTypes.php", true);
    xmlhttpGetOptions.send();








});

function categorySelected(name, description) {
    $("#dropdownTexto").text(name);
    $("#descriptionOfCategory").text(description);
    createButtons(name);
}

function createButtons(categoryName) {
    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            $("#buttonsContainer").html(""); //empty
            let data = JSON.parse(this.responseText);
            for (let i = 0; i < data.length; i++) {
                let text = data[i][1];
                let id = data[i][0]
                let string = "<li onclick=\"buttonClicked(" + id + ")\">" + "<button class = \"btn btn-primary mt-3\">" + text + " </button></li> ";
                $("#buttonsContainer").append(string)
            }
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/getTypesOfSleepEvents.php?categoryName=" + categoryName, true);
    xmlhttpGetOptions.send();
}


function buttonClicked(id) {
    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            alert("Enviado!");
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/saveSleepEvent.php?name=" + username + "&id=" + id, true);
    console.log("./backend/saveSleepEvent.php?name=" + username + "&id=" + id);
    xmlhttpGetOptions.send();
}