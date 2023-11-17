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


    function insertStudyDataFromForm($courseID, $projectID, $totalTime, $username, $initialTime,$triggerID,$studyCharacteristicsID)
    {
        if ((strcmp($courseID, "-1") == 0) || (!isset($courseID))) {
            $courseID = null;
        }

        if ((strcmp($projectID, "-1") == 0) || (!isset($projectID))) {
            $projectID = null;
        }

        if ((strcmp($triggerID, "-1") == 0) || (!isset($triggerID))) {
            $triggerID = null;
        }

        
        if ((strcmp($studyCharacteristicsID, "-1") == 0) || (!isset($studyCharacteristicsID))) {
            $studyCharacteristicsID = null;
        }

        $this->dbManager->openIfItWasClosed();

        $sql = "insert into studydata100 (courseID,projectID,initialTime,";
        $sql .= "duration,userID,triggerID,studyCharacteristicsID)";

        $sql .= " values (:courseID, :projectID, :initialTime,";
        $sql .= ":duration,  :userID,:triggerID,:studyCharacteristicsID)";
        $values = [
            "courseID" => $courseID,
            "projectID" => $projectID,
            "initialTime" => $initialTime,
            "duration" => $totalTime,
            "userID" => ((new UserDAO())->getUserFromNickname($username))->getId(),
            "triggerID" => $triggerID, 
            "studyCharacteristicsID" => $studyCharacteristicsID
        ];
        $this->dbManager->query($sql, $values);
        $this->dbManager->close();
    }

    function insertStudyDataFromTimer($courseID, $projectID,  $totalTime, $username,$triggerID,$studyCharacteristicsID)
    {
        //To prevent errors with different timezones, the initialTime (unixTimestamp) is calculated in the server,
        //it is the current time in the server minus the duration of the activity
        $initialTime = time() - $totalTime;
        self::insertStudyDataFromForm($courseID, $projectID, $totalTime, $username, $initialTime,$triggerID,$studyCharacteristicsID);
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

    /*
    Given a study data id, it updates the study data ranking
    */
    public function updateStudyDataRanking($studyDataID, $ranking)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "UPDATE studydata100 SET ranking = :ranking WHERE id = :id";
        $values = [
            "ranking" => $ranking,
            "id" => $studyDataID
        ];
        $this->dbManager->query($sql, $values);
        $this->dbManager->close();
    }
    /*Given two unix timestamps, returns the duration of each type of
    studydata between those two timestamps (typical 'group by ranking' in sql). 
    For example:
    1 hour of ranking bronze
    3 hours of ranking silver
    2 hours of ranking gold
    etc
    */
    public function getRankedStudyData($initialTime, $finalTime, $user)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "select
                    ranking.name,
                    IFNULL(sum(duration), 0) as duration
                from
                    ranking
                left join studydata100 on
                    studydata100.ranking = ranking.id
                    and userID = :userID
                    and initialTime >= :initialTime
                    and initialTime <= :finalTime
                group by
                    ranking.id
                order by
                    ranking.id desc
        ";
        $values = [
            "userID" => $user->getId(),
            "initialTime" => $initialTime,
            "finalTime" => $finalTime
        ];
        $resultadoQuery = $this->dbManager->query($sql, $values);
        /*
        Convert the result into an array
        Ranking => duration
        Bronze => 1
        Silver => 3
        Gold => 2
        
        */
        $resultado = array();
        foreach ($resultadoQuery as $query) {
            $resultado[$query[0]] = $query[1];
        }
        $this->dbManager->close();
        return $resultado;
    }

}

?>