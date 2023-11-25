<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$StudyDataDAO = new StudyDataDAO();
$userDao = (new UserDAO());
$user = $userDao->getUserFromNickname("toni");
$currently = $userDao->getCurrentlyStudying("toni");
$today = date("Y-m-d");
$seconds = $StudyDataDAO->getCriticalSecondsStudiedOfTheDay($user,$today,14);
if($seconds>= 3600 or $currently == 1){
    echo  "no";
}else{
    echo "yes";
}
?>