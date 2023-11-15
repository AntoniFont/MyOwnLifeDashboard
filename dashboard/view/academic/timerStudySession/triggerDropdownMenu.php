<?php 

//get the data
$UserDAO = new UserDAO();
$user = $UserDAO->getUserFromNickname($_GET["name"]);
$triggerDAO = new TriggerDAO();
$triggers = $triggerDAO->getUserTriggers($user);


//the triggers
foreach($triggers as $trigger){
    $triggerDropdown = "<li><a class='dropdown-item' " ;
    $triggerDropdown .= "onclick=\" triggerClicked({triggerID:".$trigger->getId().",triggerName:'".$trigger->getName()."'}) \" >";
    $triggerDropdown .= $trigger->getName()."</a></li>";
    echo $triggerDropdown;
}


?>

