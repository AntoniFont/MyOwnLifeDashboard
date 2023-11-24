<?php
function includeTriggerButtonContent($buttonID)
{
    //get the data
    $UserDAO = new UserDAO();
    $user = $UserDAO->getUserFromNickname($_GET["name"]);
    $triggerDAO = new TriggerDAO();
    $triggers = $triggerDAO->getUserTriggers($user);


    //the triggers
    foreach ($triggers as $trigger) {
        $id = str_replace(array("\r", "\n"), '', $trigger->getId());
        $name = str_replace(array("\r", "\n"), '', $trigger->getName());
        $description = str_replace(array("\r", "\n"), '', $trigger->getDescription());
        $triggerDropdown = "<li><a class='dropdown-item' ";
        $triggerDropdown .= "onclick=\" triggerClicked({";
        $triggerDropdown .= "triggerID:'" . $id;
        $triggerDropdown .= "',triggerName:'" . $name;
        $triggerDropdown .= "',triggerButtonID:'" . $buttonID;
        $triggerDropdown .= "',triggerDescription:'" . $description . "'}) \" >";
        $triggerDropdown .= $trigger->getName() . "</a></li>";
        echo $triggerDropdown;
    }
}

?>