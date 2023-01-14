let courseSelected = -1;
let typeOfStudySelected = -1;
let projectSelected = -1;

//SAVE THE COURSE SELECTED FOR LATER, LOAD THE PROJECTS LINKED TO THAT PROJECT, AND CHANGE THE DROPDOWN PLACEHOLDER
function courseClicked(event) {
    courseSelected = event.data.courseID;
    $("#selectCourseTitle").text(event.data.courseName);
    if (event.data.courseID != -1) {
        $.ajax("./backend/getProjectsFromCourse.php", {
            method: "get",
            data: {
                courseID: event.data.courseID,
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
function typeOfStudyClicked(event) {
    typeOfStudySelected = event.data.typeOfStudyID;
    $("#selectTypeOfStudyTitle").text(event.data.typeOfStudyName);
}
//SAVE THE PROJECT SELECTED FOR LATER AND CHANGE THE DROPDOWN PLACEHOLDER
function projectClicked(event) {
    projectSelected = event.data.projectID;
    $("#selectProjectTitle").text(event.data.projectName);
}


function getSelectedThings() {
    let result = {};

    let question1YesChecked = $('#question1Yes').prop('checked')
    let question1NoChecked = $('#question1No').prop('checked')

    if (question1YesChecked == question1NoChecked) { //there is an error you can't check both options at the same time or no option has been checked
        result["question1"] = "NULL";
    } else if (question1YesChecked == true) {
        result["question1"] = "yes";
    } else {
        result["question1"] = "no";
    }

    let question2Answer1Checked = $('#question2Answer1').prop('checked')
    let question2Answer2Checked = $('#question2Answer2').prop('checked')

    if (question2Answer1Checked == question2Answer2Checked) { //there is an error you can't check both options at the same time or no option has been checked
        result["question2"] = "NULL";
    } else if (question2Answer1Checked == true) {
        result["question2"] = "answer1";
    } else {
        result["question2"] = "answer2";
    }
    result["description"] = $("#description").val();
    result["courseID"] = courseSelected.toString();
    result["typeOfStudyID"] = typeOfStudySelected.toString();
    result["projectID"] = projectSelected.toString();
    return result;
}