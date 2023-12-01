<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$StudyDataDAO = new StudyDataDAO();
$userDao = (new UserDAO());
$user = $userDao->getUserFromNickname("toni");
$currently = $userDao->getCurrentlyStudying("toni");
$today = date("Y-m-d");
$seconds = $StudyDataDAO->getCriticalSecondsStudiedOfTheDay($user,$today,14);
$dbManager = new DatabaseManager();
$travellingExceptionOn = $dbManager->query("SELECT id FROM `user100` WHERE user100.travellingExceptionExpiration > now() and user100.id = 1",$values);
if($seconds>= 3600 or $currently == 1 or empty($travellingExceptionOn)){
    echo "no";
}else{
    echo "yes";
}
?>