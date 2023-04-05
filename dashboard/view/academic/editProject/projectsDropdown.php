<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/ProjectsHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/CoursesHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/UserHandler.php");
$projectsHandler = new ProjectsHandler();
$user = (new userHandler())->getUserFromNickname($_GET["username"]);
$course = ((new CoursesHandler())->getCourseFromId($_GET["courseID"]));
$projects = $projectsHandler->getProjectsFromCourse($course, $user);
foreach ($projects as $project) {
    echo "<option value='" . $project->getId() . "'>" . $project->getName() . "</option>";
}

?>