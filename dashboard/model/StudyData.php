<?php 
    class StudyData{
        private $id;
        private $courseID;
        private $initialTime;
        private $duration;
        private $userId;
        private $projectId;

        function __construct(){
            //empty constructor, since i want overloading and php doesn't support it
        }
        function constructorA($id, $courseID, $initialTime, $duration, $userId, $projectId){
            $this->id = $id;
            $this->courseID = $courseID;
            $this->initialTime = $initialTime;
            $this->duration = $duration;
            $this->userId = $userId;
            $this->projectId = $projectId;
        }

        public function getId(){
            return $this->id;
        }
        public function getCourseID(){
            return $this->courseID;
        }
        public function getInitialTime(){
            return $this->initialTime;
        }
        public function getDuration(){
            return $this->duration;
        }

        public function getUserId(){
            return $this->userId;
        }
        public function getProjectId(){
            return $this->projectId;
        }

    }

?>