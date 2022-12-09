$(document).ready(function () {

    let timerVar;
    let totalSeconds = 0
    let timerStarted = false;
    let initialTime = 0;

    $("#timerButton").click(function () {
        if (timerStarted == false) {
            timerVar = setInterval(countTimer, 1000);
            $("#timerButton p").text("Stop Timer");
            timerStarted = true;
            $("#timerButton").attr("class", "btn btn-info");
            initialTime = Date.now();
        } else {
            //We save the seconds elapsed
            clearInterval(timerVar);
            timerStarted = false;
            saveTime(totalSeconds);
            totalSeconds = 0;
            $("#timerButton").attr("class", "btn btn-primary");
            $("#timerButton p").text("Start Timer");
            $("#timer").html("00:00:00");
        }
    });

    function saveTime(seconds) {
        data = getSelectedThings();
        let xmlhttp = new XMLHttpRequest();
        let parametros = "?initialTime=" +Date.now()+ "&totaltime=" + seconds + "&courseID=" + data["courseID"] 
        + "&projectID=" + data["projectID"] + "&typeOfStudyID=" + data["typeOfStudyID"] ; 
        xmlhttp.onreadystatechange = function () { //Callback function
            if(this.readyState == 4){ //SI HA FINALIZADO
                $("#prueba").text(this.responseText);
                alert("Time send correctly, queda pendiente la parte de añadir comentarios");
            }
        }
        xmlhttp.open("GET", "./backend/insertTime.php" + parametros, true);
        xmlhttp.send();
    }


    function countTimer() {
        ++totalSeconds;
        var hour = Math.floor(totalSeconds / 3600);
        var minute = Math.floor((totalSeconds - hour * 3600) / 60);
        var seconds = totalSeconds - (hour * 3600 + minute * 60);
        if (hour < 10)
            hour = "0" + hour;
        if (minute < 10)
            minute = "0" + minute;
        if (seconds < 10)
            seconds = "0" + seconds;
        $("#timer").html(hour + ":" + minute + ":" + seconds);
    }

})