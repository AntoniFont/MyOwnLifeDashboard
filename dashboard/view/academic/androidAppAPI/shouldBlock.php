<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$StudyDataDAO = new StudyDataDAO();
$user = (new UserDAO())->getUserFromNickname("toni");
$today = date("Y-m-d");
$seconds = $StudyDataDAO->getCriticalSecondsStudiedOfTheDay($user,$today,14);
if($seconds>= 3600){
    echo  "no";
}else{
    echo "yes";
}
?>