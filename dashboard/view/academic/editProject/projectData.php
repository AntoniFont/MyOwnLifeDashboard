<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ProjectsDAO.php");
$projectID = $_GET["projectID"];
$project = (new ProjectsDAO())->getProjectFromId($projectID);
$projectName = $project->getName();
$projectDescription = $project->getDescription();
$endDate = $project->getEndDate();

?>
<div class="row mt-3">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" class="form-control" value='<?php echo $projectName ?>'>
</div>
<div class="row mt-3">
    <label for="description">Description:</label>
    <textarea name="description" id="description" class="form-control"
        rows="3"><?php echo $projectDescription ?></textarea>
</div>
<div class="row mt-3">
    <label for="endDate">End Date</label>
    <input type="date" name="endDate" id="endDate" class="form-control" value='<?php echo $endDate ?>'>
</div>
<div class="row mt-3">
    <input type="submit" class="btn btn-primary" onclick="editProject()" value="Edit project"></input>
</div>