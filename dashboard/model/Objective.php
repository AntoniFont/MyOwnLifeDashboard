<?php 
    class Objective{
        private $text;
        
        function __construct($text){
            $this->text = $text;
        }

        function getText(){
            return $this->text;
        }
    }
?>