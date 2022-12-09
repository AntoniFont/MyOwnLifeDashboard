<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require __DIR__ . "./connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
///GET THE DATA INTO VARIABLES 
$courseID = $_GET["courseID"];
$typeOfStudyData = $_GET["typeOfStudyID"];
$projectID = $_GET["projectID"];
$totalTime = $_GET["totaltime"];
$initialTime = $_GET["initialTime"];

if (strcmp($courseID, "-1") == 0) {
    $courseID = "null";
}

if (strcmp($typeOfStudyData, "-1") == 0) {
    $typeOfStudyData = "null";
}

if (strcmp($projectID, "-1") == 0) {
    $projectID = "null";
}

$query = "insert into studydata100 (courseID,typeID,projectID,initialTime,duration,comments,planned) values(".$courseID.",".$typeOfStudyData.",".$projectID.",\"".$initialTime."\",".$totalTime.",null".",0".")";
$projectsCon = mysqli_query($conection, $query);
mysqli_close($conection);
?>