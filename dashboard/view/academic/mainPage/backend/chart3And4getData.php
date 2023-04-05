<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/StudyDataHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/UserHandler.php");

$studyDataHandler = new StudyDataHandler();
$user = (new UserHandler())->getUserFromNickname($_GET["name"]);
echo $studyDataHandler->getSecondsStudiedByDayInTheLastNDaysJSON($user,14)

?>