<?php 
/*
Lists of steps that this program should take to return the correct data

SELECT ONLY DATA FROM THE LAST 14 DAYS
FIND THE FIRST WAKING UP. STARTING THE DAY!
SEARCH THE GOING TO SLEEP MOMENT, IF IT EXISTS, IF NOT, NULL
BETWEEN THE WAKING UP AND THE GOING TO SLEEP IDENTIFY NAPS

*/

header("Content-Type: text/html;charset=utf-8");
//IMPORT ALL THE AUXILIARY FUNCTIONS
require dirname(__DIR__, 4) . "/connectToTheDatabase.php";
//CONNECT TO THE DB
$conection = connectToTheDatabase();
//GET THE USER ID FROM THE NAME
$query = "select id from user100 where nickname=\"".$_GET["name"]."\"" ;
$idCon = mysqli_query($conection, $query);
$userId = mysqli_fetch_all($idCon)[0][0];
//SELECT ALL THE "FORMALLY STARTING THE DAY MOMENTS FROM THE LAST 14 DAYS"
$query = "SELECT * FROM sleepevent100 WHERE type=9 AND UNIX_TIMESTAMP(datetime) > (UNIX_TIMESTAMP() - 14*24*60*60) AND user=" .  $userId;
$resultsCon = mysqli_query($conection, $query);
$startingTheDayMoments = mysqli_fetch_all($resultsCon);
$days =  [];

for ($i=0; $i < count($startingTheDayMoments) -1 ; $i++) {
        /* 
        input1: A starting moment of a day (let's say 8am 13March)
        input2: The starting moment of the next day (let's say 9am 14 March)

        You know that between those 2 input moments you have pressed the "trying to go to sleep" button
        one or many times, so you search those times. Once you have the times that you tried to go to 
        sleep (let's say 9pm 13march and 10pm 13march) you select the latest by the ORDER BY clause and
        the LIMIT 1 sentence.

        */
        
        $queryPart1 = "SELECT * FROM sleepevent100 WHERE type=3 ";
        $queryPart2 = " AND UNIX_TIMESTAMP(datetime)>".formatDateSQL($startingTheDayMoments[$i][1]);
        $queryPart3 = " AND UNIX_TIMESTAMP(datetime)<=".formatDateSQL($startingTheDayMoments[$i+1][1]);
        $queryPart4 = " ORDER BY UNIX_TIMESTAMP(datetime) DESC LIMIT 1";
        $query = $queryPart1.$queryPart2.$queryPart3.$queryPart4;
        $resultsCon = mysqli_query($conection, $query);
        $endingTheDayMoment = mysqli_fetch_all($resultsCon);
        
        //Now that we have the data,create the object
        $day = new stdClass();
        $day->realWakingUp = $startingTheDayMoments[$i][1];
        $day->lastAttemptGoingToSleep = $endingTheDayMoment[0][1];
    $day->estimatedAwakeTime = strtotime($endingTheDayMoment[0][1]) - strtotime($startingTheDayMoments[$i][1]);
    


        array_push($days, $day);
}

echo json_encode($days);
mysqli_close($conection);

function formatDateSQL($datetimeToFormat){
    return "UNIX_TIMESTAMP(STR_TO_DATE('".$datetimeToFormat."','%Y-%m-%d %H:%i:%s'))";
}

?>