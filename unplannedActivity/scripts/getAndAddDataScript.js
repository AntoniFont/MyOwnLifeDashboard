/*
ALL THE FUNCTIONS RELATED TO GETTING THE DATA FROM THE DATABASE TO THE WEBPAGE AND
PUTTING IT INSIDE THE RIGHT HTML ELEMENT
    -ONCE THE PAGE LOADS, GET THE COURSES ACTIVE AND PUT THEM IN THE RIGHT PLACE IN HTML
    -ONCE THE PAGE LOADS, GET THE STUDY DATA TYPES AND PUT THEM IN THE RIGHT PLACE IN HTML
    -ONCE A COURSE IS SELECTED, GET THE PROJECTS FROM THE COURSE AND PUT THEM IN THE RIGHT PLACE IN HTML
*/
let courses;
let typeOfStudyData;
let projectsFromSelectedCourse;

let courseID = -1;
let typeOfStudyID = -1;
let projectID = -1;


$(document).ready(function () {

    //GET COURSES AND STUDY TYPES FROM THE DATABASE
    let params = new URLSearchParams(document.location.search);
    let name = params.get("name"); 
    let xmlhttpGetOptions = new XMLHttpRequest();
    xmlhttpGetOptions.onreadystatechange = function () { //Callback function
        if (this.readyState == 4) { //IF it has ended
            addCoursesAndStudyTypes(JSON.parse(this.responseText));
        }
    }
    xmlhttpGetOptions.open("GET", "./backend/getCoursesAndStudyTypes.php?name="+name, true);
    xmlhttpGetOptions.send();

    //ADD COURSES AND STUDY TYPES TO WEBPAGE
    function addCoursesAndStudyTypes(data) {
        courses = data[0];
        typeOfStudyData = data[1];
        courses.forEach(element => {
            //add the name of the course to the dropdown and, when clicked, call the function to load the projects linked to that
            //course
            string = "<li><a class=\"dropdown-item\" onclick=\"courseClicked(" + element[0] + ")\">" + element[1] + "</a></li>";
            $("#selectCourse").append(string);
        });
        typeOfStudyData.forEach(element => {
            //add the name of the typeOfStudy to the dropdown and, when clicked, call the function
            string = "<li><a class=\"dropdown-item\" onclick=\"typeOfStudyClicked(" + element[0] + ")\">" + element[1] + "</a></li>";
            $("#selectTypeOfStudy").append(string);
        })

    }
    //window.open("https://localhost/phpmyadmin/sql.php?db=myowndashboard&table=studydata100&pos=0", '_blank').focus();
    
});




//SAVE THE COURSE SELECTED FOR LATER, LOAD THE PROJECTS LINKED TO THAT PROJECT, AND CHANGE THE DROPDOWN PLACEHOLDER
function courseClicked(courseIDparam) {
    courseID = courseIDparam;
    let params = new URLSearchParams(document.location.search);
    let name = params.get("name"); 
    if (courseIDparam == -1) {
        $("#selectCourseTitle").text("Undefined");
    } else {
        index = getArrayIndexFromID(courses, courseIDparam);
        $("#selectCourseTitle").text(courses[index][1]);
        let xmlhttpGetOptions = new XMLHttpRequest();
        xmlhttpGetOptions.onreadystatechange = function () { //Callback function
            if (this.readyState == 4) { //IF it has ended
                //ADD PROJECTS TO WEBPAGE
                projectsFromSelectedCourse = JSON.parse(this.responseText);
                $("selectProject").html("<li><a class=\"dropdown-item\" onclick=\"projectClicked(-1)\">Undefined</a></li>");
                projectsFromSelectedCourse.forEach(element => {
                    //add the name of the course to the dropdown and, when clicked, call the function to load the projects linked to that
                    //course
                    string = "<li><a class=\"dropdown-item\" onclick=\"projectClicked(" + element[0] + ")\">" + element[1] + "</a></li>";
                    $("#selectProject").append(string);
                });
            }
        }

        xmlhttpGetOptions.open("GET", "./backend/getProjectsFromCourse.php" + "?courseID=" + courseIDparam + "&name=" + name, true);
        xmlhttpGetOptions.send();
    }
}
//SAVE THE TYPE OF STUDY SELECTED FOR LATER AND CHANGE THE DROPDOWN PLACEHOLDER
function typeOfStudyClicked(typeOfStudyIDparam) {
    typeOfStudyID = typeOfStudyIDparam;
    if (typeOfStudyIDparam == -1) {
        $("#selectTypeOfStudyTitle").text("Undefined");
    } else {
        index = getArrayIndexFromID(typeOfStudyData, typeOfStudyIDparam);
        $("#selectTypeOfStudyTitle").text(typeOfStudyData[index][1]);
    }
}
//SAVE THE PROJECT SELECTED FOR LATER AND CHANGE THE DROPDOWN PLACEHOLDER
function projectClicked(projectIDparam) {
    projectID = projectIDparam;
    if (projectIDparam == -1) {
        $("#selectProjectTitle").text("Undefined");
    } else {
        index = getArrayIndexFromID(projectsFromSelectedCourse, projectIDparam);
        $("#selectProjectTitle").text(projectsFromSelectedCourse[index][1]);
    }
}

function getSelectedThings() {
    let result = {};
    result["courseID"] = courseID.toString();
    result["typeOfStudyID"] = typeOfStudyID.toString();
    result["projectID"]= projectID.toString();
    console.log("courseid" + courseID);
    return result;
}


/*
Usually the array index is id-1 , but just in case i will search it.
This function searchs the index from and id. For example, i'm trying to get 
the index from the id number 3, this is the data:
index: ["id","name"]
0: ["2","nameA"]
1: ["1","nameB"]
2: ["3","nameC"]
3: ["0","nameD"]
in this case the index of id=3 is 2.
 
I could fix this with a dict but that's too much work
*/
function getArrayIndexFromID(array, id) {
    found = false;
    index = 0;
    while (!found) {
        if (array[index][0] == id) {
            found = true;
        } else {
            index++;
        }
    }
    return index;
}

