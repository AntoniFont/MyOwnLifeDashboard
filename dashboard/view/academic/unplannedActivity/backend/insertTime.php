<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/StudyDataHandler.php");

$studyDataHandler = new StudyDataHandler();
$studyDataHandler->insertStudyDataFromForm(
    $_GET["courseID"],
    $_GET["typeOfStudyID"],
    $_GET["projectID"],
    $_GET["description"],
    $_GET["totalTime"],
    $_GET["initialTime"],
    $_GET["name"],
    $_GET["question1"],
    $_GET["question2"]
)

?>