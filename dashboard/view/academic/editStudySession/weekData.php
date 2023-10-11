<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ProjectsDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/auxiliar/TimeAuxi.php");

require_once("./projectsDropdown.php");
require_once("./coursesDropdown.php");

$coursesDAO = new CoursesDAO();
$user = (new UserDAO())->getUserFromNickname($_GET["name"]);
$StudyDataDAO = new StudyDataDAO();
$nowTimestamp = strtotime("now");
$TwoWeekAgoTimestamp = strtotime("-14 days");
$studyData = $StudyDataDAO->getStudyDataBetweenTwoDatetimes($user, $TwoWeekAgoTimestamp, $nowTimestamp);
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
        echo "<input type='hidden' name='name' value='" . $_GET["name"] . "'>";
        echo "<th scope='row'>" . $id . "</th>";
        echo "<input type='hidden' name='id' value='" . $id . "'>";
        echo "<td>  <select name='course'>" . getCoursesDropdown($user, $course) . "</select></td>";

        echo "<td> <select name='project'>";
        echo getProjectDropdown($course, $user, $projectId);
        echo "</select></td>";

        echo "<td> <input class = 'initialTime' name='initialTime' type='number' step = '60' value='" . $initialTime . "'> : <span class='timeText'>" . $humanReadableDate . "</span></td>";
        echo "<td>";
        echo "<input name='duration'class='duration' type='number' value='" . $duration . "'>";
        echo "<span class='hours'>0 </span> hours, <span class='minutes'>0</span> minutes, <span
                            class='seconds'>0</span> seconds</p>";
        echo "</td>";
        echo "<td><input type='submit' value='submit changes'></td>";
        echo "</form>";
        echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>

<script>
        $(document).ready(function () {

                $('input[type="submit"]').click(function () {
                        setTimeout(function () {
                                location.reload();
                        }, 1000); // 1000 milliseconds (1 second)
                });


                $(".duration").each(function () {  //When the page loads update all the hours and minutes 
                        updateHoursAndMinutes(this)
                })

                $(".duration").change(function () { updateHoursAndMinutes(this) });
                $(".duration").keyup(function () { updateHoursAndMinutes(this) });
                $(".initialTime").change(function () { updateInitialTime(this) });
                $(".initialTime").keyup(function () { updateInitialTime(this) });


                function updateHoursAndMinutes(button) {
                        let totalSeconds = $(button).val();
                        totalSeconds = parseInt(totalSeconds);
                        let hours, minutes, seconds;
                        //if less than 0 or a string is entered
                        if (totalSeconds < 0) {
                                hours = "invalid";
                                minutes = "invalid";
                                seconds = "invalid";
                        } else {
                                hours = Math.floor(totalSeconds / 3600);
                                minutes = Math.floor((totalSeconds % 3600) / 60);
                                seconds = totalSeconds % 60;
                        }
                        $(button).parent().find(".hours").text(hours);
                        $(button).parent().find(".minutes").text(minutes);
                        $(button).parent().find(".seconds").text(seconds);
                }

                function updateInitialTime(button) {
                        $.ajax({
                                url: './backend/unixTimeToHumanReadable.php',
                                method: 'GET', 
                                data: { 
                                        time: $(button).val(),
                                },
                                success: function (response) {
                                        $(button).parent().find(".timeText").text(response);
                                }
                        });
                }
        })
</script>