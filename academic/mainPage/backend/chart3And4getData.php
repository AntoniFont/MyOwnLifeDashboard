<?php
//1. IMPORTS OF FUNCTIONS NEEDED
require dirname(__DIR__, 3)."/connectToTheDatabase.php";
//2. DECLARE CONSTANTS
$DAYS_DISPLAYED = 14; 
//3. CONNECT TO THE DB
$conection = connectToTheDatabase();
///4. DECLARE THE QUERY

/** this query returns the total number of seconds worked in a day in this format:
 *  [["seconds","day in %d-%m-%Y","daysSinceToday"]
 *  A Example that may return:
 *  ["5042","30-12-2022","14"],
 *  ["921","31-12-2022","13"],
 *  ["3600","01-01-2023","12"],
 *  ["4685","02-01-2023","11"], ...
 *
 * Some days might be missing, so later we should process the data to add the missing days as 0 seconds studied
 *  
 */

$query = "";
$query .= "SELECT sum(duration), " ;
$query .= "FROM_UNIXTIME(initialTime, \"%d-%m-%Y\") as dia, " ;
$query .= "FROM_UNIXTIME(UNIX_TIMESTAMP() - UNIX_TIMESTAMP(STR_TO_DATE(FROM_UNIXTIME(initialTime,\"%d-%m-%Y\"),\"%d-%m-%Y\")),\"%d\")  as daysEllapsed ";
$query .= "FROM studydata100 " ;
$query .= "JOIN user100 ON user100.id = studydata100.userID " ;
$query .= "WHERE initialTime > (UNIX_TIMESTAMP() - (".strval($DAYS_DISPLAYED * 86400).")) "; 
$query .= "AND nickname=\"".$_GET["name"]."\" " ;
$query .= "GROUP BY FROM_UNIXTIME(initialTime, \"%d-%m-%Y\") ";
$query .= "ORDER BY initialTime ASC ";

//echo $query;
//5. DO THE QUERY AND CLOSE THE CONECTION TO SAVE CONECTIONS FOR OTHER USERS
$dataCon = mysqli_query($conection, $query);
$resultado = mysqli_fetch_all($dataCon);
mysqli_close($conection);

//6. PROCESSING THE DATA TO ADD THE MISING DAYS AS 0 SECONDS STUDIED
date_default_timezone_set('Europe/Madrid');
$dataProcessed = array();
$today = date('d-m-Y', time());
for ($i=14; $i >= 0 ; $i--) {
    $days_ago = date('d-m-Y', strtotime("-".$i." days", strtotime($today))); //https://stackoverflow.com/questions/2708894/how-to-find-out-what-the-date-was-5-days-ago
    $existsDataOnThisDay = false;
    $data = null;
    foreach ($resultado as $key => $value) {
        if (strcmp($value[1],$days_ago) == 0) { // if ($value[1] == days_ago)
            $existsDataOnThisDay = true;
            $data = $value;
        }
    }
    if ($existsDataOnThisDay == false) {
        $data = array("0", $days_ago, strval($i));
    }
    array_push($dataProcessed,$data);
}

//7. CONVERT INTO JSON OBJECT AND RETURN IT
echo json_encode($dataProcessed,JSON_UNESCAPED_UNICODE); //for the spanish and catalan languages
?>