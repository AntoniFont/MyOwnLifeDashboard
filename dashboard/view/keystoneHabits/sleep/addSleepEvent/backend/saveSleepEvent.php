<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 4)."/connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
//DO THE QUERY
$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$id = mysqli_fetch_all($idCon)[0][0];

$query = "insert into sleepevent100 (datetime,type,user) values (\"" . date("Y-m-d H:i:s")."\"," .$_GET["id"]. "," .$id. ")";
echo $query;
$var = mysqli_query($conection, $query);

mysqli_close($conection);
?>