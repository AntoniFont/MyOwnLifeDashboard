let courseSelected = -1;
let triggerSelected = -1;
let projectSelected = -1;

//SAVE THE COURSE SELECTED FOR LATER, LOAD THE PROJECTS LINKED TO THAT PROJECT, AND CHANGE THE DROPDOWN PLACEHOLDER
function courseClicked(data) {
    courseSelected = data.courseID;
    $("#selectCourseTitle").text(data.courseName);
    if (data.courseID != -1) {
        $.ajax("./backend/getProjectsFromCourse.php", {
            method: "get",
            data: {
                courseID: data.courseID,
                name: username
            },
            success: function (responseText) {
                //ADD PROJECTS TO WEBPAGE
                try {
                    projectsFromSelectedCourse = JSON.parse(responseText);
                } catch (error) {
                    alert("Recieved bad data from server when getting projects from selected course: " + responseText)
                }
                $("#selectProject").html(""); //Empty what was in here before
                let stringLI = "<li></li>";
                let stringA = "<a class=\"dropdown-item\"> </a>";
                let undefinedLiProject = $(stringLI).appendTo("#selectProject")
                let undefinedAProject = $(stringA).appendTo(undefinedLiProject)
                undefinedAProject.text("Undefined")
                undefinedAProject.click({ projectID: -1, projectName: "Undefined" }, projectClicked)

                projectsFromSelectedCourse.forEach(element => {
                    let projectIDVar = element[0]
                    let projectNameVar = element[1]
                    let elementAppended = $(stringLI).appendTo("#selectProject")
                    let elementAppendedToElementAppended = $(stringA).appendTo(elementAppended);
                    elementAppendedToElementAppended.text(projectNameVar)
                    elementAppendedToElementAppended.click({ projectID: projectIDVar, projectName: projectNameVar }, projectClicked)
                });
            }
        })
    }
    
}
//SAVE THE TYPE OF STUDY SELECTED FOR LATER AND CHANGE THE DROPDOWN PLACEHOLDER
function triggerClicked(data) {
    triggerSelected = data.triggerID;
    $("#selectTriggerTitle").text(data.triggerName);
    $("#triggerDescription").text(data.triggerDescription);
}
//SAVE THE PROJECT SELECTED FOR LATER AND CHANGE THE DROPDOWN PLACEHOLDER
function projectClicked(event) {
    projectSelected = event.data.projectID;
    $("#selectProjectTitle").text(event.data.projectName);
}


function getSelectedThings() {
    let result = {};
    result["description"] = $("#description").val();
    result["courseID"] = courseSelected.toString();
    result["triggerID"] = triggerSelected.toString();
    result["projectID"] = projectSelected.toString();
    return result;
}
