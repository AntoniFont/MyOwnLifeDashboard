<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 3)."/DatabaseManager.php";
//CONNECT TO THE DB
$dbManager = new DatabaseManager();
///GET THE DATA INTO VARIABLES 
$sql = "select courseID, name from courses100 JOIN user100 ON courses100.user = user100.id where nickname=:nombre AND UNIX_TIMESTAMP(STR_TO_DATE(courses100.finalDate, \"%Y-%m-%d\")) > UNIX_TIMESTAMP() ";
$courses = $dbManager->query($sql, ["nombre" => $_GET["name"]]);
$sql = "select typeStudyDataID ,name,description from typesstudydata100 ";
$typesStudyData = $dbManager->query($sql, []);
$dbManager->close();
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode(array($courses, $typesStudyData),JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>