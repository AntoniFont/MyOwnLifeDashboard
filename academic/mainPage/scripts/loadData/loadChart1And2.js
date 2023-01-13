$(document).ready(function () {
    $.ajax("./backend/chart1And2getData.php", {
        method: "GET",
        data: {
            name: username
        },
        error: function () {
            alert("Error al hacer la petición para las gráficas 1 y 2");
        },
        success: function (responseText) {
            let responseJSON;
            let data = [];
            try {
                responseJSON = JSON.parse(responseText);
                data = formatDataChart1And2(data, responseJSON);
                //FILLED BOTH OPTIONS OBJECT WITH THE DATA (both objects share the same data but different configs)
                chart1Options.series[0].data = data;
                chart2Options.series[0].data = data;
                //CREATE THE 2 CHARTS FROM THE SHARED OPTIONS
                Highcharts.chart("chart1Container", chart1Options);
                Highcharts.chart("chart2Container", chart2Options);
            } catch (error) {
                alert("Error en los datos recibidos para las gráficas 1 y 2" + responseText);
            }

        }

    })

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

});
