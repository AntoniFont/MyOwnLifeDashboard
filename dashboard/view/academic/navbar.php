<?php
$name = $_GET["name"];

$unplannedActivityText = "";
$overviewText = "";
$addProjectText = "";
$editProjectText = "";
$projectText = "";
$StudyTimeCategorizerText = "";
$detailsText = "";
$editGoalText = "";
if ($_SESSION["current_page"] == "Unplanned Activity") {
  $unplannedActivityText = "(current)";
} elseif ($_SESSION["current_page"] == "Overview") {
  $overviewText = "(current)";
} elseif ($_SESSION["current_page"] == "Time Categorizer") {
  $StudyTimeCategorizerText = "(current)";
} elseif ($_SESSION["current_page"] == "Add project") {
  $addProjectText = "(current)";
} else if ($_SESSION["current_page"] == "Edit project") {
  $editProjectText = "(current)";
} else if ($_SESSION["current_page"] == "Details") {
  $detailsText = "(current)";
}else if ($_SESSION["current_page"] == "Edit goal") {
  $editGoalText = "(current)";
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
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/overview/index.php?name=' . $name ?>"
              id="unplannedActivityNavbar">
              Overview <?php echo $overviewText ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link"
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/details/index.php?name=' . $name ?>"
              id="academicMainPage">
              Details <?php echo $detailsText ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link"
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/unplannedActivity/index.php?name=' . $name ?>"
              id="unplannedActivityNavbar">
              Unplanned Activity <?php echo $unplannedActivityText ?>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link"
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/timeCategorizer/index.php?name=' . $name ?>">
              Time Categorizer <?php echo $StudyTimeCategorizerText ?>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link"
              href="<?php echo '/myownlifedashboard/dashboard/view/academic/editGoal/index.php?name=' . $name ?>">
              Edit goal <?php echo $editGoalText ?>
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
        </ul>
      </div>
    </div>
  </nav>
</div>