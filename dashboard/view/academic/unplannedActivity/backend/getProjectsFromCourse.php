<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/myownlifedashboard/dashboard/controller/ProjectsHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/myownlifedashboard/dashboard/controller/CoursesHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/myownlifedashboard/dashboard/controller/UserHandler.php");

$coursesHandler = new CoursesHandler();
$userHandler = new UserHandler();
$projectsHandler = new ProjectsHandler();
$course = $coursesHandler->getCourseFromId($_GET["courseID"]);
$user = $userHandler->getUserFromNickname($_GET["name"]);
echo $projectsHandler->getActiveProjectsFromCourseJSON($course, $user);
?>