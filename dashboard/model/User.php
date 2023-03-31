<?php
class User
{
    private $id;
    private $username;

    function __construct($id, $username)
    {
        $this->id = $id;
        $this->username = $username;
    }

    function getId()
    {
        return $this->id;
    }

    function getUsername()
    {
        return $this->username;
    }

}

?>