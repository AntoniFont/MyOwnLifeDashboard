<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/loginLogic.php");
$_SESSION["current_page"] = "New Objective";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New objective</title>

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
    <div class="container">
        <div class="row mt-3 ">
            <form target="_blank" action="./backend/addObjective.php">
            <input type="text" name="username" class="form-control" value="<?php echo $_GET['name'] ?>" hidden>
                <label for="number">(% of baseline):</label>
                <input type="number" id="number" name="number" class="form-control" max="100" min="0" value="50">
                <label for="html">Html text:</label>
                <textarea type="text" class="form-control" rows="4" cols="4" name="html" id="html"></textarea>
                <label for="preview">Preview:</label>
                <div name="preview" id="preview"
                    style="background-color:rgb(252, 252, 248); border: 1px solid rgba(0,0,0,0.125);"><br><br><br>
                </div>
                <input type="submit" class="btn btn-primary"></input>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            console.log("redy");
            $("#html").on('input', function () {
                $("#preview").html($("#html").val())
            });
        });


    </script>

</body>