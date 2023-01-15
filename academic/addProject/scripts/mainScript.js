$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip({'delay': { show: 0, hide: 10 }})

    //RECICLING SCRIPTS XDDD
    $.ajax("../unplannedActivity/backend/getCoursesAndStudyTypes.php", {
        method: "get",
        data: {
            name: username
        },
        error: function () {
            alert("Error while making the call to the server")
        },
        success: function (responseText) {
            try {
                responseTextJSON = JSON.parse(responseText);
            } catch (error) {
                alert("ERROR: Received bad data from the server, cannot parse to json:  " + error + ": " + responseText);
            }
            
            responseTextJSON[0].forEach(element => {
                $("#selectCourse").append("<option value=\"" + element[0] + "\">" + element[1] + "</option>")
            });

        }
    })

});
