<?php
function connectToTheDatabase(){
    $conection = mysqli_connect("localhost", "root", "");
    $conection->set_charset("utf8");
    if (!$conection) {
        echo "<p>Could'nt connect</p>";
        die("Couldn't connect");
    }
    mysqli_select_db($conection, "myowndashboard");
    return $conection;
}
?>