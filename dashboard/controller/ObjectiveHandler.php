<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/DatabaseManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/Objective.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/Handler.php");
class ObjectiveHandler extends Handler
{

    function __construct()
    {
        parent::__construct();
    }

    function getCurrentBalanceObjective($user)
    {
        //DO THE QUERY TO GET THE TEXT
        $sql = "select objectiveText from goal where user=:idUser and type=:goalType order by startDate DESC LIMIT 1";
        $resultado = $this->dbManager->query($sql, ["idUser" => $user->getId(), "goalType" => 1]);
        $this->dbManager->close();
        return new Objective($resultado[0][0]);
    }
}

?>