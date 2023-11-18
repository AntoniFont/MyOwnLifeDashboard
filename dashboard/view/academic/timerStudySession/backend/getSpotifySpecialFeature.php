<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");
$userDAO = new $UserDAO();
$user = $userDAO->getUserFromNickname($_GET["username"]);

if($_SESSION["username"] == $_GET["username"] and $user->isSpotifyFeatureEnabled()){
    $dbManager = new DatabaseManager();
    $dbManager->useSpecialCredentials();
    $sql = "SELECT password FROM user_spotifyPassword WHERE userID=:userID";
    $result = $dbManager->query($sql,["userID" => $user->getId()]);
    echo json_encode(array("true",$result[0][0]));
}else{
    echo json_encode(array("false",""));
}

?>