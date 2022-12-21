/*THE FUNCTIONS THAT CALL THE BACKEND TO GET THE DATA AND PUT IT INSIDE THE CHARTS */


let baseline = 3600; //minutes

$(document).ready(function () {

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });


    //CHART 1 AND 2
    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            let responseJSON;
            let data = [];
            responseJSON = JSON.parse(this.responseText);
            data = formatDataChart1And2(data, responseJSON);
            //FILLED BOTH OPTIONS OBJECT WITH THE DATA (both objects share the same data but different configs)
            chart1Options.series[0].data = data;
            chart2Options.series[0].data = data;
            //CREATE THE 2 CHARTS FROM THE SHARED OPTIONS
            Highcharts.chart("chart1Container", chart1Options);
            Highcharts.chart("chart2Container", chart2Options);
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/chart1And2getData.php?name=" + username, true);
    xmlhttpGetOptions.send();

    function formatDataChart1And2(data, responseJSON) {
        for (let i = 0; i < responseJSON.length; i++) {
            data.push(
                {
                    "name": responseJSON[i][1],
                    "y": parseFloat(responseJSON[i][0])
                }
            )
        }
        return data;
    }

    //CHART 3 AND 4
    xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            let responseJSON;
            let dataChart3 = [];
            let dataChart4;
            responseJSON = JSON.parse(this.responseText);
            dataChart3 = formatDataChart3(dataChart3, responseJSON);
            dataChart4 = calculateDataChart4(responseJSON); 
            console.log(dataChart4);
            //display chart 3
            chart3Options.series[0].data = dataChart3;
            Highcharts.chart("chart3Container", chart3Options);
            //display chart 4 using the number-rush library
            new numberRush('chart4Container',{
                speed : 15,
                steps: 1,
                maxNumber: dataChart4
            })
        }
    }

    xmlhttpGetOptions.open("GET", "./backend/chart3And4getData.php?name=" + username + "&baseline=" + baseline, true);
    xmlhttpGetOptions.send();


    function formatDataChart3(data, responseJSON) {
        for (let i = 0; i < responseJSON.length; i++) {
            //TURN THE NUMBER OF MINUTES OF WORK INTO THE PERCENTAGE OF BASELINE COMPLETED
            let numberOfMinutes = parseFloat(responseJSON[i][0]);
            let percentageOfBaseline = (numberOfMinutes / baseline)*100;
            if(percentageOfBaseline > 100){ //no greather than 100% allowed
                percentageOfBaseline = 100;
            }
            //CONVERT THE DATE INTO THE RIGHT FORMAT
            let dateString = responseJSON[i][1];
            let [day, month, year] = dateString.split('-');
            let date = new Date(+year, +month - 1, +day);
            //ADD THE NEW DATA
            pointOfData = [date.getTime(),percentageOfBaseline];
            data.push(pointOfData)
        }
        return data;
    }

    function calculateDataChart4(responseJSON){
        let sumOfAllTimes =0;
        for (let i = 0; i<responseJSON.length; i++){
            let time = parseFloat(responseJSON[i][0]);
            if(time > baseline){
                time = baseline;
            }
            sumOfAllTimes += time;
        }
        let average = sumOfAllTimes / responseJSON.length;
        let averagePercentageOfBaseline = (average /baseline) * 100
        return averagePercentageOfBaseline.toFixed(2);
        //return 100
    }


});