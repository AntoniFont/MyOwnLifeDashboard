<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");
class DataAccesObject
{
    protected $dbManager;

    function __construct()
    {
        $this->dbManager = new DatabaseManager();
    }

}

?>