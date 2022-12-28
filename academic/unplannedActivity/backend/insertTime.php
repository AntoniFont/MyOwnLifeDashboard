<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 3)."/connectToTheDatabase.php";
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
//HANDLING OF THE QUESTIONS

/*in the frontend the questions should be:
    1. Where your friends in the same room (or online room) and you where able to comunicate? : YES/NO
    2. ¿What were your friends doing?
        Answer1: Each one working on their own thing or on their part of the project, with the posibility of asking for help or comenting aloud.
        Answer2: We were working on the same task

    So the logic goes as follows:
    If question1: no -->  beingAlone = True, workingAlone = True
    If question1: yes and question2: answer1 --> beingAlone = False, workingAlone = True 
    If question1: yes and question2: answer2 --> beingAlone = False, workingAlone = False

    Then we must handle the question1: NULL and/or question2: NULL apropiately.
*/

$question1 = $_GET["question1"];
$question2 = $_GET["question2"];

$workingAlone = "null";
$beingAlone = "null";

if (strcmp($question1, "no") == 0) { //if question1 == no
    $beingAlone = "true";
    $workingAlone = "true";
} else if (strcmp($question1,"yes") == 0){ //if question1 == yes
    $beingAlone = "false";
    if (strcmp($question2, "answer1") == 0) {
        $workingAlone = "true";
    } else if (strcmp($question2, "answer2") == 0) {
        $workingAlone = "false";
    }
} 


//GET THE USER ID FROM THE NAME
$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$id = mysqli_fetch_all($idCon)[0][0];
//DO THE QUERY

$query = "insert into studydata100 (courseID,typeID,projectID,initialTime,duration,descripción,planned,userID,workingAlone,beingAlone) values(".$courseID.",".$typeOfStudyData.",".$projectID.",\"".$initialTime."\",".$totalTime.",\"".$descripcion."\",0".",\"".$id."\"".",".$workingAlone.",".$beingAlone.")";
echo $query;
$projectsCon = mysqli_query($conection, $query);
mysqli_close($conection);
?>