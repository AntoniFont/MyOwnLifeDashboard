<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/StudyData.php");

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");

class StudyDataDAO extends DataAccessObject
{
    function __construct()
    {
        parent::__construct();
    }


    function getCriticalSecondsStudiedByDayInTheLastNDaysJSON($user, $DAYS_DISPLAYED)
    {
        /** this function returns the total number of critical seconds worked in a day (critical seconds
         * are the study time dedicated to the bottom 50% least studied courses) in this format:
         *  [["seconds","day in %d-%m-%Y","daysSinceToday"]
         *  A Example that may return:
         *  ["5042","30-12-2022","14"],
         *  ["921","31-12-2022","13"],
         *  ["3600","01-01-2023","12"],
         *  ["4685","02-01-2023","11"], ...
         *
         **/
        $this->dbManager->openIfItWasClosed();
        $result = array();

        for ($i = 0; $i < 14; $i++) {
            $newDay = new DateTime(); //today
            $newDay->modify("-$i days");
            $newDayString = $newDay->format("Y-m-d");
            $realTime = self::getCriticalSecondsStudiedOfTheDay($user, $newDayString, $DAYS_DISPLAYED);
            array_push($result,[$realTime,$newDay->format("d-m-Y"),$DAYS_DISPLAYED-$i]);
        }
        return json_encode($result, JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
    }


    function insertStudyDataFromForm($courseID, $projectID, $totalTime, $username, $initialTime,$triggersID,$studyCharacteristicsID)
    {
        if ((strcmp($courseID, "-1") == 0) || (!isset($courseID))) {
            $courseID = null;
        }

        if ((strcmp($projectID, "-1") == 0) || (!isset($projectID))) {
            $projectID = null;
        }

        $triggersID = json_decode($triggersID);
        
        $this->dbManager->openIfItWasClosed();

        $sql = "insert into studydata100 (courseID,projectID,initialTime,";
        $sql .= "duration,userID)";

        $sql .= " values (:courseID, :projectID, :initialTime,";
        $sql .= ":duration,  :userID)";
        $values = [
            "courseID" => $courseID,
            "projectID" => $projectID,
            "initialTime" => $initialTime,
            "duration" => $totalTime,
            "userID" => ((new UserDAO())->getUserFromNickname($username))->getId(),
        ];
        $this->dbManager->query($sql, $values);
        $lastInsertID = $this->dbManager->lastInsertId();
        foreach ($triggersID as $triggerID){
            if((strcmp($triggerID, "-1") != 0)){
                echo "lastInsertID: ".$lastInsertID.", triggerID: ".$triggerID;
                $sql = "insert into studydata_triggers (studydataID,triggerID) values (:studydataID,:triggerID)";
                $this->dbManager->query($sql, ["studydataID" => $lastInsertID, "triggerID" => $triggerID]);
            }
        }
        $this->dbManager->close();
    }

    function insertStudyDataFromTimer($courseID, $projectID,  $totalTime, $username,$triggersID,$studyCharacteristicsID)
    {
        //To prevent errors with different timezones, the initialTime (unixTimestamp) is calculated in the server,
        //it is the current time in the server minus the duration of the activity
        $initialTime = time() - $totalTime;
        self::insertStudyDataFromForm($courseID, $projectID, $totalTime, $username, $initialTime,$triggersID,$studyCharacteristicsID);
    }

    function getStudyDataBetweenTwoDatetimes($user, $initialDate, $finalDate)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "SELECT id,courseID,initialTime,duration,userID,projectID FROM studydata100 WHERE userID = :userID AND initialTime >= :initialDate AND initialTime <= :finalDate";
        $values = [
            "userID" => $user->getId(),
            "initialDate" => $initialDate,
            "finalDate" => $finalDate
        ];
        $resultadoQuery = $this->dbManager->query($sql, $values);
        $this->dbManager->close();
        $resultado = array();
        foreach ($resultadoQuery as $query) {
            $studyData = new StudyData();
            $id = $query[0];
            $courseID = $query[1];
            $initialTime = $query[2];
            $duration = $query[3];
            $userID = $query[4];
            $projectID = $query[5];
            $studyData->constructorA($id, $courseID, $initialTime, $duration, $userID, $projectID);
            array_push($resultado, $studyData);
        }
        return $resultado;
    }

    //day in yyyy-mm-dd 
    public function getStudySessionsOfADay($user, $day)
    {
        $initialTime = strtotime($day . "00:00:00");
        $finalTime = strtotime($day . "23:59:59");
        return $this->getStudyDataBetweenTwoDatetimes($user, $initialTime, $finalTime);
    }

    public function getCriticalSecondsStudiedOfTheDay($user, $day, $DAYS_DISPLAYED)
    {
        $studySessions = $this->getStudySessionsOfADay($user, $day);
        $coursesDao = new CoursesDAO();
        $courses = $coursesDao->getBottom50PercentLeastStudiedCoursesInInterval($day, $user->getId(), $DAYS_DISPLAYED);

        $totalSeconds = 0;
        foreach($studySessions as $session){
            foreach($courses as $course){
                if($session->getCourseID() == $course->getId()){
                    $totalSeconds += $session->getDuration(); 
                }
            }
        }
        return $totalSeconds;
    }

}

?>