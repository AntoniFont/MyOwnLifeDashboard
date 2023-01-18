<?php
session_start();
if (!isset($_SESSION["loggedIn"])) {
    header("Location: http://".$_SERVER['SERVER_NAME']."/myownlifedashboard"."/login/login.php");
} 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My own life </title>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.2/highcharts.js"
        integrity="sha512-JVzXlL1mZb/G0YNUJtPqUzA/QtPMQLNpCtEBOV9R8P3Uskp4W0C+6SVZ3rpwnKcp/V/59YQoGNUYmB/N6do1sA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.highcharts.com/modules/drilldown.js"></script>

    <script src="./scripts/misc/otherThingsScript.js"></script>
    <script src="./scripts/auxScripts/number-rush.js"></script>
    <script src="./scripts/loadData/chartsOptions.js"></script>
    <script src="./scripts/loadData/loadChart1And2.js"></script>
    <script src="./scripts/loadData/loadChart3And4.js"></script>
    <script src="./scripts/loadData/loadObjectives.js"></script>
</head>

<body>
    <?php include '../navbar.php'; ?>
    <h1>
    <?php 
        include $_SERVER['DOCUMENT_ROOT']."/myownlifedashboard/.classPaths/User.php";
        //include $_SERVER['DOCUMENT_ROOT']."/myownlifedashboard/.classPaths/DatabaseManager.php";
        $usuario = new User("pepe");
        echo "holis";
    ?>
    <h1>
    <div class="container mt-3">
        <div style="background-color:rgb(252, 252, 248)">
            <div class="row">
                <div class="d-flex justify-content-center ">
                    <h1>Be perseverant! Do a little bit of work everyday</h1>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <p>You must do a minimum (baseline) of work everyday </p>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-xs-12 col-sm-6 ">
                    <div id="chart3Container"></div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="row h-50">
                        <div class="d-flex justify-content-center align-items-end">
                            <div class="display-1"><span id="chart4Container"></span>%</div>
                        </div>
                    </div>
                    <div class="row h-50">
                        <div class="d-flex justify-content-center">
                            <p>Average baseline completed in the last 2 weeks </p>
                        </div>
                    </div>

                </div>
            </div>


        </div>
        <div class="mt-5 mb-5" style="background-color:rgb(252, 252, 248)">
            <div class="row">
                <div class="d-flex justify-content-center">
                    <h1>Don't leave behind any courses!</h1>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <p>Number of hours per course in the last 2 weeks.</p>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-xs-12 col-sm-6">
                    <div id="chart1Container"></div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div id="chart2Container"></div>
                </div>
            </div>

            <div class="row mt-3">
                <h3 class="text-center">My goal is:</h3>
            </div>
            <div class="row mt-3">
                <div class="d-flex">
                    <p class=""><span id="balanceObjective"></p>
                </div>
            </div>
        </div>

        <p id="test"></p>
    </div>


</body>