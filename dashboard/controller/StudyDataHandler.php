<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/Handler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/StudyData.php");

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/UserHandler.php");

class StudyDataHandler extends Handler
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
        date_default_timezone_set('Europe/Madrid');
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


    function insertStudyDataFromForm($courseID, $typeOfStudyData, $projectID, $descripcion, $totalTime, $initialTime, $username, $question1, $question2)
    {

        if ((strcmp($courseID, "-1") == 0) || (!isset($courseID))) {
            $courseID = null;
        }

        if ((strcmp($typeOfStudyData, "-1") == 0) || (!isset($typeOfStudyData))) {
            $typeOfStudyData = null;
        }

        if ((strcmp($projectID, "-1") == 0) || (!isset($projectID))) {
            $projectID = null;
        }

        //HANDLING OF THE QUESTIONS
        /*in the frontend the questions should be:
        1. Where your friends in the same room (or online room) and you where able to comunicate? : YES/NO
        2. ¿What were your friends doing?
        Answer1: Each one working on their own thing or on their part of the project, with the posibility of asking for help or comenting aloud.
        Answer2: We were working on the same task
        So the logic goes as follows:
        If question1: no -->  beingAlone = True, workingAlone = True
        If question1: yes and question2: answer1 --> beingAlone = False, workingAlone = True 
        If question1: yes and question2: answer2 --> beingAlone = False, workingAlone = False
        Then we must handle the question1: NULL and/or question2: NULL apropiately.
        */

        $workingAlone = null;
        $beingAlone = null;

        if (strcmp($question1, "no") == 0) { //if question1 == no
            $beingAlone = "true";
            $workingAlone = "true";
        } else if (strcmp($question1, "yes") == 0) { //if question1 == yes
            $beingAlone = "false";
            if (strcmp($question2, "answer1") == 0) {
                $workingAlone = "true";
            } else if (strcmp($question2, "answer2") == 0) {
                $workingAlone = "false";
            }
        }

        $this->dbManager->openIfItWasClosed();

        $sql = "insert into studydata100 (courseID,typeID,projectID,initialTime,";
        $sql .= "duration,descripción,planned,userID,workingAlone,beingAlone)";

        $sql .= " values (:courseID, :typeID, :projectID, :initialTime,";
        $sql .= ":duration, :descripcion, :planned, :userID, :workingAlone, :beingAlone)";
        $values = [
            "courseID" => $courseID,
            "typeID" => $typeOfStudyData,
            "projectID" => $projectID,
            "initialTime" => $initialTime,
            "duration" => $totalTime,
            "descripcion" => urldecode($descripcion),
            "planned" => 0,
            "userID" => ((new UserHandler())->getUserFromNickname($username))->getId(),
            "workingAlone" => $workingAlone,
            "beingAlone" => $beingAlone
        ];
        $this->dbManager->query($sql, $values);
        $this->dbManager->close();
    }

    function getStudyDataBetweenTwoDatetimes($user, $initialDate,$finalDate){
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
            $studyData->constructorA($id,$courseID,$initialTime,$duration,$userID);
            array_push($resultado,$studyData);
        }
        return $resultado;
    }
}

?>