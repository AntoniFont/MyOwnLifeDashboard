<?php 
//1. IMPORTS
require dirname(__DIR__, 3)."/DatabaseManager.php";
//2. CONNECT TO THE DB
$dbManager = new DatabaseManager();
//3. GET THE USER ID FROM THE USERNAME
$sql = "select id from user100 where nickname=:name";
$idUser = $dbManager->query($sql, ["name" => $_GET["name"]])[0][0];
//DO THE QUERY TO GET THE TEXT
$sql = "select objectiveText from goal where user=:idUser and type=:goalType order by startDate DESC LIMIT 1";
$resultado = $dbManager->query($sql, ["idUser" => $idUser, "goalType" => $_GET["goalType"]]);
$dbManager->close();
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($resultado,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>