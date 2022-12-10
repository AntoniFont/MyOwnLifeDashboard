<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require __DIR__ . "/connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
///GET THE DATA INTO VARIABLES 
$query = "select projectID,name from projects100 where courseID=\"". $_GET["courseID"]."\"";
$projectsCon = mysqli_query($conection, $query);
$projects = mysqli_fetch_all($projectsCon);
mysqli_close($conection);
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($projects,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>