<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/Reward.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/User.php");
class RewardDAO extends DataAccessObject
{

    function __construct()
    {
        parent::__construct();
    }

    function getUserRewards($user){
        $this->dbManager->openIfItWasClosed();
        $sql = "select * from rewards where userID=:usuarioID";
        $resultado = $this->dbManager->query($sql,["usuarioID"=> $user->getId()]);
        $this->dbManager->close();
        $rewards = [];
        foreach($resultado as $row){
            $rewards[] = new Reward($row[0],$row[1],$row[2],$row[3]);
        }
        return $rewards;
    }
    
}

?>