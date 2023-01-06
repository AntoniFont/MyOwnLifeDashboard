<?php
require dirname(__DIR__, 3)."/connectToTheDatabase.php";

//CONNECT TO THE DB
$conection = connectToTheDatabase();
///GET THE DATA INTO VARIABLES 
//get from the username, the id, for example the username "peter" may be the id 2
$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$id = mysqli_fetch_all($idCon)[0][0];

//SELECT COALESCE(sum(duration),0) as "duracion",name FROM courses100 LEFT JOIN studydata100 ON (courses100.courseID = studydata100.courseID) AND studydata100.initialTime>(UNIX_TIMESTAMP()-60*60*24*7*2) WHERE courses100.user=4 GROUP BY courses100.courseID; 
//The total time of the selected student studied in each course in the last 2 weeks, for example:
//  Maths - 1hours in the last 2 weeks
//  PE - 0hours in the last 2 weeks
//  Chemistry 1.5hours in the last 2 weeks
$query = "SELECT COALESCE(sum(duration),0) as \"duracion\",courses100.name FROM courses100 LEFT JOIN studydata100 ON (courses100.courseID = studydata100.courseID) AND studydata100.initialTime>(UNIX_TIMESTAMP()-60*60*24*7*2) WHERE courses100.user=" . $id . " GROUP BY courses100.courseID";
$coursesCon = mysqli_query($conection, $query);
$resultado = mysqli_fetch_all($coursesCon);
mysqli_close($conection);
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($resultado,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>