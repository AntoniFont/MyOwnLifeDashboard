<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$StudyDataDAO = new StudyDataDAO();
$user = (new UserDAO())->getUserFromNickname($_GET["name"]);
$today = date("Y-m-d");
$yesterday = date("Y-m-d", strtotime("-1 day"));
$studyData = $StudyDataDAO->getCriticalSecondsStudiedOfTheDay($user,$today,14);
echo $studyData;
?>