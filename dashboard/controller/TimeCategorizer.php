<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/Handler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/CoursesHandler.php");
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
        return $this->evaluateCriteria1($courseID, $initialTime, $userID);
    }

    /*
    -- The least studied course: Time studying the least studied course  is more
    valuable than time studying the most studied course. In my experience, I tend to study 
    the most what I'm already good at and don't really need more studying,
    leaving the most difficult subjects for later (or never).
    
    If the study session was studying any of the bottom 50% of the courses, it will be given a +1 
    score. Otherwise, it will be given a 0 score.
    
    At the start of the day, the user will be given a list of the courses that they should study
    today, to keep the momentum moving once the user has started in one course, 
    the courses will not change until the next day.
    
    */
    function dateStringFromUnixTimestamp($unixTimestamp)
    {
        $date = date("Y-m-d", $unixTimestamp);
        return $date;
    }

    function evaluateCriteria1($courseID, $initialTime, $userID)
    {
        $this->dbManager->openIfItWasClosed();
        $day = $this->dateStringFromUnixTimestamp($initialTime);
        $LAST_N_DAYS = 14;
        $leastStudiedCourses = $this->getCurrentLeastStudiedCourses($day, $userID, $LAST_N_DAYS);
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


    /* 
    Get the bottom 50% of the courses that the user has studied the least in the last N days
    */
    function getCurrentLeastStudiedCourses($day, $userID, $LAST_N_DAYS)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "select
                    courses100.courseID,
                    courses100.name,
                    # null duration in this case means 0 seconds
                    ifnull(sum(studydata100.duration), 0) as duracion
                from
                    courses100
                left join studydata100 on
                    studydata100.courseID = courses100.courseID
                    #only add the study data rows that are between today and n days before:
                    and
                        studydata100.initialTime < UNIX_TIMESTAMP(DATE(:dayone))
                    and 
                        studydata100.initialTime >= UNIX_TIMESTAMP(DATE_SUB(DATE(:daytwo), interval :lastndays day))
                where
                    #only active courses from the user
                    courses100.`user` = :usuarioid
                    and
                    courses100.finalDate >= :daythree
                group by
                    courses100.courseID
                order by
                    duracion asc";

        $resultsCourses = $this->dbManager->query($sql, ["usuarioid" => $userID, "dayone" => $day, "daytwo" => $day, "lastndays" => $LAST_N_DAYS, "daythree" => $day]);
        //Get the number of courses
        $sql = "SELECT count(courseID) FROM `courses100` WHERE courses100.user=:userID ";
        $sql .= "AND finalDate> DATE(:day)";
        $resultsNumber = $this->dbManager->query($sql, ["userID" => $userID, "day" => $day]);
        $numCourses = $resultsNumber[0][0];
        //Get how many courses are in the bottom 50%
        $bottom50 = floor($numCourses / 2);
        //Create an array with the bottom 50% courses
        $bottom50courses = array();
        $i = 0;
        while ($i < $bottom50) {
            $bottom50courses[$i] = new Course($resultsCourses[$i][0], $resultsCourses[$i][1]);
            $i++;
        }
        return $bottom50courses;
    }


}

?>