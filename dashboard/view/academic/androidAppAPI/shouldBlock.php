<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$StudyDataDAO = new StudyDataDAO();
$userDao = (new UserDAO());
$user = $userDao->getUserFromNickname("toni");
$currently = $userDao->getCurrentlyStudying("toni");
$today = date("Y-m-d");
$secondsStudied = $StudyDataDAO->getCriticalSecondsStudiedOfTheDay($user,$today,14);
$dbManager = new DatabaseManager();
$values = array();
$travellingExceptionOn = $dbManager->query("SELECT id FROM `user100` WHERE user100.travellingExceptionExpiration > now() and user100.id = 1",$values);
$hora = date("H");
$minuto = date("i");
$horaNum = $hora + ($minuto / 60);
if(($horaNum < 9 and $secondsStudied>= 3600) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 10.5 and $secondsStudied>= (3600 * 0.9)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 12 and $secondsStudied>= (3600 * 0.8)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 13.5 and $secondsStudied>= (3600 * 0.7)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 15 and $secondsStudied>= (3600 * 0.6)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 16.5 and $secondsStudied>= (3600 * 0.5)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 18 and $secondsStudied>= (3600 * 0.4)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 19.5 and $secondsStudied>= (3600 * 0.3)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 21 and $secondsStudied>= (3600 * 0.2)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 22.5 and $secondsStudied>= (3600 * 0.1)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else if(($horaNum < 24 and $secondsStudied>= (3600 * 0.05)) or $currently == 1 or !empty($travellingExceptionOn)){
    echo "no";
}else{
    echo "yes";
}
?>