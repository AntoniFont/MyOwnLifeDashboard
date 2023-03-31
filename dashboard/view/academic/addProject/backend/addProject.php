<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/ProjectsHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/CoursesHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/UserHandler.php");

$projectsHandler = new ProjectsHandler();
$projectsHandler->addProject(
    $_GET["projectName"],
    $_GET["description"], 
    (new CoursesHandler())->getCourseFromId($_GET["course"]) , 
    (new UserHandler())->getUserFromNickname($_GET["username"])
);
//print for debug
echo $_GET["projectName"];
echo $_GET["description"];
echo $_GET["course"];
echo $_GET["username"];
?>