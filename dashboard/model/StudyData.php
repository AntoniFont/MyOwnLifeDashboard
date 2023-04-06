<?php 
    class StudyData{
        private $id;
        private $courseID;
        private $initialTime;
        private $duration;
        private $userId;

        function __construct(){
            //empty constructor, since i want overloading and php doesn't support it
        }
        function constructorA($id, $courseID, $initialTime, $duration, $userId){
            $this->id = $id;
            $this->courseID = $courseID;
            $this->initialTime = $initialTime;
            $this->duration = $duration;
            $this->userId = $userId;
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

    }

?>