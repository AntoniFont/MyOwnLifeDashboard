<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/TimeCategorizer/CriteriaOneEvaluator.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/Course.php");


class TimeCategorizer extends DataAccessObject
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
        $score = $criteriaOneEvaluator->evaluateCriteria1($courseID, $initialTime, $userID);
        (new StudyDataDAO())->updateStudyDataRanking($studyData->getId(), $score);
        return $score;
    }

}

?>