<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/Handler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/CoursesHandler.php");

class TimeCategorizer extends Handler
{
    function __construct()
    {
        parent::__construct();
    }
    /*It will categorize a study session and give it a ranking based on some criteria    
    */
    public function categorize($studyDataId)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "SELECT courseID,initialTime,userID FROM studyData100 WHERE id = :studyDataId";
        $results = $this->dbManager->query($sql, ["studyDataId" => $studyDataId]);
        $courseID = $results[0][0];
        echo "CourseID: ".$courseID."<br>";
        $initialTime = $results[0][1];
        $userID = $results[0][2];
        $this->evaluateCriteria1($courseID, $initialTime, $userID);
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
    function evaluateCriteria1($courseID, $initialTime, $userID)
    {
        $this->dbManager->openIfItWasClosed();
        /*
        - InitialTime is the time when the user started studying, in unix timestamp format.
        - we need to get number of seconds in the last 14 days by course at the 00:00:00 of the day,
        and see if the course that the user is studying is in the bottom 50% of the courses.
        */
        $LAST_N_DAYS = 14;

        //1. To do that, first we need to get from the timestamp the day.           
        $day = date("Y-m-d", $initialTime);
        echo "Dia: ".$day;
        //2. Then we need to get the number of seconds studied in the last 14 days by course at the 00:00:00 of the day
        $sql = "SELECT sum(duration),courseID FROM `studydata100` WHERE studydata100.userID=:userID "; 
        $sql .= "AND initialTime<UNIX_TIMESTAMP(DATE(:dayone)) "; 
        $sql .= "AND initialTime> UNIX_TIMESTAMP((DATE(:daytwo)-:lastndays) ) ";
        $sql .= "GROUP BY courseID ORDER BY sum(duration) ASC ";
        $results = $this->dbManager->query($sql, ["userID" => $userID, "dayone" => $day,"daytwo" => $day , "lastndays" => $LAST_N_DAYS]);
        //Print the results in a html table and count the number of courses
        $numCourses = 0;
        echo "<table>";
        echo "<tr><th>CourseID</th><th>Seconds studied in the last 14 days</th></tr>";
        foreach ($results as $result) {
            $numCourses++;
            echo "<tr><td>" . $result[1] . "</td><td>" . $result[0]/3600 . "</td></tr>";
        }
        echo "</table>";
        echo "Number of courses: ".$numCourses."<br>";
        //3. Then we need to see if the course that the user is studying is in the bottom 50% of the courses.
        $bottom50 = floor($numCourses / 2);
        echo "Number of courses in the bottom 50%: ".$bottom50."<br>";
        $bottom50courses = array();
        $i = 0;
        $found = false;
        while ($i < $bottom50 ) {
            $bottom50courses[$i] = $results[$i][1];
            if ($results[$i][1] == $courseID) {
                $found = true;
            }
            $i++;
        }
        if ($found) {
            echo "The course is in the bottom 50%";
        } else {
            echo "The course is not in the bottom 50%";
        }
        //4. Print the bottom 50% courses
        echo "<br><br>Bottom 50% courses:<br>";
        echo "<table>";
        echo "<tr><th>CourseID</th></tr>";
        foreach ($bottom50courses as $course) {
            $coursesHandler = new CoursesHandler();
            echo "<tr><td>" . ($coursesHandler->getCourseFromId($course))->getName() . "</td></tr>";
        }
        echo "</table>";
    }

    function evaluateCriteria2(){
        
    }


}

?>