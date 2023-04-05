<?php 
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/ProjectsHandler.php");
$courseId = $_GET["course"];
$projectId = $_GET["project"];
$name = $_GET["name"];
$description = $_GET["description"];
$endDate = $_GET["endDate"];
$project = new Project($projectId, $name, $description, $endDate);

$projectsHandler = new ProjectsHandler();
$projectsHandler->editProject($project);

?>
<p>If you don't see any error, the following data was added correctly to the database:</p>

<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>

<table>
    <tr>
        <th>Attribute</th>
        <th>Value</th>
    </tr>
    <tr>
        <td>Project Name</td>
        <td><?php echo $_GET["name"]?></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><?php echo $_GET["description"]?></td>
    </tr>
    <tr>
        <td>End date</td>
        <td><?php echo $_GET["endDate"]?></td>
    </tr>
</table>

<p>Click <a href='../index.php?name=<?php echo $_GET["username"]?>'>here</a> to go back to the previous page.</p>

