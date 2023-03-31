<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/Handler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/DatabaseManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/UserHandler.php");

class StudyDataHandler extends Handler
{
    function __construct()
    {
        parent::__construct();
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

    }
}

?>