<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/Handler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/Course.php");


class CoursesHandler extends Handler
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


}


?>