<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 4) . "/connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
//DO THE QUERY
$query = "SELECT * FROM `sleepeventtype100` WHERE category=\"".$_GET["categoryName"]."\"";
$resultsCon = mysqli_query($conection, $query);
$results = mysqli_fetch_all($resultsCon);
//
echo json_encode($results,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
mysqli_close($conection);
?>  