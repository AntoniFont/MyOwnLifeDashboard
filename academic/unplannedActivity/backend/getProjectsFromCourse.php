<?php
header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 3)."/DatabaseManager.php";
//CONNECT TO THE DB
$dbManager = new DatabaseManager();
///GET THE DATA INTO VARIABLES
$sql = "select projectID,name from projects100 JOIN user100 ON projects100.userID=user100.id where projects100.courseID=:courseID AND nickname=:name";
$projects = $dbManager->query($sql, ["courseID" => $_GET["courseID"], "name" => $_GET["name"]]);
$dbManager->close();
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($projects,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>