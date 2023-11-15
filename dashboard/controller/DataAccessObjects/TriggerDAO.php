<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/Trigger.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
class TriggerDAO extends DataAccessObject
{

    function __construct()
    {
        parent::__construct();
    }

    function getUserTriggers($user){
        $this->dbManager->openIfItWasClosed();
        $sql = "select id,name,description from studysessiontrigger where userID=:usuarioID or ISNULL(userID)";
        $resultado = $this->dbManager->query($sql, ["usuarioID"=> $user->getId()]);
        $this->dbManager->close();
        $triggers = [];
        $i = 0;
        foreach ($resultado as $row) {
            $triggers[$i] = new Trigger($row[0],$row[1],$row[2]); 
            $i++;
        }
        return $triggers;
    }

    
}

?>