<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$StudyDataDAO = new StudyDataDAO();
$user = (new UserDAO())->getUserFromNickname($_GET["name"]);
echo $StudyDataDAO->getCriticalSecondsStudiedByDayInTheLastNDaysJSON($user,14)
?>