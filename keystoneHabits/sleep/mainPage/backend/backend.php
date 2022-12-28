<?php 

/*
Lists of steps that this program should take to return the correct data

SELECT ONLY DATA FROM THE LAST 14 DAYS
FIND THE FIRST WAKING UP. STARTING THE DAY!
SEARCH THE GOING TO SLEEP MOMENT, IF IT EXISTS, IF NOT, NULL
BETWEEN THE WAKING UP AND THE GOING TO SLEEP IDENTIFY NAPS

*/

header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 4) . "/connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
//GET THE USER ID FROM THE NAME
$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$userId = mysqli_fetch_all($idCon)[0][0];
//SELECT ALL THE "FORMALLY STARTING THE DAY MOMENTS"
$query = "SELECT * FROM sleepevent100 WHERE type=9 AND UNIX_TIMESTAMP(datetime) > (UNIX_TIMESTAMP() - 14*24*60*60) AND user=" .  $userId;
$resultsCon = mysqli_query($conection, $query);
$startingTheDayMoments = mysqli_fetch_all($resultsCon);
//SELECT ALL THE "FORMALLY ENDING THE DAY MOMENTS"
$query = "SELECT * FROM sleepevent100 WHERE type=3 AND UNIX_TIMESTAMP(datetime) > (UNIX_TIMESTAMP() - 14*24*60*60) AND user=" .  $userId;
$resultsCon = mysqli_query($conection, $query);
$endingTheDayMoments = mysqli_fetch_all($resultsCon);

//nota: creo que sera necesario usar un objeto especializado porque sino será un caos https://stackoverflow.com/questions/4844223/how-do-i-json-encode-keys-from-php-array

echo json_encode(array($startingTheDayMoments,"espacio espacio espacio espacioespacio espacioespacio espacioespacio espaciovespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacioespacio espacio",$endingTheDayMoments),JSON_UNESCAPED_UNICODE);
mysqli_close($conection);




?>