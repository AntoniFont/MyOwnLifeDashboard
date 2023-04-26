<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/StudyData.php");

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

class StudyDataDAO extends DataAccessObject
{
    function __construct()
    {
        parent::__construct();
    }

    //short function name 🤣🤣🤣
    function getSecondsStudiedByDayInTheLastNDaysJSON($user, $DAYS_DISPLAYED)
    {
        $this->dbManager->openIfItWasClosed();
        /** this function returns the total number of seconds worked in a day in this format:
         *  [["seconds","day in %d-%m-%Y","daysSinceToday"]
         *  A Example that may return:
         *  ["5042","30-12-2022","14"],
         *  ["921","31-12-2022","13"],
         *  ["3600","01-01-2023","12"],
         *  ["4685","02-01-2023","11"], ...
         *
         * Some days might be missing, so later we should process the data to add the missing days as 0 seconds studied
         *  
         */

        $query = "SELECT sum(duration), ";
        $query .= "FROM_UNIXTIME(initialTime, \"%d-%m-%Y\") as dia, ";
        $query .= "FROM_UNIXTIME(UNIX_TIMESTAMP() - UNIX_TIMESTAMP(STR_TO_DATE(FROM_UNIXTIME(initialTime,\"%d-%m-%Y\"),\"%d-%m-%Y\")),\"%d\")  as daysEllapsed ";
        $query .= "FROM studydata100 ";
        $query .= "WHERE initialTime > (UNIX_TIMESTAMP() - (:strvalDaysDisplayed86400)) ";
        $query .= "AND studydata100.userID= :userID ";
        $query .= "GROUP BY FROM_UNIXTIME(initialTime, \"%d-%m-%Y\") ";
        $query .= "ORDER BY initialTime ASC ";
        //1. DO THE QUERY AND CLOSE THE CONECTION TO SAVE CONECTIONS FOR OTHER USERS
        $resultado = $this->dbManager->query($query, [":strvalDaysDisplayed86400" => strval($DAYS_DISPLAYED * 86400), ":userID" => $user->getId()]);
        $this->dbManager->close();
        //2. PROCESSING THE DATA TO ADD THE MISING DAYS AS 0 SECONDS STUDIED
        $dataProcessed = array();
        $today = date('d-m-Y', time());
        for ($i = 14; $i >= 0; $i--) {
            $days_ago = date('d-m-Y', strtotime("-" . $i . " days", strtotime($today))); //https://stackoverflow.com/questions/2708894/how-to-find-out-what-the-date-was-5-days-ago
            $existsDataOnThisDay = false;
            $data = null;
            foreach ($resultado as $key => $value) {
                if (strcmp($value[1], $days_ago) == 0) { // if ($value[1] == days_ago)
                    $existsDataOnThisDay = true;
                    $data = $value;
                }
            }
            if ($existsDataOnThisDay == false) {
                $data = array("0", $days_ago, strval($i));
            }
            array_push($dataProcessed, $data);
        }
        //3. CONVERT INTO JSON OBJECT AND RETURN IT
        return json_encode($dataProcessed, JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
    }


    function insertStudyDataFromForm($courseID, $typeOfStudyData, $projectID, $descripcion, $totalTime, $username)
    {
        //To prevent errors with different timezones, the initialTime (unixTimestamp) is calculated in the server,
        //it is the current time in the server minus the duration of the activity
        $initialTime = time() - $totalTime;

        if ((strcmp($courseID, "-1") == 0) || (!isset($courseID))) {
            $courseID = null;
        }

        if ((strcmp($typeOfStudyData, "-1") == 0) || (!isset($typeOfStudyData))) {
            $typeOfStudyData = null;
        }

        if ((strcmp($projectID, "-1") == 0) || (!isset($projectID))) {
            $projectID = null;
        }

        $this->dbManager->openIfItWasClosed();

        $sql = "insert into studydata100 (courseID,typeID,projectID,initialTime,";
        $sql .= "duration,descripción,userID)";

        $sql .= " values (:courseID, :typeID, :projectID, :initialTime,";
        $sql .= ":duration, :descripcion,  :userID)";
        $values = [
            "courseID" => $courseID,
            "typeID" => $typeOfStudyData,
            "projectID" => $projectID,
            "initialTime" => $initialTime,
            "duration" => $totalTime,
            "descripcion" => urldecode($descripcion),
            "userID" => ((new UserDAO())->getUserFromNickname($username))->getId(),
        ];
        $this->dbManager->query($sql, $values);
        $this->dbManager->close();
    }

    function getStudyDataBetweenTwoDatetimes($user, $initialDate, $finalDate)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "SELECT id,courseID,initialTime,duration,userID FROM studydata100 WHERE userID = :userID AND initialTime >= :initialDate AND initialTime <= :finalDate";
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
            $studyData->constructorA($id, $courseID, $initialTime, $duration, $userID);
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