<?php
session_start();
if (!isset($_SESSION["loggedIn"])) {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/myownlifedashboard" . "/login/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

    <script src="./scripts/otherThingsScript.js"></script>
    <script src="./scripts/mainScript.js"></script>
</head>

<body>
    <?php include '../navbar.php'; ?>

    <div class="container">
        <form action="./backend/addCourse.php" method="get">
            <div class="row mt-3">
                <input type="text" name="username" class="form-control" placeholder="Pon tu username"></textarea>
            </div>
            <div class="row mt-3">
                <label for="course">Choose a course:</label>
                <select id="selectCourse" name="course" class="form-control">
                    <!---- TO BE FILLED WITH DATA--->
                </select>
            </div>
            <div class="row mt-3">
                <input type="text" name="projectName" class="form-control" placeholder="Introduce the name of the project"></textarea>
            </div>
            <div class="row mt-3">
                <textarea name="description" class="form-control">Introduce una description</textarea>
            </div>
            <div class="row mt-3">
                <button class="" type="submit">Enviar</button>
            </div>
        </form>
    </div>


</body>

</html>