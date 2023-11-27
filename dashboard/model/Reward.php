<?php

class Reward{

    private $id;
    private $name;

    private $htmlDescription;

    private $userID;

    function __construct($id,$name,$htmlDescription,$userID){
        $this->id = $id;
        $this->name = $name;
        $this->htmlDescription = $htmlDescription;
        $this->userID = $userID;
    }

    function getName(){
        return $this->name;
    }

    function getDescription(){
        return $this->htmlDescription;
    }

}


?>