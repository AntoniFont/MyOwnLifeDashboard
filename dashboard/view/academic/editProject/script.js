$(document).ready(function() {
    getSelectedCourseProjects();
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
                getProjectData(); 
            }
        });
    }
    function getProjectData(){
        let params = new URLSearchParams(document.location.search);
        let name = params.get("name");
        let projectID = $("#selectProject option:selected").val();
        if(projectID == null){ //if no project is selected
            //get the first projectID
            projectID = $("#selectProject option:first").val();
        }
        $.ajax("./projectData.php",{
            type: "GET",
            data: {
                username: name,    
                projectID: projectID,
            },
            success: function(html) {
                $("#selectProjectDataDiv").html(html);
            }
        });
    }
});