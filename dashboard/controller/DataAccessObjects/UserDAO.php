<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
class UserDAO extends DataAccesObject
{
    function __construct()
    {
        parent::__construct();
    }

    public function getUserFromNickname($nickname)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "select * from user100 where nickname=:nickname";
        $userID = $this->dbManager->query($sql, ["nickname" => $nickname]);
        $this->dbManager->close();
        return new User($userID[0][0], $userID[0][1]);
    }
}

?>