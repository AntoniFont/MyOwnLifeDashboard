//Document ready jquery
let baseline = 0; //minutes

$(document).ready(function () {
    getBaseline();
    loadChart1And2();
    loadChart3And4();
    loadChart5();
    loadChart6And7();
})

function getBaseline(callback) {
    //Ajax request to get the baseline
    $.ajax("./backend/getBaseline.php", {
        method: "GET",
        data: {
            "username": username
        },
        error: function () {
            alert("Error al hacer la petición para obtener el baseline");
        },
        success: function (responseText) {
            try {
                baseline = JSON.parse(responseText);
            } catch (error) {
                alert("Error en los datos recibidos para el baseline" + responseText);
            }
        }
    }
    )
}
