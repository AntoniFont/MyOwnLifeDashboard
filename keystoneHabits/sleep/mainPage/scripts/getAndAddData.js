$(document).ready(function(){

    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            $("#mainText").html(this.responseText); 
            let JSONdata =JSON.parse(this.responseText);
            let startingTimesArr = [];
            let endingTimesArr = [];

            divideData(startingTimesArr,endingTimesArr,JSONdata)


            chart1Options.series[0].data = startingTimesArr;
            chart1Options.series[1].data = endingTimesArr;

            Highcharts.chart("chart1Container", chart1Options);
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/backend.php?name=" + name, true);
    xmlhttpGetOptions.send();

    function divideData(startingTimesArray,endingTimesArray,data){
        for(let i =0 ; i<data.length; i++){
            fullDatetimeString1 = data[i]["realWakingUp"];
            [onlyDateString1,onlyTimeString1] = fullDatetimeString1.split(" "); 
            secondsFromMidnight1 = Date.parse(fullDatetimeString1) - Date.parse(onlyDateString1)  
            
            fullDatetimeString2 = data[i]["lastAttemptGoingToSleep"];
            [onlyDateString2,onlyTimeString2] = fullDatetimeString2.split(" "); 
            secondsFromMidnight2 = Date.parse(fullDatetimeString2) - Date.parse(onlyDateString2)  
            
            if(secondsFromMidnight2 <= secondsFromMidnight1){ // you can't go to bed earlier than going to sleep
                console.log("dentro"); 
                secondsFromMidnight2 = secondsFromMidnight2 + 24*60*60*1000;
            }
            
            startingTimesArray.push(secondsFromMidnight1);
            endingTimesArray.push(secondsFromMidnight2);
        }
    }
    

});