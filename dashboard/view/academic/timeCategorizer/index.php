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
    require_once($_SERVER["DOCUMENT_ROOT"]."/myownlifedashboard/dashboard/controller/TimeCategorizer.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/myownlifedashboard/dashboard/controller/StudyDataHandler.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/myownlifedashboard/dashboard/controller/UserHandler.php");
    
    $timeCategorizer = new TimeCategorizer();
    //Get all the study sessions of the last 14 days
    $studyDataHandler = new StudyDataHandler();
    //current unix timestamp
    $currentUnixTimestamp = time();
    //14 days ago
    $last14DaysUnixTimestamp = $currentUnixTimestamp - (14 * 24 * 60 * 60);
    $user = (new UserHandler())->getUserFromNickname($_GET["name"]);
    $studyData = $studyDataHandler->getStudyDataBetweenTwoDatetimes($user,$last14DaysUnixTimestamp, $currentUnixTimestamp);
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
        echo "<tr>";
        echo "<th scope='row'>".$studyDataItem->getId()."</th>";
        echo "<td>".$studyDataItem->getCourseID()."</td>";
        echo "<td>".$studyDataItem->getInitialTime()."</td>";
        echo "<td>".$studyDataItem->getDuration()."</td>";
        echo "<td>".$timeCategorizer->categorize($studyDataItem)."</td>";
        echo "</tr>";
    }

    ?> 
</body>