<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");
session_start();
$usuariDAO = new UserDAO();
$user = $usuariDAO->getUserFromNickname($_POST["username"]);
if (password_verify($_POST["key"],$user->getPasswordHash())){
    $_SESSION["loggedIn"] = true;
    $_SESSION["username"] = $_POST["username"];
    echo "<p>Correcto! </p>";
    echo "<a href=\"../index.php?name=".$_POST["username"]."\"><p>Volver a la página principal</p></a>";
}else{
    echo "<p>Incorrecto! </p>";
    echo "<a href=\"./login.php\"><p>Volver a intentar</p></a>";
}
?>
