$(document).ready(function () {

    let timerVar;
    let totalSeconds = 0
    let timerStarted = false;
    let initialTimeDate = 0;

    $("#timerButton").click(function () {
        if (timerStarted == false) {
            timerVar = setInterval(countTimer, 1000);
            $("#timerButton p").text("Stop Timer");
            timerStarted = true;
            $("#timerButton").attr("class", "btn btn-info");
            initialTimeDate = Math.floor(Date.now() / 1000);
            $("#selectCourseTitle").prop('disabled', true);
            $("#selectProjectTitle").prop('disabled', true);
            $("#selectTypeOfStudyTitle").prop('disabled', true);
        } else {
            //We save the seconds elapsed
            clearInterval(timerVar);
            timerStarted = false;
            saveTime(totalSeconds);
            totalSeconds = 0;
            $("#timerButton").attr("class", "btn btn-primary");
            $("#timerButton p").text("Start Timer");
            $("#timer").html("00:00:00");
            $("#selectCourseTitle").prop('disabled', false);
            $("#selectProjectTitle").prop('disabled', false);
            $("#selectTypeOfStudyTitle").prop('disabled', false);
        }
    });

    function saveTime(seconds) {
        let params = new URLSearchParams(document.location.search);
        let name = params.get("name"); 
        let data = getSelectedThings();
        let xmlhttp = new XMLHttpRequest();
        let parametros = "?initialTime=" + initialTimeDate + "&totaltime=" + seconds + "&courseID=" + data["courseID"] 
        + "&projectID=" + data["projectID"] + "&typeOfStudyID=" + data["typeOfStudyID"] + "&name=" + name; 
        console.log(parametros);
        xmlhttp.onreadystatechange = function () { //Callback function
            if(this.readyState == 4){ //SI HA FINALIZADO
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
        currentTimeDate = Math.floor(Date.now() / 1000)
        var totalSecondsEllapsed = currentTimeDate - Math.floor(initialTimeDate)
        var debugString ="<p><b>DEBUG:</b><br>";
        debugString+= "totalSecondsCounted=" + totalSeconds + "(" + totalSeconds/60 + "minutes)";
        debugString+= "<br> totalSecondsEllapsed=" + totalSecondsEllapsed + "(" + totalSecondsEllapsed/60 + "minutes)" ;
        debugString+= "<br> initialTimeDate=" + initialTimeDate;
        debugString+= "(" + DEBUGtimeConverter(initialTimeDate) + ")";
        debugString+= "<br> currentTimeDate=" + currentTimeDate + "(" + DEBUGtimeConverter(currentTimeDate) + ")";
        $("#DEBUG").html(debugString);
    }


    function DEBUGtimeConverter(UNIX_timestamp){
        var a = new Date(UNIX_timestamp * 1000);
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
        return time;
      }

})