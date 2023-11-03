<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/ConsistencyObjective.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/BalanceObjective.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
class ObjectiveDAO extends DataAccessObject
{

    function __construct()
    {
        parent::__construct();
    }

    function getCurrentBalanceObjective($user)
    {
        $this->dbManager->openIfItWasClosed();
        //DO THE QUERY TO GET THE TEXT
        $sql = "select objectiveText from balancegoal where user=:idUser order by startDate DESC LIMIT 1";
        $resultado = $this->dbManager->query($sql, ["idUser" => $user->getId()]);
        $this->dbManager->close();
        return new BalanceObjective($resultado[0][0]);
    }

    function addNewCurrentBalanceObjective($user,$objectiveText){
        $this->dbManager->openIfItWasClosed();
        //DO THE QUERY TO GET THE TEXT
        $sql = "insert into balancegoal (user,startDate,objectiveText) values (:idUser,:startDate,:objectiveText)";
        $resultado = $this->dbManager->query($sql, ["idUser" => $user->getId(),"startDate"=>time(),"objectiveText"=>$objectiveText]);
        $this->dbManager->close();
    }

    function getCurrentConsistencyObjective($user){
        $this->dbManager->openIfItWasClosed();
        $sql = "select texto,number from consistencygoal where user=:idUser order by startDate DESC LIMIT 1";
        $resultado = $this->dbManager->query($sql, ["idUser" => $user->getId()]);
        $this->dbManager->close();
        return new ConsistencyObjective($resultado[0][0],$resultado[0][1]);
    }

    
}

?>