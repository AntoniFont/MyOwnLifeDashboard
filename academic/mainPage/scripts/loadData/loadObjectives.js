
$(document).ready(function () {

    $.ajax("./backend/getObjective.php",{
        method : "GET",
        data : {
            "name": username,
            "goalType": 1
        },
        error: function (){
            alert("Error al hacer la petición de los objetivos");
        },
        success : function(responseText){
            try{
                let resp = JSON.parse(responseText)[0];
                $("#balanceObjective").html(resp);
            }catch(error){
                alert("Error al cargar los objetivos" + responseText);
            }
        }
    })
    

});