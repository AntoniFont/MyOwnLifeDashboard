<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/loginLogic.php");
$_SESSION["current_page"] = "Overview";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
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
    
    <script src="./script.js"></script>
</head>

<body>
    <?php include '../navbar.php'; ?>
    <div class='container'>
        <?php
        require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
        $currentTimestamp = time();
        $weekNumber = date("W", $currentTimestamp);
        $weekFirstSecond = strtotime("last monday");
        $user = (new UserDAO())->getUserFromNickname($_GET["name"]);
        $data = (new StudyDataDAO())->getRankedStudyData($weekFirstSecond,$currentTimestamp,$user);
        echo "<table class='table table-striped table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>Week ".$weekNumber-1 ."</th>";
        echo "<th scope='col'>Week ".$weekNumber." </th>";
        echo "<th scope='col'>Week ".$weekNumber+1 ."</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($data as $key => $value) {
            $hours = number_format($value/3600,2);
            echo "<tr>";
            echo "<td>" . $key." -1" . "</td>";
            echo "<td>" . $hours ." ".$key." hours". "</td>";
            echo "<td>" . $key." +1" . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        ?>
        <!-- Previous and next week buttons , as a '<' and '>' button -->
        <div class="row">
            <div class="col-6">
                <button type="button" class="btn btn-primary"> &lt</button>
            </div>
            <div class="col-6">
                <button type="button" class="btn btn-primary">&gt</button>
            </div>
        </div>
    </div>
        <?php 
        ?>

</body>