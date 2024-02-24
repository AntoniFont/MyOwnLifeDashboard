<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$StudyDataDAO = new StudyDataDAO();
$userDao = (new UserDAO());
$user = $userDao->getUserFromNickname("toni");
$currently = $userDao->getCurrentlyStudying("toni");
$todayAt00 = date('Y-m-d 00:00:00');
$todayAt11 = date('Y-m-d 11:00:00');
$todayAt00Unix = strtotime($todayAt00);
$todayAt11Unix = strtotime($todayAt11);
$studyDatas = $StudyDataDAO->getStudyDataBetweenTwoDatetimes($user,$todayAt00Unix,$todayAt11Unix);
$secondsStudied = 0;
for ($i = 0; $i < count($studyDatas); $i++) {
    $secondsStudied += $studyDatas[$i]->getDuration();
}
if(strcmp($todayAt00,"2024-02-23 00:00:00") == 0){
echo "no"; return;
}
if($currently == 1){
    echo "no";
}else{
    $currentHour = date('G');
    if($currentHour < 11){
        echo "no";
    }else{
        if($secondsStudied>= 4200){
            echo "no";
        }else{
            echo "yes";
        }
    }
}
?>