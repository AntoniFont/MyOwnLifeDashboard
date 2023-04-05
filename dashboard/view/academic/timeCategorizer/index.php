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
    $timeCategorizer = new TimeCategorizer();
    $id = 835;

    echo "<h1> Categorizar el studyData con id: ".$id."</h1>";
    $timeCategorizer->categorize($id);
    ?>
</body>