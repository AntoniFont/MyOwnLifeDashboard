/*THE FUNCTIONS THAT CALL THE BACKEND TO GET THE DATA AND PUT IT INSIDE THE CHARTS */


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

    //CHART 3
    xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            let responseJSON;
            let data = [];
            responseJSON = JSON.parse(this.responseText);
            data = formatDataChart3(data, responseJSON);
            chart3Options.series[0].data = data;
            //CREATE THE 2 CHARTS FROM THE SHARED OPTIONS
            Highcharts.chart("chart3Container", chart3Options);
        }
    }

    function formatDataChart3(data, responseJSON) {
        for (let i = 0; i < responseJSON.length; i++) {
            let dateString = responseJSON[i][1];
            let [day, month, year] = dateString.split('-');
            let date = new Date(+year, +month - 1, +day);
            //timeHighcharts = new Highcharts.Time();
            //dateFinal = timeHighcharts.dateFormat('%d-%m-%Y',date);
            pointOfData = [date.getTime(),parseFloat(responseJSON[i][0])];
            console.log(pointOfData)
            data.push(pointOfData)
        }
        console.log(data);
        return data;
    }

    xmlhttpGetOptions.open("GET", "./backend/chart3getData.php?name=" + username, true);
    xmlhttpGetOptions.send();

});