<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 3)."/connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
///GET THE DATA INTO VARIABLES
$query = "select projectID,name from projects100 JOIN user100 ON projects100.userID=user100.id where projects100.courseID=\"".$_GET["courseID"]."\""."AND nickname=\"".$_GET["name"]."\"";
$projectsCon = mysqli_query($conection, $query);
$projects = mysqli_fetch_all($projectsCon);
mysqli_close($conection);
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($projects,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>