<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/StudyCharacteristics.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
class StudyCharacteristicsDAO extends DataAccessObject
{

    function __construct()
    {
        parent::__construct();
    }

    function getUserStudyCharacteristics($user){
        $this->dbManager->openIfItWasClosed();
        $sql = "select id,name,description from studydatacharacteristics where userID=:usuarioID or ISNULL(userID)";
        $resultado = $this->dbManager->query($sql, ["usuarioID"=> $user->getId()]);
        $this->dbManager->close();
        $studyCharacteristics = [];
        $i = 0;
        foreach ($resultado as $row) {
            $studyCharacteristics[$i] = new StudyCharacteristics($row[0],$row[1],$row[2]); 
            $i++;
        }
        return $studyCharacteristics;
    }

    
}

?>