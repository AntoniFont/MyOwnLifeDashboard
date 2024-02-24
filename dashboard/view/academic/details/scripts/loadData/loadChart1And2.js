function loadChart1And2() {
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
                dataCourses = responseJSON["timeByCourses"];
                dataProjects = responseJSON["timeByProjects"];
                exists6thCourse = responseJSON["exists6thCourse"];
                exists7thCourse = responseJSON["exists7thCourse"];
                //UPDATE WARNINGS
                updateWarnings(exists6thCourse,exists7thCourse);
                //FILLED BOTH OPTIONS OBJECT WITH THE DATA (both objects share the same data but different configs)
                chart1Options.series[0].data = dataCourses;
                chart1Options.drilldown.series = dataProjects;
                chart2Options.series[0].data = dataCourses;
                chart2Options.drilldown.series = dataProjects;
                //CREATE THE 2 CHARTS FROM THE SHARED OPTIONS
                Highcharts.chart("chart1Container", chart1Options);
                Highcharts.chart("chart2Container", chart2Options);
            } catch (error) {
                alert("Error en los datos recibidos para las gráficas 1 y 2 \n" + error + "\nDatos: " +  responseText);
            }

        }

    })

}
