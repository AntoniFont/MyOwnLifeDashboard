<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");

$StudyDataDAO = new StudyDataDAO();
$StudyDataDAO->insertStudyDataFromTimer(
    $_GET["courseID"],
    $_GET["projectID"],
    $_GET["totalTime"],
    $_GET["name"],
    $_GET["triggersID"],
    $_GET["studyCharacteristicsID"]
)

?>