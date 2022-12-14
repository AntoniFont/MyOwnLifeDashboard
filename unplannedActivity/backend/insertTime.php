<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 2)."/connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
///GET THE DATA INTO VARIABLES 
$courseID = $_GET["courseID"];
$typeOfStudyData = $_GET["typeOfStudyID"];
$projectID = $_GET["projectID"];
$totalTime = $_GET["totaltime"];
$initialTime = $_GET["initialTime"];

if ((strcmp($courseID, "-1") == 0) || (!isset($courseID))) {
    $courseID = "null";
}

if ((strcmp($typeOfStudyData, "-1") == 0) ||(!isset($typeOfStudyData))) {
    $typeOfStudyData = "null";
}

if ((strcmp($projectID, "-1") == 0) ||(!isset($projectID))) {
    $projectID = "null";
}

$query = "insert into studydata100 (courseID,typeID,projectID,initialTime,duration,comments,planned) values(".$courseID.",".$typeOfStudyData.",".$projectID.",\"".$initialTime."\",".$totalTime.",null".",0".")";
echo $query;
$projectsCon = mysqli_query($conection, $query);
mysqli_close($conection);
?>