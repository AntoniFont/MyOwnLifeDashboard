<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
$username = $_GET['username'];

$userDao = (new UserDAO());
$baseline = $userDao->getBaseline($username);
echo $baseline;
?>