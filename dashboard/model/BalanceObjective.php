<?php 
    class BalanceObjective{
        private $text;
        
        function __construct($text){
            $this->text = $text;
        }

        function getText(){
            return $this->text;
        }
    }
?>