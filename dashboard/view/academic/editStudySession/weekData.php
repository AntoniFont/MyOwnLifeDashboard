<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ProjectsDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/auxiliar/TimeAuxi.php");

require_once("./projectsDropdown.php");
require_once("./coursesDropdown.php");

echo "<script>alert('This page is not completed, nothing should work') </script>";
$coursesDAO = new CoursesDAO();
$user = (new UserDAO())->getUserFromNickname($_GET["name"]);
$StudyDataDAO = new StudyDataDAO();
$nowTimestamp = strtotime("now");
$TwoWeekAgoTimestamp = strtotime("-14 days");
$studyData = $StudyDataDAO->getStudyDataBetweenTwoDatetimes($user,$TwoWeekAgoTimestamp,$nowTimestamp);
echo "<table class='table table-striped'>";
echo "<thead>";
echo "<tr>";
echo "<th scope='col'>Id</th>";
echo "<th scope='col'>Course</th>";
echo "<th scope='col'>Project</th>";
echo "<th scope='col'>Initial Time</th>";
echo "<th scope='col'>Duration</th>";
echo "<th scope='col'>Submit changes</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
foreach ($studyData as $studyDataItem) {
        $id = $studyDataItem->getId();
        $course = $coursesDAO->getCourseFromId($studyDataItem->getCourseId());
        $initialTime = $studyDataItem->getInitialTime();
        $duration = $studyDataItem->getDuration();
        $projectId = $studyDataItem->getProjectId();
        
        if ($course->getId() != null) {
                $courseName = $course->getName();
        } else {
                $courseName = "NULL";
        }
        $humanReadableDate = date("d-m-Y H:i:s", $initialTime);

        echo "<tr>";
        echo "<form target ='_blank' action='./backend/edit.php'>";
        echo "<th scope='row'>" . $id . "</th>";
        echo "<input type='hidden' name='id' value='" . $id . "'>";
        echo "<td>  <select name='course'>" . getCoursesDropdown($user,$course) . "</select></td>"; 

        echo "<td> <select name='project'>";
        echo getProjectDropdown($course,$user,$projectId);
        echo "</select></td>";
        
        echo "<td>" . $initialTime . " : " . $humanReadableDate . "</td>";
        echo "<td>" . $duration . "</td>";
        echo "<td><input type='submit' value='submit changes'></td>";
        echo "</form>";
        echo "</tr>";
}
echo "</tbody>";
echo "</table>";

?>