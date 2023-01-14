<?php
//0. CONSTANTS
$DAYS_DISPLAYED = 14; 
//1. IMPORTS 
require dirname(__DIR__, 3)."/connectToTheDatabase.php";
//2. CONNECT TO THE DB
$conection = connectToTheDatabase();
///3. FIRST QUERY 
//get from the username, the id, for example the username "peter" may be the id 2
$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$id = mysqli_fetch_all($idCon)[0][0];
//4. SECOND QUERY
/*The total time of the selected student studied in each course in the last 2 weeks, for example:
*  Maths - 1hours in the last 2 weeks
*  PE - 0hours in the last 2 weeks
*  Chemistry 1.5hours in the last 2 weeks
*/
$query = "";
$query .= "SELECT COALESCE(sum(duration)/3600,0) as \"duracion\",courses100.name,courses100.courseID FROM courses100 ";
$query .= "LEFT JOIN studydata100 ON (courses100.courseID = studydata100.courseID) AND studydata100.initialTime>(UNIX_TIMESTAMP()-".($DAYS_DISPLAYED * 86400).") ";
$query .= "WHERE courses100.user=".$id;
$query .= " AND UNIX_TIMESTAMP(STR_TO_DATE(courses100.finalDate, \"%Y-%m-%d\")) > UNIX_TIMESTAMP()";
$query .=" GROUP BY courses100.courseID";
$coursesCon = mysqli_query($conection, $query);
$resultByCourses = mysqli_fetch_all($coursesCon);
//6. FOR EACH COURSE, GET THE TOTAL TIME BY COURSE
$resultsByProjects = array();
foreach ($resultByCourses as $key => $value) {
    $query = "";
    $query .= "SELECT COALESCE(sum(duration)/3600,0) as \"duracion\",projects100.name FROM projects100 ";
    $query .= "LEFT JOIN studydata100 ON (projects100.projectID = studydata100.projectID) AND studydata100.initialTime>(UNIX_TIMESTAMP()-".($DAYS_DISPLAYED * 86400).") ";
    $query .= "WHERE projects100.userID=".$id;
    $query .= " AND projects100.courseID=".$value[2];
    $query .= " GROUP BY projects100.projectID ORDER BY \"duracion\" DESC";
    $projectsCon = mysqli_query($conection, $query);
    $resultByProject = mysqli_fetch_all($projectsCon);
    $resultsByProjects[$key] = $resultByProject;
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

mysqli_close($conection);


//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode(array($resultsByCoursesFinal,$resultsByProjectsFinal),JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>