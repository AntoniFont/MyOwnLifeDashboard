$(document).ready(function() {

    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            let responseJSON;
            let data = [];
            responseJSON = JSON.parse(this.responseText);
            data = formatData(data,responseJSON);
            //FILLED BOTH OPTIONS OBJECT WITH THE DATA (both objects share the same data but different configs)
            chart1Options.series[0].data = data;
            chart2Options.series[0].data = data;
            //CREATE THE 2 CHARTS FROM THE SHARED OPTIONS
            Highcharts.chart("chart1Container",chart1Options);
            Highcharts.chart("chart2Container",chart2Options);
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/chart1And2getData.php", true);
    xmlhttpGetOptions.send();

    function formatData(data,responseJSON){
        for(let i=0;i<responseJSON.length;i++){
            data.push(
                {
                    "name": responseJSON[i][1],
                    "y": parseFloat(responseJSON[i][0])
                }
            )
        }
        return data;
    }


});