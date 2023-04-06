<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/TypeOfStudyData.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");

class TypeOfStudyDataDAO extends DataAccesObject
{
    function __construct()
    {
        parent::__construct();
    }

    public function getTypesOfStudyData()
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "select typeStudyDataID,name,description from typesstudydata100 ";
        $typesStudyDataQuerys = $this->dbManager->query($sql, []);
        $this->dbManager->close();
        $typesStudyData = array();
        $i = 0;
        foreach ($typesStudyDataQuerys as $typeStudyDataQuery) {
            $typesStudyData[$i] = new TypeOfStudyData(
                $typeStudyDataQuery[0],
                $typeStudyDataQuery[1],
                $typeStudyDataQuery[2]
            );
            $i++;
        }
        return $typesStudyData;
    }
}

?>