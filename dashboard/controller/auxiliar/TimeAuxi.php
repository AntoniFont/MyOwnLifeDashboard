<?php 
class TimeAuxi{

    public static function getYear ($timestamp){
        return (int) date("Y", $timestamp);
    }
    public static function getWeekNumber($timestamp){
       return (int) date("W", $timestamp);   
    }
}

?>