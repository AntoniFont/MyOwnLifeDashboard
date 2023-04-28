<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/loginLogic.php");
$_SESSION["current_page"] = "Edit project";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit project</title>
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
    <div class="container">
        <form target="_blank" action="./backend/editProject.php" method="get">
            <input type="hidden" name="username" value="<?php echo $_GET["name"] ?>">
            <div class="row mt-3" id="selectCourseDiv">
                <label for="course">Choose a course:</label>
                <select id="selectCourse" name="course" class="form-control">
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
            <div class="row mt-3" id="selectProjectDiv">
                <label for="project">Choose a project:</label>
                <select id="selectProject" name="project" class="form-control">
                </select>
            </div>
            <div id="selectProjectDataDiv">
            </div>
        </form>
    </div>
    </div>
</body>