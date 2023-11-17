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
        "drilldown" => $triggerName
    ));
    //Get the triggerBreakdownByStudyCharacteristics for this trigger
    $sql = "call triggersumdurationbystudycharacteristic(:userID,:initialTime,:finalTime,:triggerID)";
    $resultsSecondQuery = $dbManager->query($sql,["triggerID"=>$triggerID,"userID"=>$user->getId(),"initialTime" => $initialTime, "finalTime" => $finalTime]);
    $dataStudyCharacteristics = array();
    foreach ($resultsSecondQuery as $roww){
        $studyCharacteristicsName = $roww[1];
        $studyCharacteristicsDescription = $roww[2];
        $studyCharacteristicsDuration = floatval($roww[3]);
        array_push($dataStudyCharacteristics,array($studyCharacteristicsName,$studyCharacteristicsDuration));
    }
    array_push($finalResultsByStudyCharacteristics,array(
        "name" => $triggerName,
        "id" => $triggerName,
        "description" => $studyCharacteristicsDescription,
        "data" => $dataStudyCharacteristics
    ));


}
echo json_encode(array($finalResultsByTrigger,$finalResultsByStudyCharacteristics),JSON_UNESCAPED_UNICODE)
?>