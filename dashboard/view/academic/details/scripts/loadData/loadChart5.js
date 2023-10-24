$(document).ready(function () {
    $.ajax("./backend/chart5getData.php", {
        method: "GET",
        data: {
            name: username
        },
        error: function () {
            alert("Error al hacer la petición para las gráficas 5");
        },
        success: function (responseText) {
            let responseJSON;
            let data = [];
            try {
                responseJSON = JSON.parse(responseText);
                minimoDiario = (responseJSON/baseline)*100
                if(minimoDiario > 100){
                    minimoDiario = 100
                    fuegosArtificiales();
                    $("#emojisCelebracion").attr("hidden",false);
                }
                minimoDiario = Math.round(minimoDiario);

                chart5Options.series[0].data = [minimoDiario];
                Highcharts.chart("chart5container", chart5Options);
            } catch (error) {
                alert("Error en los datos recibidos para las gráficas 5 \n" + error + "\nDatos: " +  responseText);
            }

        }


    })

    function fuegosArtificiales(){
        let durationSeconds = 15;
        var end = Date.now() + (durationSeconds * 1000);
                (function frame() {
                confetti({
                    particleCount: 5,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 },
                });
                confetti({
                    particleCount: 5,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 },
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
                }());
    }
});