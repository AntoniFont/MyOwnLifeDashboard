<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/ConsistencyObjective.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
class ObjectiveDAO extends DataAccessObject
{

    function __construct()
    {
        parent::__construct();
    }
    function getCurrentConsistencyObjective($user){
        $this->dbManager->openIfItWasClosed();
        $sql = "select texto,number from consistencygoal where user=:idUser order by startDate DESC LIMIT 1";
        $resultado = $this->dbManager->query($sql, ["idUser" => $user->getId()]);
        $this->dbManager->close();
        return new ConsistencyObjective($resultado[0][0],$resultado[0][1]);
    }

    function newConsistencyObjective($objective,$user){
        $this->dbManager->openIfItWasClosed();
        $sql = "insert into consistencygoal set texto= :html , number= :numero, user=:usuario";
        $resultado = $this->dbManager->query($sql, ["html" => $objective->getText(),"numero"=> $objective->getNumber(),"usuario"=>$user->getId()]);
        $this->dbManager->close();
    }

    
}

?>