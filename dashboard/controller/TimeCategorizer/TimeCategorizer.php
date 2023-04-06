<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/Handler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/CoursesHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/TimeCategorizer/CriteriaOneEvaluator.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/Course.php");


class TimeCategorizer extends Handler
{
    function __construct()
    {
        parent::__construct();
    }
    /*It will categorize a study session and give it a ranking based on some criteria    
     */
    public function categorize($studyData)
    {
        $courseID = $studyData->getCourseID();
        $initialTime = $studyData->getInitialTime();
        $userID = $studyData->getUserId();
        $criteriaOneEvaluator = new CriteriaOneEvaluator();
        return $criteriaOneEvaluator->evaluateCriteria1($courseID, $initialTime, $userID);
    }

}

?>