<?php
require dirname(__DIR__, 2)."/connectToTheDatabase.php";

//CONNECT TO THE DB
$conection = connectToTheDatabase();
///GET THE DATA INTO VARIABLES 
$query = "SELECT sum(duration)/3600 as \"duracion\",courses100.name FROM `studydata100` JOIN courses100 ON studydata100.courseID = courses100.courseID JOIN user100 ON studydata100.userID = user100.id WHERE courses100.courseID is not NULL AND initialTime > (UNIX_TIMESTAMP() - (60 * 60 *24 * 7 *2)) AND nickname = \"".$_GET["name"]."\" GROUP BY studydata100.courseID";
$coursesCon = mysqli_query($conection, $query);
$resultado = mysqli_fetch_all($coursesCon);
mysqli_close($conection);
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($resultado,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>