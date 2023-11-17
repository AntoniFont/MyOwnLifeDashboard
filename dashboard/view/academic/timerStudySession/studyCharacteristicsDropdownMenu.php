<?php 

//get the data
$UserDAO = new UserDAO();
$user = $UserDAO->getUserFromNickname($_GET["name"]);
$studyCharacteristicsDAO = new StudyCharacteristicsDAO;
$studyCharacteristics = $studyCharacteristicsDAO->getUserStudyCharacteristics($user);


//the triggers
foreach($studyCharacteristics as $studyCharacteristic){
    $id = str_replace(array("\r", "\n"), '', $studyCharacteristic->getId());
    $name = str_replace(array("\r", "\n"), '', $studyCharacteristic->getName());
    $description = str_replace(array("\r", "\n"), '', $studyCharacteristic->getDescription());
    $studyCharacteristicDropdown = "<li><a class='dropdown-item' " ;
    $studyCharacteristicDropdown .= "onclick=\" studyCharacteristicsClicked({";
    $studyCharacteristicDropdown .= "studyCharacteristicsID:'".$id;
    $studyCharacteristicDropdown .= "',studyCharacteristicsName:'".$name;
    $studyCharacteristicDropdown .= "',studyCharacteristicsDescription:'".$description."'}) \" >";
    $studyCharacteristicDropdown .= $studyCharacteristic->getName()."</a></li>";
    echo $studyCharacteristicDropdown;
}


?>

