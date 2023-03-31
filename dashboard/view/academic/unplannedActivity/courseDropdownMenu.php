<?php 

//get the data
$userHandler = new UserHandler();
$user = $userHandler->getUserFromNickname($_GET["name"]);
$coursesHandler = new CoursesHandler();
$courses = $coursesHandler->getCoursesFromUser($user);


//the courses
foreach($courses as $course){
    $courseDropdown = "<li><a class='dropdown-item' " ;
    $courseDropdown .= "onclick=\" courseClicked({courseID:".$course->getID().",courseName:'".$course->getName()."'}) \" >";
    $courseDropdown .= $course->getName()."</a></li>";
    echo $courseDropdown;
}


?>

