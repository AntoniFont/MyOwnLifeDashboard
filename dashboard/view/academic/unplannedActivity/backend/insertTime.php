<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");

$StudyDataDAO = new StudyDataDAO();
$StudyDataDAO->insertStudyDataFromForm(
    $_GET["courseID"],
    $_GET["typeOfStudyID"],
    $_GET["projectID"],
    $_GET["description"],
    $_GET["totalTime"],
    $_GET["name"],
)

?>