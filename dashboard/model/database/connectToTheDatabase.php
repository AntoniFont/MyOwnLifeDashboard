<?php
/**
 * This code is kept for legacy reasons. It is not used actively in the project.
 * At the moment(06-April-2023) , the database connection is handled by the DatabaseManager class.
 * This function is mainly used in unused code, such as the keystoneHabits part
 * that i don't want to delete yet.
 */
function connectToTheDatabase()
{
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