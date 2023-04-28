<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ProjectsDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
try {
    $ProjectsDAO = new ProjectsDAO();
    $user = (new UserDAO())->getUserFromNickname($_GET["username"]);
    $course = ((new CoursesDAO())->getCourseFromId($_GET["courseID"]));
    $projects = $ProjectsDAO->getActiveProjectsFromCourse($course, $user);
    echo "<option value='-1'>Undefined</option>";
    foreach ($projects as $project) {
        echo "<option value='" . $project->getId() . "'>" . $project->getName() . "</option>";
    }
} catch (Exception $e) {
    echo "<option value='-1'>Undefined</option>";
}

?>