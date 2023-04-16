<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/myownlifedashboard/dashboard/controller/loginLogic.php");
    $_SESSION["current_page"] = "Time Categorizer";
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Time Categorizer</title>

<!---INCLUDE JQUERY--->
<script src="https://code.jquery.com/jquery-3.6.1.js"
    integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

<!---INCLUDE BOOTSTRAP-->
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>

</head>


<body>
    <?php include '../navbar.php'; ?>
    <?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/myownlifedashboard/dashboard/controller/StudyTimeCategorizer/StudyTimeCategorizer.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

    $coursesDAO = new CoursesDAO();
    $StudyTimeCategorizer = new StudyTimeCategorizer();
    //Get all the study sessions of the last 14 days
    $StudyDataDAO = new StudyDataDAO();
    //current unix timestamp
    $currentUnixTimestamp = time();
    //14 days ago
    $last14DaysUnixTimestamp = $currentUnixTimestamp - (14 * 24 * 60 * 60);
    $user = (new UserDAO())->getUserFromNickname($_GET["name"]);
    $studyData = $StudyDataDAO->getStudyDataBetweenTwoDatetimes($user,$last14DaysUnixTimestamp, $currentUnixTimestamp);
    echo "<div class='container'>";
    echo "<h1>Study sessions of the last 14 days</h1>";
    echo "<table class='table table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th scope='col'>Id</th>";
    echo "<th scope='col'>Course</th>";
    echo "<th scope='col'>Initial Time</th>";
    echo "<th scope='col'>Duration</th>";
    echo "<th scope='col'>Score</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($studyData as $studyDataItem) {
        $initialTime = $studyDataItem->getInitialTime();
        $duration = $studyDataItem->getDuration();
        $category = $StudyTimeCategorizer->categorize($studyDataItem);
        $id = $studyDataItem->getId();
        $courseID = $studyDataItem->getCourseID();
        if($courseID != null){
            $courseName = ($coursesDAO->getCourseFromId($courseID))->getName();
        }else {
            $courseName = "NULL";
        }
        $humanReadableDate = date("d-m-Y H:i:s", $initialTime);

        echo "<tr>";
        echo "<th scope='row'>".$id."</th>";
        echo "<td>".$courseID." : ".$courseName."</td>";
        echo "<td>".$initialTime." : ".$humanReadableDate. "</td>";
        echo "<td>".$duration."</td>";
        echo "<td>".$category."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    ?> 
</body>