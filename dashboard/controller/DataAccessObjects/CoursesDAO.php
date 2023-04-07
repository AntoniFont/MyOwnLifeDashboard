<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/Course.php");


class CoursesDAO extends DataAccessObject
{
    function __construct(){
        parent::__construct();
    }

    function getCoursesFromUser($user)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "SELECT courseID, name FROM courses100"; //the id and the name 
        $sql .= " WHERE courses100.user = :userID"; //from the courses that the user has
        $sql .= " AND UNIX_TIMESTAMP(STR_TO_DATE(courses100.finalDate, \"%Y-%m-%d\")) > UNIX_TIMESTAMP() "; //and the course is still active
        $coursesQuery = $this->dbManager->query($sql, ["userID" => $user->getId()]);
        $this->dbManager->close();
        $courses = array();
        $i = 0;
        foreach ($coursesQuery as $courseQuery) {
            $courses[$i] = new Course($courseQuery[0], $courseQuery[1]);
            $i++;
        }
        return $courses;
    }

    function getCourseFromId($id)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "SELECT courseID, name FROM courses100 WHERE courseID = :id";
        $courseQuery = $this->dbManager->query($sql, ["id" => $id]);
        $this->dbManager->close();
        $course = new Course($courseQuery[0][0], $courseQuery[0][1]);
        return $course;
    }

    /*
     Given an initial day, and an integer LAST_N_DAYS, first it gets the interval, for example
     if the initial day is 1-May-2023, and LAST_N_DAYS is 14, then the interval will be from
     18-Apr-2023 00:00:00 to 1-May-2023 00:00:00 

     In this interval, it will get the bottom 50% (floored to the next int, so for 7 courses it will be 3 
     courses instead of 4 , 3.5 can't be because it's not an integer)
     of the least studied courses. And return it an array of Course objects.
    */
    function getBottom50PercentLeastStudiedCoursesInInterval($initialDay, $userID, $LAST_N_DAYS)
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

        $resultsCourses = $this->dbManager->query($sql, ["usuarioid" => $userID, "dayone" => $initialDay, "daytwo" => $initialDay, "lastndays" => $LAST_N_DAYS, "daythree" => $initialDay]);
        //Get the number of courses
        $numCourses = count($resultsCourses);
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