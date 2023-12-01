<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");
    $dbManager = new DatabaseManager();
    $values = array();
    $result = $dbManager->query("SELECT user100.lastTimeTravelledExceptionActivated FROM `user100` WHERE user100.id=1",$values);
    $dateString = $result[0][0];
    if(strcmp($dateString,date("Y-m-d")) == 0){
        echo "You already travelled to the uib. You can't set it";
    }else{
        $dbManager->query("UPDATE user100 SET lastTimeTravelledExceptionActivated=CURRENT_DATE() where user100.id=1",$values);
        $dbManager->query("UPDATE user100 SET user100.travellingExceptionExpiration= (NOW() + INTERVAL 40 MINUTE) WHERE user100.id=1",$values);
        echo "set both variables";
    }

    echo "If you see no errors everything went okay";

?>