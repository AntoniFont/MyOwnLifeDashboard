/*
ALL THE FUNCTIONS RELATED TO GETTING THE DATA FROM THE DATABASE TO THE WEBPAGE AND
PUTTING IT INSIDE THE RIGHT HTML ELEMENT
    -ONCE THE PAGE LOADS, GET THE COURSES ACTIVE AND PUT THEM IN THE RIGHT PLACE IN HTML
    -ONCE THE PAGE LOADS, GET THE STUDY DATA TYPES AND PUT THEM IN THE RIGHT PLACE IN HTML
    -ONCE A COURSE IS SELECTED, GET THE PROJECTS FROM THE COURSE AND PUT THEM IN THE RIGHT PLACE IN HTML
*/
$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip({'delay': { show: 0, hide: 10 }})

    $.ajax("./backend/getCoursesAndStudyTypes.php", {
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
            addCoursesAndStudyTypes(responseTextJSON);
        }
    })

    //ADD COURSES AND STUDY TYPES TO THE VIEW
    function addCoursesAndStudyTypes(data) {
        let courses = data[0];
        let typeOfStudyData = data[1];
        let stringLI = "<li></li>";
        let stringA = "<a class=\"dropdown-item\"> </a>";

        let undefinedLiCourse = $(stringLI).appendTo("#selectCourse")
        let undefinedACourse = $(stringA).appendTo(undefinedLiCourse)
        undefinedACourse.text("Undefined")
        undefinedACourse.click({ courseID: -1, courseName: "Undefined" }, courseClicked)

        let undefinedLiTypeOfStudyData = $(stringLI).appendTo("#selectTypeOfStudy")
        let undefinedATypeOfStudyData = $(stringA).appendTo(undefinedLiTypeOfStudyData)
        undefinedATypeOfStudyData.text("Undefined")
        undefinedATypeOfStudyData.click({ typeOfStudyID: -1, typeOfStudyName: "Undefined" }, typeOfStudyClicked)

        let undefinedLiProject = $(stringLI).appendTo("#selectProject")
        let undefinedAProject = $(stringA).appendTo(undefinedLiProject)
        undefinedAProject.text("Undefined")
        undefinedAProject.click({ projectID: -1, projectName: "Undefined" }, projectClicked)



        courses.forEach(element => {
            //add the name of the course to the dropdown and, 
            //when clicked, call the function to load the 
            //projects linked to that course   
            let courseNameVar = element[1]
            let courseIDVar = element[0]

            let elementAppended = $(stringLI).appendTo("#selectCourse")
            let elementAppendedToElementAppended = $(stringA).appendTo(elementAppended);
            elementAppendedToElementAppended.text(courseNameVar)
            elementAppendedToElementAppended.click({courseID: courseIDVar, courseName: courseNameVar }, courseClicked)

        });
        typeOfStudyData.forEach(element => {
            //add the name of the typeOfStudy to the dropdown and, when clicked, call the function
            let stringAConTooltip = "<a class=\"dropdown-item\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Tooltip on top\"> </a>";

            let typeOfStudyIDVar = element[0]
            let typeOfStudyNameVar = element[1]
            let descriptionOfStudyType = element[2]
            let elementAppended = $(stringLI).appendTo("#selectTypeOfStudy")
            let elementAppendedToElementAppended = $(stringAConTooltip).appendTo(elementAppended);
            elementAppendedToElementAppended.attr("title",descriptionOfStudyType)
            elementAppendedToElementAppended.text(typeOfStudyNameVar)
            elementAppendedToElementAppended.click({ typeOfStudyID: typeOfStudyIDVar, typeOfStudyName: typeOfStudyNameVar }, typeOfStudyClicked)
            
        })

    }

});

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
    result["typeOfStudyID"] = typeOfStudyID.toString();
    result["projectID"] = projectID.toString();
    return result;
}


