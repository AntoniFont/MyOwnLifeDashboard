<?php
include $_SERVER['DOCUMENT_ROOT']."/myownlifedashboard/.classPaths/DatabaseManagerPath.php";
class User
{
    private $username;
    private $id;

    private $dbmanager;

    public function __construct($username)
    {
        $this->username = $username;
        //GET THE USER ID FROM THE NAME
        $this->dbmanager = new DatabaseManager();
        $this->id = $this->dbmanager->query(
            "select id from user100 where nickname= :name",
            ["name" =>$_GET["name"]]
        );
    }

}



?>