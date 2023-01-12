<?php
//0. CONSTANTS
$DAYS_DISPLAYED = 14; 
//1. IMPORTS 
require dirname(__DIR__, 3)."/connectToTheDatabase.php";
//2. CONNECT TO THE DB
$conection = connectToTheDatabase();
///3. FIRST QUERY 
//get from the username, the id, for example the username "peter" may be the id 2
$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$id = mysqli_fetch_all($idCon)[0][0];
//4. SECOND QUERY
/*The total time of the selected student studied in each course in the last 2 weeks, for example:
*  Maths - 1hours in the last 2 weeks
*  PE - 0hours in the last 2 weeks
*  Chemistry 1.5hours in the last 2 weeks
*/
$query = "";
$query .= "SELECT COALESCE(sum(duration)/3600,0) as \"duracion\",courses100.name FROM courses100 ";
$query .= "LEFT JOIN studydata100 ON (courses100.courseID = studydata100.courseID) AND studydata100.initialTime>(UNIX_TIMESTAMP()-".($DAYS_DISPLAYED * 86400).") ";
$query .= "WHERE courses100.user=".$id; 
$query .=" GROUP BY courses100.courseID";
$coursesCon = mysqli_query($conection, $query);
$resultado = mysqli_fetch_all($coursesCon);
mysqli_close($conection);
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($resultado,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>