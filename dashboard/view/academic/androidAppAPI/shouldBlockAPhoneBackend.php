<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/view/academic/androidAppAPI/studyCriteria.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

function didUserStudyEnoughToday($nickname,$studyCriteria){
    /*GET THE CURRENT MOMENT IN ALL THE WAYS WE NEED */
    $currentDay = date("Y-m-d");
    $currentWeekDay = date('w');
    $currentMinute = date('G') * 60 + date('i');
    /*FIRST CHECK IF TODAY IS A EXCEPTION DAY , IF IT'S TRUE, LEAVE*/
    if($currentDay == $studyCriteria->getExceptionDay()){
        return true;
    }
    /*GET THE STUDY DATA BETWEEN 00:00 AND THE CUTOFF TIME */
    $StudyDataDAO = new StudyDataDAO();
    $userDao = (new UserDAO());
    $user = $userDao->getUserFromNickname($nickname);
    $todayAt00 = date('Y-m-d 00:00:00');
    $todayAtCutoff = date('Y-m-d '.$studyCriteria->getFormattedCotoutMinuteString());
    $todayAt00Unix = strtotime($todayAt00);
    $todayAtCutoffUnix = strtotime($todayAtCutoff);
    $studyDatas = $StudyDataDAO->getStudyDataBetweenTwoDatetimes($user, $todayAt00Unix, $todayAtCutoffUnix);
    /*CALCULATE THE SECONDS STUDIED (THIS COULD BE DONE BY A SELECT BUT ANYWAY) */
    $secondsStudied = 0;
    for ($i = 0; $i < count($studyDatas); $i++) {
        $secondsStudied += $studyDatas[$i]->getDuration();
    }
    if ($currentMinute < $studyCriteria->getCotoutMinute()) {
        return true;
    } else {
        if ($secondsStudied >= $studyCriteria->getStudyBaselineByDays()[$currentWeekDay] * 60) {
            return true;
        } else {
            return false;
        }
    }
}




?>