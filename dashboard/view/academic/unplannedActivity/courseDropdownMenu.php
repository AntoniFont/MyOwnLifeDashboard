<?php 

//get the data
$UserDAO = new UserDAO();
$user = $UserDAO->getUserFromNickname($_GET["name"]);
$CoursesDAO = new CoursesDAO();
$courses = $CoursesDAO->getCoursesFromUser($user);


//the courses
foreach($courses as $course){
    $courseDropdown = "<li><a class='dropdown-item' " ;
    $courseDropdown .= "onclick=\" courseClicked({courseID:".$course->getID().",courseName:'".$course->getName()."'}) \" >";
    $courseDropdown .= $course->getName()."</a></li>";
    echo $courseDropdown;
}


?>

