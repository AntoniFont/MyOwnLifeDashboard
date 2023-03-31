<?php
session_start();

if($_POST["key"] == "1"){
    $_SESSION["loggedIn"] = true;
    echo "<p>Correcto! </p>";
    echo "<a href=\"../index.php?name=".$_POST["username"]."\"><p>Volver a la página principal</p></a>";
} else {
    echo "<p>Incorrecto! </p>";
    echo "<a href=\"./login.php\"><p>Volver a intentar</p></a>";
}
?>