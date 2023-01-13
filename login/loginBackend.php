<?php
session_start();

if($_POST["key"] == "1"){
    $_SESSION["loggedIn"] = true;
    echo "<p>Correcto! </p>";
    echo "<a href=\"../index.php\"><p>Volver a la página principal</p></a>";
} else {
    echo "<p>Incorrecto! </p>";
    echo "<a href=\"./login.php\"><p>Volver a intentar</p></a>";
}



// I WANT TO REGISTER ALL THE KEYS INTRODUCED TO SEE WHAT HACKERS ARE UP TO
// MAYBE THIS IS ILEGAL IN A REAL SERVER?
// SINCE THE SERVER IS IN A PUBLIC IP I GET CONSTANTLY BOMBARDED WITH 
// HACKBOTS TRYING TO ENCRYPT MY INFO AND SEARCHING VULNERABILITIES

//1. ADD THE NECESSARY IMPORTS 
require "./connectToTheDatabase.php";
//2. CONNECT TO THE DB
$conection = connectToTheDatabase();
///3. INSERT DATA QUERY 
$stmt = $conection->prepare("INSERT INTO loginAttempts (datetime,text) VALUES ?,?"); ;
$stmt->bind_param("ss",$now,$key);
$now = date("d-m-Y H:i:s");
$key = $_POST["key"];
$stmt->execute();
?>