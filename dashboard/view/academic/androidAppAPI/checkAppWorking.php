<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");
$name = $_GET['name'];
$currentDateTime = date("Y-m-d H:i:s");
//Too lazy to do a class for this
$dbManager = new DatabaseManager();
$sql = "INSERT INTO androidAppChecks (name, date) VALUES (:namee, :datee)";
$values = array('namee' => $name, 'datee' => $currentDateTime);
$dbManager->query($sql, $values);
$dbManager->close();
echo "yes";
?>