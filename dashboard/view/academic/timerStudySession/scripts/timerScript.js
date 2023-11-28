/*
ALL OF THE FUNCTIONS RELATED TO FEATURES OF THE TIMER, SUCH AS CHANGING THE LAYOUT OF THE 
WEB PAGE FROM "START TIMER" MODE TO "STOP TIMER", THE LOGIC OF THE TICKING OF THE TIMER CLOCK
AND THE FUNCTION THAT SENDS THE TIME(AND OTHER DATA) TO THE BACKEND, THAT WILL PROCESS IT AND
SAVE IT TO THE DATABSE
*/

let timerStarted = false;
let smallPauseStarted = false;
let timerVar;
let smallPauseVar;
let studySecondsEllapsed = 0
let initialStudyTimeDate = 0;
let breakSecondsEllapsed = 0;
let initialBreakTimeDate = 0;
let spotifySpecialFeatureEnabled = "false";
let SMALL_PAUSE_SECONDS = 180;

$(document).ready(function () {
    
    $("#timerButton").click(function () {
        if (timerStarted == false) {
            startStudyTimer();     
            $.ajax("./backend/setCurrentlyStudying.php",{
                method: "get",
                data:{
                    value: 1,
                    name: username,
                }
            });
        } else {
            stopStudyTimer();
            $.ajax("./backend/setCurrentlyStudying.php",{
                method: "get",
                data:{
                    value: 0,
                    name: username,
                }
            });
            //remove the "are you sure you want to exit" popup
            window.onbeforeunload = null;
        }
            
    });

    $("#smallPauseButton").click(function(){
        if(timerStarted == false && smallPauseStarted == false){
            alert("You can't start a pause if you aren't working!")
        }else if (timerStarted == true && smallPauseStarted == false){
            stopStudyTimer();
            changeTimer(SMALL_PAUSE_SECONDS)
            smallPauseStarted = true;
            $("#timer").css("color", "red");
            $("#smallPauseButton p").text("Stop small pause");
            $("#smallPauseButton").attr("class", "btn btn-info");
            initialBreakTimeDate = Math.floor(Date.now() / 1000);
            smallPauseVar = setInterval(smallPauseTimer,1000);
        }else if(timerStarted == false && smallPauseStarted==true){
            smallPauseStarted = false;
            $("#timer").css("color", "black");
            $("#smallPauseButton p").text("Start small pause")
            $("#smallPauseButton").attr("class", "btn btn-primary");
            clearInterval(smallPauseVar)
            startStudyTimer();
        }
        
    })

    function smallPauseTimer(){
        breakSecondsEllapsed = Math.floor(Date.now()/1000) - initialBreakTimeDate;
        number = SMALL_PAUSE_SECONDS - breakSecondsEllapsed;
        changeTimer(number);
        if(number <= 0){
            clearInterval(smallPauseVar)
            smallPauseStarted = false;
            $("#timer").css("color", "black");
            $("#smallPauseButton p").text("Start small pause")
            $("#smallPauseButton").attr("class", "btn btn-primary");
            $.ajax("./backend/setCurrentlyStudying.php",{
                method: "get",
                data:{
                    value: 0,
                    name: username,
                }
            });
        }
    }

    function startStudyTimer(){
        $("#timer").html("00:00:00");
        //start the timer and get starting time
        timerVar = setInterval(updateTimer, 1000); //start the ticking
        initialStudyTimeDate = Math.floor(Date.now() / 1000);
        timerStarted = true;
        //change the start timer text and color from start timer to stop timer
        $("#timerButton p").text("Stop Timer");
        $("#timerButton").attr("class", "btn btn-info");
        //disable all the options buttons
        $("#selectCourseTitle").prop('disabled', true);
        $("#selectProjectTitle").prop('disabled', true);
        $("#selectTriggerTitle").prop('disabled', true);
        $("#selectStudyCharacteristicsTitle").prop('disabled',true);
        //ADD A "ARE YOU SURE YOU WANT TO EXIT?" popup
        window.onbeforeunload = function() {
            return true;
        };
    }


    function stopStudyTimer(){
        //We save the seconds elapsed
        insertTimeDatabase(studySecondsEllapsed);
        clearInterval(timerVar); //stop the ticking
        timerStarted = false;
        studySecondsEllapsed = 0;
        //Re enable options and change the text from "stop timer" to "start timer"
        $("#timerButton").attr("class", "btn btn-primary");
        $("#timerButton p").text("Start Timer");
        $("#timer").html("00:00:00");
        $("#selectCourseTitle").prop('disabled', false);
        $("#selectProjectTitle").prop('disabled', false);
        $("#selectTriggerTitle").prop('disabled', false);
        $("#selectStudyCharacteristicsTitle").prop('disabled',false);
    }

    function insertTimeDatabase(seconds) {
        let dataSelected = getSelectedThings();
        $.ajax("./backend/insertTime.php",{
            method: "get",
            data:{
                totalTime: seconds,
                courseID: dataSelected["courseID"],
                projectID: dataSelected["projectID"],
                triggersID: dataSelected["triggersID"],
                studyCharacteristicsID: dataSelected["studyCharacteristicsID"],
                name: username,
            },
            error: function(){
                alert("Error al enviar los datos")
            }
        })
    }

    function updateTimer() {
        studySecondsEllapsed = Math.floor(Date.now()/1000) - initialStudyTimeDate;
        changeTimer(studySecondsEllapsed);
    }



    function changeTimer(secondsEllapsed){
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