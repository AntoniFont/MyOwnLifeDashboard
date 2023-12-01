<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ProjectsDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");


$CoursesDAO = new CoursesDAO();
$UserDAO = new UserDAO();
$ProjectsDAO = new ProjectsDAO();
$course = $CoursesDAO->getCourseFromId($_GET["courseID"]);
$user = $UserDAO->getUserFromNickname($_GET["name"]);
echo $ProjectsDAO->getActiveProjectsFromCourseJSON($course, $user);
?>