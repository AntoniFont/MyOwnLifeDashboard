<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 2)."/connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
///GET THE DATA INTO VARIABLES 
$query = "select courseID,name from courses100";
$coursesCon = mysqli_query($conection, $query);
$courses = mysqli_fetch_all($coursesCon);
$query = "select typeStudyDataID ,name from typesstudydata100 ";
$typesStudyDataCon = mysqli_query($conection, $query);
$typesStudyData = mysqli_fetch_all($typesStudyDataCon);
mysqli_close($conection);
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode(array($courses, $typesStudyData),JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages

?>