<?php
$name = $_GET["name"];

$timerStudySession = "";
$overviewText = "";
$projectText = "";
$addProjectText = "";
$editProjectText = "";
$studySessionText = "";
$addStudySessionText = "";
$editStudySessionText = "";
$deleteStudySessionText = "";
$StudyTimeCategorizerText = "";
$detailsText = "";
$infoText = "";
$newObjectiveText = "";


if ($_SESSION["current_page"] == "Timer Study Session") {
  $timerStudySession = "(current)";
} elseif ($_SESSION["current_page"] == "Add project") {
  $addProjectText = "(current)";
} else if ($_SESSION["current_page"] == "Edit project") {
  $editProjectText = "(current)";
} else if ($_SESSION["current_page"] == "Details") {
  $detailsText = "(current)";
}else if ($_SESSION["current_page"] == "Info") {
  $infoText = "(current)";
}else if ($_SESSION["current_page"] == "Add Study Session") {
  $addStudySessionText = "(current)";
}else if ($_SESSION["current_page"] == "Edit Study Session") {
  $editStudySessionText = "(current)";
}else if ($_SESSION["current_page"] == "Delete Study Session") {
  $deleteStudySessionText = "(current)";
}else if ($_SESSION["current_page"] == "New Objective") {
  $newObjectiveText = "(current)";
}

if($addStudySessionText != "" || $editStudySessionText != "" || $deleteStudySessionText != ""){
  $studySessionText = "(current)";
}
if ($addProjectText != "" || $editProjectText != "") {
  $projectText = "(current)";
}

?>

<div class="container-fluid">
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark ">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?php echo '/myownlifedashboard/dashboard/view/index.php?name=' . $name ?>"
        id="mainPage">
        Academic & personal dashboard
      </a>
      <button class="navbar-toggler bg-dark" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link"
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/details/index.php?name=' . $name ?>"
              id="academicMainPage">
              Details <?php echo $detailsText ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link"
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/timerStudySession/index.php?name=' . $name ?>"
              id="unplannedActivityNavbar">
              Timer Study Session <?php echo $timerStudySession ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link"
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/info/info.html'?>">
              Info <?php echo $infoText ?>
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Project <?php echo $projectText ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item"
                  href="<?php echo '/myownlifedashboard/dashboard/view/academic/addProject/index.php?name=' . $name ?>">
                  New Project <?php echo $addProjectText ?>
                </a>
              </li>
              <li>
                <a class="dropdown-item"
                  href="<?php echo '/myownlifedashboard/dashboard/view/academic/editProject/index.php?name=' . $name ?>">
                  Edit Project <?php echo $editProjectText ?>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Study Session [NO FUNCIONA] <?php echo $studySessionText; ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item"
                  href="<?php echo '/myownlifedashboard/dashboard/view/academic/addStudySession/index.php?name=' . $name ?>">
                  Add Study Session [NO FUNCIONA] <?php echo $addStudySessionText ?>
                </a>
              </li>
              <li>
                <a class="dropdown-item"
                  href="<?php echo '/myownlifedashboard/dashboard/view/academic/editStudySession/index.php?name=' . $name ?>">
                  Edit Study Session [NO FUNCIONA]<?php echo $editStudySessionText ?>
                </a>
                <a class="dropdown-item"
                  href="<?php echo '/myownlifedashboard/dashboard/view/academic/deleteStudySession/index.php?name=' . $name ?>">
                  Delete Study Session [NO FUNCIONA]<?php echo $deleteStudySessionText ?>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link"
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/newObjective/index.php?name=' . $name ?>"
              >
              New objective <?php echo $newObjectiveText ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>