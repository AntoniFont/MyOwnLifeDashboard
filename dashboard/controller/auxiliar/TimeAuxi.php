<?php 
class TimeAuxi{

    public static function getYear ($timestamp){
        return (int) date("Y", $timestamp);
    }
    public static function getWeekNumber($timestamp){
       return (int) date("W", $timestamp);   
    }


    /*In almost all instances, the previous week week number will be the 
    current week number-1, but on the first day of the year...*/
    public static function getPreviousWeekNumber($weekNumber, $year){
        if($weekNumber == 1){
            return 52;
        }else{
            return $weekNumber-1;
        }
    }

    /*In almost all instances, the previousWeek year will be the 
    current year, but on the first week of the year...*/

    public static function getPreviousWeekYear($weekNumber, $year){
        if($weekNumber == 1){
            return $year-1;
        }else{
            return $year;
        }
    }

    public static function getWeekFirstSecond($weekNumber, $year){
        $firstDayOfYear = strtotime("{$year}-01-01"); // get timestamp of the first day of the year
        $daysToAdd = ($weekNumber - 1) * 7; // calculate number of days to add to get to the first day of the week
        $timestamp = strtotime("+{$daysToAdd} day", $firstDayOfYear); // add days to first day of year timestamp to get to the first day of the week
        return $timestamp; // return timestamp of the first second of the week
    }

    public static function  getWeekLastSecond($weekNumber, $year){
        $firstDayOfYear = strtotime("{$year}-01-01"); // get timestamp of the first day of the year
        $daysToAdd = ($weekNumber - 1) * 7; // calculate number of days to add to get to the first day of the week
        $timestamp = strtotime("+{$daysToAdd} day", $firstDayOfYear); // add days to first day of year timestamp to get to the first day of the week
        $lastSecondOfWeek = strtotime("+1 week -1 second", $timestamp); // add one week and subtract one second to get to the last second of the week
        return $lastSecondOfWeek; // return timestamp of the last second of the week
    }
}

?>