<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/ConsistencyObjective.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ObjectiveDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
$objectiveDAO = new ObjectiveDAO();
$objective = new ConsistencyObjective($_GET["html"], $_GET["number"]);
$userDAO = new UserDAO();
$user = $userDAO->getUserFromNickname($_GET["username"]);
$objectiveDAO->newConsistencyObjective($objective, $user);
echo "If you don't see any errors, everything went correctly";
?>