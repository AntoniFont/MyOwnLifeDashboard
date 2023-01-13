<?php 
//1. IMPORTS
require dirname(__DIR__, 3)."/connectToTheDatabase.php";
//2. CONNECT TO THE DB
$conection = connectToTheDatabase();
//3. GET THE USER ID FROM THE USERNAME
$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$idUser = mysqli_fetch_all($idCon)[0][0];
//DO THE QUERY TO GET THE TEXT
$query = "select objectiveText from goal where user=" . $idUser ." and type=" .$_GET["goalType"].  " order by startDate DESC LIMIT 1";
$dataCon = mysqli_query($conection, $query);
$resultado = mysqli_fetch_all($dataCon);
mysqli_close($conection);
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($resultado,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>