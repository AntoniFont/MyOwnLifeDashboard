<?php
class Project
{
    private $id;
    private $name;
    private $description;

    private $endDate;
    function __construct($id, $name, $description, $endDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->endDate = $endDate;
    }
    
    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getEndDate()
    {
        return $this->endDate;
    }

}
?>