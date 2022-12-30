$(document).ready(function(){

    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            $("#mainText").html(this.responseText); 
            let JSONdata =JSON.parse(this.responseText);
            let startingTimes = [];
            let endingTimes = [];

            divideData(startingTimes,endingTimes,JSONdata)

            chart1Options.series[0].data = startingTimes;
            chart1Options.series[1].data = endingTimes;

            Highcharts.chart("chart1Container", chart1Options);
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/backend.php?name=" + name, true);
    xmlhttpGetOptions.send();

    function divideData(startingTimesArray,endingTimesArray,data){
        for(let i =0 ; i<data.length; i++){
            let fullDatetimeString1 = data[i]["realWakingUp"];
            let [onlyDateString1,onlyTimeString1] = fullDatetimeString1.split(" "); 
            let secondsFromMidnight1 = Date.parse(fullDatetimeString1) - Date.parse(onlyDateString1)  
            startingTimesArray.push(secondsFromMidnight1);

            fullDatetimeString2 = data[i]["lastAttemptGoingToSleep"];
            let [onlyDateString2,onlyTimeString2] = fullDatetimeString2.split(" "); 
            let secondsFromMidnight2 = Date.parse(fullDatetimeString2) - Date.parse(onlyDateString2)  
            endingTimesArray.push(secondsFromMidnight2);
        }
    }
    

});