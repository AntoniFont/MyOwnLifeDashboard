<?php 
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
    $studyDataDAO = new StudyDataDAO();
    $course = $_GET["course"];
    $project = $_GET["project"];
    $typeOfStudy = $_GET["typeOfStudy"];
    $date = $_GET["date"];
    $time = $_GET["time"];
    $duration = $_GET["duration"];
    $description = $_GET["description"];
    $username = $_GET["username"];

    //transform the date and time into local time
    $date = date("Y-m-d", strtotime($date));
    $time = date("H:i", strtotime($time));
    $dateTime = $date . " " . $time;
    $dateTime = date("Y-m-d H:i", strtotime($dateTime));
    //transform the datetime into unix timestamp
    $dateTime = strtotime($dateTime);

    $studyDataDAO->insertStudyDataFromForm($course,$typeOfStudy,$project,$description,$duration,$username,$dateTime);
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
        <td>Course</td>
        <td><?php echo $course?></td>
    </tr>
    <tr>
        <td>Project</td>
        <td><?php echo $project?></td>
    </tr>
    <tr>
        <td>Type of study</td>
        <td><?php echo $typeOfStudy?></td>
    </tr>
    <tr>
        <td>Date</td>
        <td><?php echo $date?></td>
    </tr>
    <tr>
        <td>Time</td>
        <td><?php echo $time?></td>
    </tr>
    <tr>
        <td>Duration</td>
        <td><?php echo $duration?></td>
    </tr>
    <tr>
        <td>Description</td>
        <td><?php echo $description?></td>
    </tr>
    <tr>
        <td>Username</td>
        <td><?php echo $username?></td>
    </tr>
</table>

<p>If you don't see any errors, you can close this page </p>