<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/DatabaseManager.php");
class Handler
{
    protected $dbManager;

    function __construct()
    {
        $this->dbManager = new DatabaseManager();
    }

}

?>