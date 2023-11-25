<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
$userDAO = new UserDAO();
$userDAO->setCurrentlyStudying($_GET["name"],$_GET["value"]);
?>