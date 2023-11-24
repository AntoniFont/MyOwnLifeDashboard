<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/loginLogic.php");
$_SESSION["current_page"] = "Add Study Session";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add study session</title>
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
    <script>
        alert("WIP: ESTO YA NO FUNCIONA, FALTA AÑADIR LO DE LOS TRIGGERS. NO USAR ESTA PAGINA. USAR EL PHPMYADMIN");
    </script>
    <div class="container">
        <form target="_blank" action="./backend/addStudySession.php" method="get">
            <!--invisible username input-->
            <input type="text" name="username" class="form-control" value="<?php echo $_GET['name'] ?>" hidden>
            <div class="row mt-3">
                <label for="selectCourse">Choose a course:</label>
                <select id="selectCourse" name="course" class="form-control">
                    <option value="-1">Undefined</option>
                    <?php
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");


                    $CoursesDAO = new CoursesDAO();
                    $UserDAO = new UserDAO();
                    $courses = $CoursesDAO->getCoursesFromUser($UserDAO->getUserFromNickname($_GET["name"]));

                    foreach ($courses as $course) {
                        echo "<option value='" . $course->getId() . "'>" . $course->getName() . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="row mt-3">
                <label for="selectProject">Choose a project:</label>
                <select id="selectProject" name="project" class="form-control">
                    <option value="-1">Undefined</option>
                </select>

            </div>
            <div class="row mt-3">
                <div class="row">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" class="form-control">
                </div>
                <div class="row mt-3">
                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" class="form-control">
                </div>
                <div class="row mt-3">
                    <label for="duration">Duration (in seconds):</label>
                    <input type="number" id="duration" name="duration" class="form-control" value="0" min="0">
                    <p><span id="hours">0 </span> hours, <span id="minutes">0</span> minutes, <span
                            id="seconds">0</span> seconds</p>
                    <!--To be updated dynamically-->
                </div>
                <div class="row mt-3">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <div class="row mt-3">
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>


</body>