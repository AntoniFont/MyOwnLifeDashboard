$(document).ready(function() {

    let resposta;
    let data = [];


    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            resposta = JSON.parse(this.responseText);
            formatData();
            chart1Options.series[0].data = data;
            Highcharts.chart("chart1Container",chart1Options);
            console.log(resposta[0][0])
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/chart1.php", true);
    xmlhttpGetOptions.send();

    function formatData(){
        for(let i=0;i<resposta.length;i++){
            data.push(
                {
                    "name": resposta[i][1],
                    "y": parseInt(resposta[i][0])
                }
            )
        }
    }


});