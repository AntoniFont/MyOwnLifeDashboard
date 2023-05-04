<?php
function getCoursesDropdown($user,$activeCourse){
    $string = "";
    try {
        $CoursesDao = new CoursesDAO();
        $courses = $CoursesDao->getCoursesFromUser($user);
        $string .= "<option value='-1'>Undefined</option>";
        foreach ($courses as $course) {
            if($course->getId() == $activeCourse->getId()){
                $string.= "<option value='" . $course->getId() . "' selected>" . $course->getName() . "</option>";
            }else{
                $string.= "<option value='" . $course->getId() . "'>" . $course->getName() . "</option>";
            }
        }
    } catch (Exception $e) {
        $string.="<option value='-1'>Undefined</option>";
    }
    return $string;
}
?>