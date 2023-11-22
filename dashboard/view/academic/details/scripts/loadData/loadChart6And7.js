$(document).ready(function () {
    $.ajax("./backend/chart6And7getData.php", {
        method: "GET",
        data: {
            name: username
        },
        error: function () {
            alert("Error al hacer la petición para la gráfica 6");
        },
        success: function (responseText) {
            let responseJSON;
            let data = [];
            try {
                responseJSON = JSON.parse(responseText);
                dataTriggers = responseJSON[0];
                dataCharacteristics = responseJSON[1];
                //FILLED BOTH OPTIONS OBJECT WITH THE DATA (both objects share the same data but different configs)
                chart6Options.series[0].data = dataTriggers;
                chart7Options.series[0].data = dataTriggers;
                //CREATE THE 2 CHARTS FROM THE SHARED OPTIONS
                Highcharts.chart("chart6Container", chart6Options);
                Highcharts.chart("chart7Container", chart7Options);
            } catch (error) {
                alert("Error en los datos recibidos para la gráficas 6 \n" + error + "\nDatos: " +  responseText);
            }

        }

    })

});
