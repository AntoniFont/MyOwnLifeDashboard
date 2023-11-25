<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/DataAccessObject.php");
class UserDAO extends DataAccessObject
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
        return new User($userID[0][0], $userID[0][1],$userID[0][2],$userID[0][3]);
    }

    public function setCurrentlyStudying($nickname,$currentlyStudying){
        $user = $this->getUserFromNickname($nickname);
        $this->dbManager->openIfItWasClosed();
        $sql = "update user100 set user100.isCurrentlyStudying=:currently where user100.id=:userID";
        $this->dbManager->query($sql,["currently" => $currentlyStudying,"userID"=>$user->getId()]);
        $this->dbManager->close();
    }

    public function getCurrentlyStudying($nickname){
        $user = $this->getUserFromNickname($nickname);
        $this->dbManager->openIfItWasClosed();
        $sql = "select user100.isCurrentlyStudying from user100 where user100.id=:userID";
        $res = $this->dbManager->query($sql,["userID"=>$user->getId()]);
        $this->dbManager->close();
        return $res[0][0];
    }


}

?>