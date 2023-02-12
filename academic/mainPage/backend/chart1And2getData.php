<?php
//0. CONSTANTS
$DAYS_DISPLAYED = 14; 
//1. IMPORTS 
require dirname(__DIR__, 3)."/DatabaseManager.php";
//2. CONNECT TO THE DB
$dbManager = new DatabaseManager();
///3. FIRST QUERY 
//get from the username, the id, for example the username "peter" may be the id 2
$sql = "select id from user100 where nickname=:nombre";
$id = $dbManager->query($sql, ["nombre" => $_GET["name"]])[0][0];
//4. SECOND QUERY
/*The total time of the selected student studied in each course in the last 2 weeks, for example:
*  Maths - 1hours in the last 2 weeks
*  PE - 0hours in the last 2 weeks
*  Chemistry 1.5hours in the last 2 weeks
*/
$query = "";
$query .= "SELECT COALESCE(sum(duration)/3600,0) as \"duracion\",courses100.name,courses100.courseID,is6thCourse,is7thCourse FROM courses100 ";
$query .= "LEFT JOIN studydata100 ON (courses100.courseID = studydata100.courseID) ";
$query .= "AND studydata100.initialTime>(UNIX_TIMESTAMP()- :days_displayed) ";
$query .= "WHERE courses100.user= :id";
$query .= " AND UNIX_TIMESTAMP(STR_TO_DATE(courses100.finalDate, \"%Y-%m-%d\")) > UNIX_TIMESTAMP()";
$query .=" GROUP BY courses100.courseID";
$resultByCourses = $dbManager->query($query, ["days_displayed" => $DAYS_DISPLAYED * 86400, "id" => $id]);

//5. Search for the 6th and 7th course
$exists6thCourse = false;
$exists7thCourse = false;
foreach ($resultByCourses as $key => $value) {
    if ($value[3] == 1) {
        $exists6thCourse = true;
    }
    if ($value[4] == 1) {
        $exists7thCourse = true;
    }
}


//6. FOR EACH COURSE, GET THE TOTAL TIME BY COURSE
$resultsByProjects = array();
foreach ($resultByCourses as $key => $value) {
    //6.1. GET THE TOTAL TIME BY PROJECT
    $query = "";
    $query .= "SELECT COALESCE(sum(duration)/3600,0) as \"duracion\",projects100.name FROM projects100 ";
    $query .= "LEFT JOIN studydata100 ON (projects100.projectID = studydata100.projectID) AND studydata100.initialTime>(UNIX_TIMESTAMP()- :days_displayed) ";
    $query .= "WHERE projects100.userID= :id";
    $query .= " AND projects100.courseID= :courseID";
    $query .= " GROUP BY projects100.projectID ORDER BY \"duracion\" DESC";
    $resultsByProject = $dbManager->query($query, ["days_displayed" =>$DAYS_DISPLAYED * 86400, "id" => $id, "courseID" => $value[2]]);
    $resultsByProjects[$key] = $resultsByProject;
}
//7. FORMAT BOTH ARRAYS FOR THE HIGHCHARTS LIBRARY THAT WILL DISPLAY THEM
$resultsByCoursesFinal = array();
$resultsByProjectsFinal = array();
foreach ($resultByCourses as $keyCourse => $valueCourse) {
    $resultsByCoursesFinal[$keyCourse] = array(
        "name" => $valueCourse[1],
        "y" => floatval($valueCourse[0]),
        "drilldown" => $valueCourse[1]
    );
    
    $dataTempProjects = array();
    foreach ($resultsByProjects[$keyCourse ] as $keyProject => $valueProject) {
        $dataTempProjects[$keyProject] = array($valueProject[1],floatval($valueProject[0]));
    }
    $tempProjects = array(
        "name" => $valueCourse[1],
        "id" => $valueCourse[1],
        "data" =>  $dataTempProjects
    );

    array_push($resultsByProjectsFinal,$tempProjects);
}

//8. CLOSE THE CONNECTION
$dbManager->close();
//CONVERT INTO JSON OBJECT AND RETURN IT
$finalResult = array(
    "timeByCourses" => $resultsByCoursesFinal,
    "timeByProjects" => $resultsByProjectsFinal,
    "exists6thCourse" => $exists6thCourse,
    "exists7thCourse" => $exists7thCourse
);
echo json_encode($finalResult,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>