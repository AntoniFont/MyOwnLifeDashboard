$(document).ready(function () {

    let timerVar;
    let totalSeconds = 0
    let timerStarted = false;

    $("#timerButton").click(function(){
        if(timerStarted == false){
            timerVar = setInterval(countTimer, 1000);
            $("#timerButton p").text("Stop Timer");
            timerStarted = true;
            $("#timerButton").attr("class","btn btn-info");
        }else{
            //We save the seconds elapsed
            console.log("Total Seconds: " + totalSeconds);
            clearInterval(timerVar);
            timerStarted = false;
            totalSeconds = 0;
            $("#timerButton").attr("class","btn btn-primary");
            $("#timerButton p").text("Start Timer");
            $("#timer").html("00:00:00");
        }
    });

    
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

