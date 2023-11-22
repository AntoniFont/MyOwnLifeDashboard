<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
$DAYS_DISPLAYED = 14;
$userDAO = new UserDAO();
$user = $userDAO->getUserFromNickname($_GET["name"]);
$dbManager = new DatabaseManager();
//Get the studydatabreakdown by trigger
$sql = "call studydatasumdurationbytrigger(:userID,:initialTime,:finalTime)";
$finalTime = time();
$initialTime = $finalTime - $DAYS_DISPLAYED * 60 * 60 * 24;
$resultsFirstQuery = $dbManager->query($sql,["userID"=>$user->getId(),"initialTime" => $initialTime, "finalTime" => $finalTime]);
$finalResultsByTrigger = array();
$finalResultsByStudyCharacteristics = array();
foreach ($resultsFirstQuery as $row){
    $triggerID = $row[0];
    $triggerName = $row[1];
    $triggerDescription = $row[2];
    $triggerDuration = floatval($row[3]);
    array_push($finalResultsByTrigger,array(
        "name" => $triggerName,
        "description" => $triggerDescription,
        "y" => $triggerDuration,
    ));
}
echo json_encode(array($finalResultsByTrigger),JSON_UNESCAPED_UNICODE)
?>