$(document).ready(function () {

    let timerVar;
    let totalSeconds = 0
    let timerStarted = false;
    let initialTime = 0;

    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if(this.readyState == 4){ //IF it has ended
            console.log(this.responseText)
            $("#prueba").html(this.responseText);
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/getOptions.php", true);
    xmlhttpGetOptions.send();

    $("#timerButton").click(function () {
        if (timerStarted == false) {
            timerVar = setInterval(countTimer, 1000);
            $("#timerButton p").text("Stop Timer");
            timerStarted = true;
            $("#timerButton").attr("class", "btn btn-info");
            initialTime = Date.now();
        } else {
            //We save the seconds elapsed
            console.log("Total Seconds: " + totalSeconds);
            clearInterval(timerVar);
            timerStarted = false;
            totalSeconds = 0;
            $("#timerButton").attr("class", "btn btn-primary");
            $("#timerButton p").text("Start Timer");
            $("#timer").html("00:00:00");
        }
    });

    function saveTime(seconds,idCourse,idType,idProject) {
        let xmlhttp = new XMLHttpRequest();
        

        let parametros = "?initialTime=" + + "&totaltime=" + seconds; 
        xmlhttp.onreadystatechange = function () { //Callback function
            if(this.readyState == 4){ //SI HA FINALIZADO
                alert("Time send correctly");
            }
            
        }
        //?fname=Henry&lname=Ford
        xmlhttp.open("GET", "./backend.php", true);
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


});

