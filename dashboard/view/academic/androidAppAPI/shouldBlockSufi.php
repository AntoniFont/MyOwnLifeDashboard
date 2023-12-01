<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$StudyDataDAO = new StudyDataDAO();
$userDao = (new UserDAO());
$user = $userDao->getUserFromNickname("sufi.mago");
$currently = $userDao->getCurrentlyStudying("sufi.mago");
$today = date("Y-m-d");
$seconds = $StudyDataDAO->getCriticalSecondsStudiedOfTheDay($user,$today,14);
if($currently == 1){
    echo "no";
}else{
    $currentHour = date('G');
    if($currentHour < 16){
        echo "no";
    }else{
        if($seconds>= 3600){
            echo "no";
        }else{
            echo "yes";
        }
    }
}
?>