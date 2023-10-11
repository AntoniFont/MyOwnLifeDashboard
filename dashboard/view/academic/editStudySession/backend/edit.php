<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/StudyData.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
    
    $userID = (new UserDAO())->getUserFromNickname($_GET["name"]);
    $studyData = new StudyData();
    $studyData->constructorA($_GET["id"],$_GET["course"],0,0,$userID,$_GET["project"]);
    echo "datos recibidos:";
    var_dump($_GET);
?>
