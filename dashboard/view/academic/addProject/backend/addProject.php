<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ProjectsDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");
$ProjectsDAO = new ProjectsDAO();
$ProjectsDAO->addProject(
    $_GET["projectName"],
    $_GET["description"], 
    (new CoursesDAO())->getCourseFromId($_GET["course"]) , 
    (new UserDAO())->getUserFromNickname($_GET["username"]),
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

<p>If you don't see any errors, you can close this page </p>
