let baseline = 3600; //minutes
$(document).ready(function () {

    
    $.ajax("./backend/chart3And4getData.php",{
        method: "GET",
        data :{
            "name": username ,
            "baseline" : baseline,
        },
        error : function(){
            alert("Error al hacer la petición para las gráficas 3 y 4");
        },
        success: function(responseText){
            let responseJSON;
            let dataChart3 = [];
            let dataChart4;
            try {
                responseJSON = JSON.parse(responseText);
                dataChart3 = formatDataChart3(dataChart3, responseJSON);
                dataChart4 = calculateDataChart4(responseJSON);
                //display chart 3
                chart3Options.series[0].data = dataChart3;
                Highcharts.chart("chart3Container", chart3Options);
                //display chart 4 using the number-rush library
                let objetivo
                $.ajax("./backend/getConsistencyObjectiveNumber.php",{
                    method:"GET",data:{"name":username},success:function(numberText){
                        console.log("numberText" + numberText)
                        objetivo = JSON.parse(numberText)
                        if(dataChart4 < objetivo){
                            $("#consistencyObjective").css("color", "red");
                        }
                    }
                })
                

                new numberRush('chart4Container', {
                    speed: 15,
                    steps: 1,
                    maxNumber: dataChart4
                })
            } catch (error) {
                alert("Error en los datos recibidos para las gráficas 3 y 4" + responseText);
            }
        }

    })
    
    function formatDataChart3(data, responseJSON) {
        for (let i = 0; i < responseJSON.length; i++) {
            //TURN THE NUMBER OF MINUTES OF WORK INTO THE PERCENTAGE OF BASELINE COMPLETED
            let numberOfMinutes = parseFloat(responseJSON[i][0]);
            let percentageOfBaseline = (numberOfMinutes / baseline) * 100;
            if (percentageOfBaseline > 100) { //no greather than 100% allowed
                percentageOfBaseline = 100;
            }
            //CONVERT THE DATE INTO THE RIGHT FORMAT
            let dateString = responseJSON[i][1];
            let [day, month, year] = dateString.split('-');
            let date = new Date(+year, +month - 1, +day);
            //ADD THE NEW DATA
            pointOfData = [date.getTime(), percentageOfBaseline];
            data.push(pointOfData)
        }
        return data;
    }

    function calculateDataChart4(responseJSON) {
        let sumOfAllTimes = 0;
        for (let i = 0; i < responseJSON.length; i++) {
            let time = parseFloat(responseJSON[i][0]);
            if (time > baseline) {
                time = baseline;
            }
            sumOfAllTimes += time;
        }
        let average = sumOfAllTimes / responseJSON.length;
        let averagePercentageOfBaseline = (average / baseline) * 100
        return averagePercentageOfBaseline.toFixed(2);
    }
})