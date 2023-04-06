<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ProjectsDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
$ProjectsDAO = new ProjectsDAO();
$user = (new UserDAO())->getUserFromNickname($_GET["username"]);
$course = ((new CoursesDAO())->getCourseFromId($_GET["courseID"]));
$projects = $ProjectsDAO->getProjectsFromCourse($course, $user);
foreach ($projects as $project) {
    echo "<option value='" . $project->getId() . "'>" . $project->getName() . "</option>";
}

?>