<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/Handler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/Project.php");

class ProjectsHandler extends Handler
{
    function __construct()
    {
        parent::__construct();
    }
    
    function getProjectsFromCourse($course,$user){
        $this->dbManager->openIfItWasClosed();
        $sql = "select projectID,name,description,endDate from projects100 where projects100.courseID=:courseID AND projects100.userID=:id";
        $projectsQuery = $this->dbManager->query($sql, ["courseID" => $course->getId(), "id" => $user->getId()]);
        $this->dbManager->close();
        $projects = array();
        $i = 0;
        foreach ($projectsQuery as $projectQuery) {
            $projects[$i] = new Project($projectQuery[0], $projectQuery[1], $projectQuery[2], $projectQuery[3]);
            $i++;
        }
        return $projects;    
    }

    function getActiveProjectsFromCourse($course, $user)
    {
        $this->dbManager->openIfItWasClosed();
        $sql = "select projectID,name,description,endDate from projects100 where projects100.courseID=:courseID AND projects100.userID=:id AND endDate >= NOW()";
        $projectsQuery = $this->dbManager->query($sql, ["courseID" => $course->getId(), "id" => $user->getId()]);
        $this->dbManager->close();
        $projects = array();
        $i = 0;
        foreach ($projectsQuery as $projectQuery) {
            $projects[$i] = new Project($projectQuery[0], $projectQuery[1], $projectQuery[2], $projectQuery[3]);
            $i++;
        }
        return $projects;
    }

    function getActiveProjectsFromCourseJSON($course, $user)
    {
        //create an array of arrays with the projects
        //project1 = [projectID, name]
        //project2 = [projectID, name]
        //project3 = [projectID, name]
        //result = [project1, project2, project3]
        $projectsObjects = $this->getActiveProjectsFromCourse($course, $user);
        $projectsJSON = array();
        $i = 0;
        foreach ($projectsObjects as $projectObject) {
            $projectsJSON[$i] = array($projectObject->getId(), $projectObject->getName());
            $i++;
        }
        //CONVERT INTO JSON OBJECT AND RETURN IT
        return json_encode($projectsJSON, JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
    }

    function addProject($name,$description,$course,$user,$endDate){
        $this->dbManager->openIfItWasClosed();
        $sql = "INSERT INTO projects100 (name,description,courseID,userID,endDate) VALUES (:name,:description,:courseID,:userID,:endDate)";
        $this->dbManager->query($sql,["name"=>$name,"description"=>$description,"courseID"=>$course->getId(),"userID"=>$user->getId(),"endDate"=>$endDate]);
        $this->dbManager->close();
    }

    function getProjectFromId($id){
        $this->dbManager->openIfItWasClosed();
        $sql = "select projectID,name,description,endDate from projects100 where projectID=:id";
        $projectQuery = $this->dbManager->query($sql, ["id" => $id]);
        $project = new Project($projectQuery[0][0], $projectQuery[0][1], $projectQuery[0][2], $projectQuery[0][3]);
        $this->dbManager->close();
        return $project;
    }

    function editProject($project){
        $this->dbManager->openIfItWasClosed();
        $sql = "UPDATE projects100 SET name=:name,description=:description,endDate=:endDate WHERE projectID=:id";
        $this->dbManager->query($sql, ["name"=>$project->getName(),"description"=>$project->getDescription(),"endDate"=>$project->getEndDate(),"id"=>$project->getId()]);
        $this->dbManager->close();
    }
}

?>