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

$descripcion = mysqli_real_escape_string($conection,$_GET["description"]);

$workingAlone = $_GET["workingAlone"];
$beingAlone = $_GET["beingAlone"];
if ($workingAlone == "false") { 
    $beingAlone = "false";
}

$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$id = mysqli_fetch_all($idCon)[0][0];

$query = "insert into studydata100 (courseID,typeID,projectID,initialTime,duration,descripción,planned,userID,workingAlone,beingAlone) values(".$courseID.",".$typeOfStudyData.",".$projectID.",\"".$initialTime."\",".$totalTime.",\"".$descripcion."\",0".",\"".$id."\"".",".$workingAlone.",".$beingAlone.")";
echo $query;
$projectsCon = mysqli_query($conection, $query);
mysqli_close($conection);
?>