<?php
function getProjectDropdown($course,$user,$activeProjectId){
    $string = "";
    try {
        $ProjectsDAO = new ProjectsDAO();
        $projects = $ProjectsDAO->getActiveProjectsFromCourse($course, $user);
        $string .= "<option value='-1'>Undefined</option>";
        foreach ($projects as $project) {
            if($project->getId() == $activeProjectId){
                $string.= "<option value='" . $project->getId() . "' selected>" . $project->getName() . "</option>";
            }else{
                $string.= "<option value='" . $project->getId() . "'>" . $project->getName() . "</option>";
            }
        }
    } catch (Exception $e) {
        $string.="<option value='-1'>Undefined</option>";
    }
    return $string;
}

?>