<?php 
    class ConsistencyObjective{
        private $text;
        private $number;
        
        function __construct($text,$number){
            $this->text = $text;
            $this->number = $number;
        }

        function getText(){
            return $this->text;
        }
        function getNumber(){
            return $this->number;
        }
    }
?>