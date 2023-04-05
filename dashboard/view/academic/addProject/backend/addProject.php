<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/ProjectsHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/CoursesHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/UserHandler.php");
$projectsHandler = new ProjectsHandler();
$projectsHandler->addProject(
    $_GET["projectName"],
    $_GET["description"], 
    (new CoursesHandler())->getCourseFromId($_GET["course"]) , 
    (new UserHandler())->getUserFromNickname($_GET["username"]),
    $_GET["endDate"]
);

echo "<p>If you don't see any error, the following data was added correctly to the database:</p>";
?>

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
        <td><?php echo $_GET["projectName"]?></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><?php echo $_GET["description"]?></td>
    </tr>
    <tr>
        <td>Course</td>
        <td><?php echo $_GET["course"]?></td>
    </tr>
    <tr>
        <td>Username</td>
        <td><?php echo $_GET["username"]?></td>
    </tr>
    <tr>
        <td>End date</td>
        <td><?php echo $_GET["endDate"]?></td>
    </tr>
</table>

<p>Click <a href="../index.php?name=<?php echo $_GET["username"]?>">here</a> to go back to the previous page.</p>
