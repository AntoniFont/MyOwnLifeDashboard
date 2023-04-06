<?php
//get the data
$typeofStudyDataDAO = new TypeOfStudyDataDAO();
$typeofstudydata = $typeofStudyDataDAO->getTypesOfStudyData();

//the types of study data

foreach($typeofstudydata as $typeStudyData){
    $typeStudyDataDropdown = "<li><a class='dropdown-item' " ;
    $typeStudyDataDropdown .= "onclick=\" typeOfStudyClicked({typeOfStudyID:".$typeStudyData->getId().",typeOfStudyName:'".$typeStudyData->getName()."'}) \" >";
    $typeStudyDataDropdown .= $typeStudyData->getName()."</a></li>";
    echo $typeStudyDataDropdown;
}

?>