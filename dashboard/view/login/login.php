<?php
session_start();
if (isset($_SESSION["loggedIn"])) {
    header("Location: ../index.php");
} 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduce la clave</title>
</head>

<body>
    <h1>Introduce la clave de entrada</h1>
    <form action="loginBackend.php" method="post">
        <input type="text" name="username" placeholder = "Introduce tu username"></input>
        <br>
        <input type="password" name="key" placeholder="Introduce la clave de entrada"></input>
        <br>
        <input type="submit"></input>
    </form>

</body>

</html>