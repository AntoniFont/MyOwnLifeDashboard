$(document).ready(function() {
    getSelectedCourseProjects();
    //I'm too lazy to search which event is actually fired when the user changes the value of the input field
    $("#duration").change(updateHoursAndMinutes);
    $("#duration").keyup(updateHoursAndMinutes);
    $("#selectCourse").change(getSelectedCourseProjects);
    $("#selectProject").change(getProjectData);
    function getSelectedCourseProjects() {
        let params = new URLSearchParams(document.location.search);
        let name = params.get("name");
        $.ajax("./projectsDropdown.php",{
            type: "GET",
            data: {
                username: name,    
                courseID: $("#selectCourse option:selected").val(),
            },
            success: function(html) {
                $("#selectProject").html(html);
            }
        });
    }
    function updateHoursAndMinutes() {
        let totalSeconds = $("#duration").val();
        totalSeconds = parseInt(totalSeconds);
        let hours,minutes,seconds;
        //if less than 0 or a string is entered
        if(totalSeconds<0) {
            hours = "invalid";
            minutes = "invalid";
            seconds = "invalid";
        }else{
            hours = Math.floor(totalSeconds / 3600);
            minutes = Math.floor((totalSeconds % 3600) / 60);
            seconds = totalSeconds % 60;
        }
        $("#hours").text(hours);
        $("#minutes").text(minutes);
        $("#seconds").text(seconds);
    }
});