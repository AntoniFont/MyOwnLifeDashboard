<?php
require dirname(__DIR__, 2)."/connectToTheDatabase.php";

//CONNECT TO THE DB
$conection = connectToTheDatabase();
///GET THE DATA INTO VARIABLES
//SELECT sum(duration), FROM_UNIXTIME(initialTime, '%W, %d %M %Y') FROM `studydata100` JOIN user100 ON user100.id = studydata100.userID WHERE initialTime > (UNIX_TIMESTAMP() - (60 * 60 *24 * 7 *2)) AND nickname="toniet" GROUP BY FROM_UNIXTIME(initialTime, '%W, %d %M %Y') ORDER BY initialTime ASC
$query = "SELECT sum(duration),FROM_UNIXTIME(initialTime,  \"%d-%m-%Y\") FROM studydata100 JOIN user100 ON user100.id = studydata100.userID WHERE initialTime > (UNIX_TIMESTAMP() - (60 * 60 *24 * 7 *2)) AND nickname=\"".$_GET["name"]."\" GROUP BY FROM_UNIXTIME(initialTime,  \"%d-%m-%Y\") ORDER BY initialTime ASC";
$dataCon = mysqli_query($conection, $query);
$resultado = mysqli_fetch_all($dataCon);
mysqli_close($conection);
//CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($resultado,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>