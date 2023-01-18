<?php
include $_SERVER['DOCUMENT_ROOT'] . "/myownlifedashboard/.classPaths/User.php";
class Student extends User
{

    public function __construct($username)
    {
        parent::__construct($username);
    }


    public function getCurrentCourses()
    {
        $queryString = "select courseID,name from courses100 where userID=:userID";
        $data =  $this->dbmanager->query($queryString,["userID" => $this->id]);
    }

}

?>