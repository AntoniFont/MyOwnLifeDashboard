<?php
session_start();
if (!isset($_SESSION["loggedIn"])) {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/myownlifedashboard" . "/dashboard/view/login/login.php");
}
?>