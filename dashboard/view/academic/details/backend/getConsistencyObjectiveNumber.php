<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ObjectiveDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$ObjectiveDAO = new ObjectiveDAO();
$user = (new UserDAO())->getUserFromNickname($_GET["name"]);
echo json_encode(($ObjectiveDAO->getCurrentConsistencyObjective($user))->getNumber());
?>