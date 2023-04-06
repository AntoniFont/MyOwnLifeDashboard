<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
class CriteriaOneEvaluator extends DataAccesObject
{
    /*
    -- The least studied course: Time studying the least studied course  is more
    valuable than time studying the most studied course. In my experience, I tend to study 
    the most what I'm already good at and don't really need more studying,
    leaving the most difficult subjects for later (or never).
    
    If the study session was studying any of the bottom 50% of the courses, it will be given a +1 
    score. Otherwise, it will be given a 0 score.
    
    At the start of the day, the user will be given a list of the courses that they should study
    today, to keep the momentum moving once the user has started in one course, 
    the courses will not change until the next day  
    */

    function __construct()
    {
        parent::__construct();
    }
    function evaluateCriteria1($courseID, $initialTime, $userID)
    {
        $this->dbManager->openIfItWasClosed();
        $day = $this->dateStringFromUnixTimestamp($initialTime);
        $LAST_N_DAYS = 14;
        $leastStudiedCourses = (new CoursesDAO())->getBottom50PercentLeastStudiedCoursesInInterval($day, $userID, $LAST_N_DAYS);
        $this->dbManager->close();
        $score = 0;
        foreach ($leastStudiedCourses as $course) {
            if ($courseID == $course->getId()) {
                $score = 1;
                break;
            }
        }

        return $score;
    }

    private function dateStringFromUnixTimestamp($unixTimestamp)
    {
        $date = date("Y-m-d", $unixTimestamp);
        return $date;
    }
}

?>