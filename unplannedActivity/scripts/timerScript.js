/*
ALL OF THE FUNCTIONS RELATED TO FEATURES OF THE TIMER, SUCH AS CHANGING THE LAYOUT OF THE 
WEB PAGE FROM "START TIMER" MODE TO "STOP TIMER", THE LOGIC OF THE TICKING OF THE TIMER CLOCK
AND THE FUNCTION THAT SENDS THE TIME(AND OTHER DATA) TO THE BACKEND, THAT WILL PROCESS IT AND
SAVE IT TO THE DATABSE
*/


$(document).ready(function () {
    let timerVar;
    let secondsEllapsed = 0
    let timerStarted = false;
    let initialTimeDate = 0;

    $("#timerButton").click(function () {
        if (timerStarted == false) {
            //start the timer and get starting time
            timerVar = setInterval(countTimer, 1000); //start the ticking
            initialTimeDate = Math.floor(Date.now() / 1000);
            timerStarted = true;
            //change the start timer text and color from start timer to stop timer
            $("#timerButton p").text("Stop Timer");
            $("#timerButton").attr("class", "btn btn-info");
            //disable all the options buttons
            $("#selectCourseTitle").prop('disabled', true);
            $("#selectProjectTitle").prop('disabled', true);
            $("#selectTypeOfStudyTitle").prop('disabled', true);
            //ADD A "ARE YOU SURE YOU WANT TO EXIT?" popup
            window.onbeforeunload = function() {
                return true;
            };
        } else {
            //We save the seconds elapsed
            saveTime(secondsEllapsed);
            clearInterval(timerVar); //stop the ticking
            timerStarted = false;
            secondsEllapsed = 0;
            //Re enable options and change the text from "stop timer" to "start timer"
            $("#timerButton").attr("class", "btn btn-primary");
            $("#timerButton p").text("Start Timer");
            $("#timer").html("00:00:00");
            $("#selectCourseTitle").prop('disabled', false);
            $("#selectProjectTitle").prop('disabled', false);
            $("#selectTypeOfStudyTitle").prop('disabled', false);
            //remove the "are you sure you want to exit" popup
            window.onbeforeunload = null;
            }
    });

    function saveTime(seconds) {
        let params = new URLSearchParams(document.location.search);
        let name = params.get("name"); 
        let data = getSelectedThings();
        let xmlhttp = new XMLHttpRequest();
        let parametros = "?initialTime=" + initialTimeDate + "&totaltime=" + seconds + "&courseID=" + data["courseID"] 
        + "&projectID=" + data["projectID"] + "&typeOfStudyID=" + data["typeOfStudyID"] + "&name=" + name + "&description=" +encodeURI(data["description"]) +
        "&workingAlone=" + data["workingAlone"] + "&beingAlone=" + data["beingAlone"]; 
        console.log(parametros)
        xmlhttp.open("GET", "./backend/insertTime.php" + parametros, true);
        xmlhttp.send();
    }


    function countTimer() {
        secondsEllapsed = Math.floor(Date.now()/1000) - initialTimeDate;
        var hour = Math.floor(secondsEllapsed / 3600);
        var minute = Math.floor((secondsEllapsed - hour * 3600) / 60);
        var seconds = secondsEllapsed - (hour * 3600 + minute * 60);
        if (hour < 10)
            hour = "0" + hour;
        if (minute < 10)
            minute = "0" + minute;
        if (seconds < 10)
            seconds = "0" + seconds;
        $("#timer").html(hour + ":" + minute + ":" + seconds);
    }
})