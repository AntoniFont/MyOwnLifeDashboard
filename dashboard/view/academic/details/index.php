<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/loginLogic.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ObjectiveDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$_SESSION["current_page"] = "Details";
$ObjectiveDAO = new ObjectiveDAO();
$UserDAO = new UserDAO();
$user = $UserDAO->getUserFromNickname($_GET["name"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.3/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/10.3.2/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/10.3.2/modules/solid-gauge.js"></script>

    <script src="./scripts/misc/otherThingsScript.js"></script>
    <script src="./scripts/auxScripts/number-rush.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.0/dist/confetti.browser.min.js"></script>
    <script src="./scripts/loadData/chartsOptions.js"></script>
    <script src="./scripts/loadData/warningsHandler.js"></script>
    <script src="./scripts/loadData/loadChart1And2.js"></script>
    <script src="./scripts/loadData/loadChart3And4.js"></script>
    <script src="./scripts/loadData/loadChart5.js"></script>
    <script src="./scripts/loadData/loadChart6And7.js"></script>
</head>

<body>
    <?php include '../navbar.php'; ?>
    <div class="container mt-3">
        <div class="row mb-3" id="emojisCelebracion" hidden>
            <h2 class="display-2 text-center">¡Sigue así!</h2>
            <h1 class="display-3 text-center">👏👏🎊🎉🎉🎊👏👏</h1>
        </div>

        <div style="background-color:rgb(252, 252, 248); border: 1px solid rgba(0,0,0,0.125);">
            <div class="row">
                <div class="d-flex justify-content-center align-items-start">
                    <h1 class="pe-3">Hoy
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <p>Datos relevantes de hoy </p>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div id="chart5container"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 ">
                    <div class="row">
                        <h3 class='text-center'>Las asignaturas que estudiar hoy son: </h3>
                    </div>
                    <div class="row ms-2">
                        <div class="d-flex ">
                            <?php
                            require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
                            require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

                            $coursesDAO = new CoursesDAO();
                            $userDAO = new UserDAO();
                            $user = $userDAO->getUserFromNickname($_GET["name"]);
                            $courses = $coursesDAO->getBottom50PercentLeastStudiedCoursesInInterval(date("Y-m-d"), $user->getId(), 14);
                            //PRINT THE COURSES
                            echo "<table class='table table-striped table-hover'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th scope='col'>Course name</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($courses as $course) {
                                echo "<tr>";
                                echo "<td>" . $course->getName() . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 ">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="alert alert-warning me-3" role="alert" id="no6thcoursewarning">
                            No 6th course! <a href="../info/info.html#h.57qet5tjzvb2" target="_blank"> ? </a>
                        </div>
                        <div class="alert alert-warning me-3" role="alert" id="no7thcoursewarning">
                            No 7th course! <a href="../info/info.html#h.981wrw39dkid" target="_blank"> ? </a>
                        </div>
                        <div class="alert alert-success me-3" role="alert" id="successwarning">
                            No warnings! 😊
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5" style="background-color:rgb(252, 252, 248); border: 1px solid rgba(0,0,0,0.125);">
            <div class="row ">
                <div class="d-flex justify-content-center align-items-start">
                    <h1 class="pe-3">Hacer un poco de lo que es necesario cada dia.
                    </h1>
                    <p><a href="../info/info.html#h.fcua4kt5b3rm" target="_blank">?</a></p>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <p>Un mínimo diario de trabajo crítico cada día </p>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-xs-12 col-sm-6 ">
                    <div id="chart3Container"></div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <div class="row h-50">
                        <div class="d-flex justify-content-center align-items-end">
                            <div class="display-1"><span style="color:green" id="consistencyObjective"><span
                                        id="chart4Container"></span>%</span></div>
                        </div>
                    </div>
                    <div class="row h-50">
                        <div class="d-flex justify-content-center">
                            <p>Average baseline completed in the last 2 weeks </p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xs-12 col-sm-6">
                        <div id="chart1Container"></div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div id="chart2Container"></div>
                    </div>
                    <div class="row mt-3">
                        <h3 class="text-center">My goal is:</h3>
                    </div>
                    <div class="row mt-3 ms-2">
                        <div class="d-flex">
                            <?php
                            echo ($ObjectiveDAO->getCurrentConsistencyObjective($user))->getText();
                            ?>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <div class="mt-5" style="background-color:rgb(252, 252, 248); border: 1px solid rgba(0,0,0,0.125);">
            <div class="row ">
                <div class="d-flex justify-content-center align-items-start">
                    <h1 class="pe-3">Trigger analysis
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <p>Bajo que circunstancias te pones a trabajar y bajo que circunstancias no te pones a trabajar</p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div id="chart6Container"></div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div id="chart7Container"></div>
                </div>
            </div>

            <div class="row">
                <div class="d-flex justify-content-center">
                    <?php
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/TriggerDAO.php");
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

                    $triggerDAO = new TriggerDAO();
                    $userDAO = new UserDAO();
                    $user = $userDAO->getUserFromNickname($_GET["name"]);
                    $triggers = $triggerDAO->getUnusedTriggers($user, time() - 86400 * 14, time());
                    //PRINT THE COURSES
                    echo "<table class='table table-striped table-hover'>";
                    echo "<thead>";
                    echo "<th scope='colgroup'>Unused triggers in the last 2 weeks</th>";
                    echo "</thead>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>Trigger name</th>";
                    echo "<th scope='col'>Trigger description</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td>" . "<strong>BUG!!: </strong>" . "</td>";
                    echo "<td>" . "<strong>Los unused triggers que tienen como userID NULL no salen en esta lista. Es un problema del procedure getUnusedTriggers</strong>" . "</td>";
                    echo "</tr>";
                    foreach ($triggers as $trigger) {
                        echo "<tr>";
                        echo "<td>" . $trigger->getName() . "</td>";
                        echo "<td>" . $trigger->getDescription() . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    ?>
                </div>
            </div>
        </div>

        <div class="mt-5" style="background-color:rgb(252, 252, 248); border: 1px solid rgba(0,0,0,0.125);">
            <div class="row ">
                <div class="d-flex justify-content-center align-items-start">
                    <h1 class="pe-3">Reward analysis
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <p>Todos tus rewards deben de ser <strong>inmediatos</strong> y tener una serie de políticas y
                        procedimientos que eviten que se <strong>corrompan</strong> a lo largo del tiempo </p>
                </div>
            </div>
            <div class="row">
                <div class="d-flex justify-content-center">
                    <?php
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/RewardDAO.php");
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

                    $rewardDAO = new RewardDAO();
                    $userDAO = new UserDAO();
                    $user = $userDAO->getUserFromNickname($_GET["name"]);
                    $rewards = $rewardDAO->getUserRewards($user);
                    //PRINT THE COURSES
                    echo "<table class='table table-striped table-hover'>";
                    echo "<thead>";
                    echo "<th scope='colgroup'>Your rewards</th>";
                    echo "</thead>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>Reward name</th>";
                    echo "<th scope='col'>Reward description</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    foreach ($rewards as $reward) {
                        echo "<tr>";
                        echo "<td>" . $reward->getName() . "</td>";
                        echo "<td>" . $reward->getDescription() . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    ?>
                </div>
            </div>

        </div>
    </div>
    </div>

    </div>


</body>