<?php 
  $name = $_GET["name"];

  $unplannedActivityText = "";
  $mainPageText = "";
  $addProjectText = "";
  if($_SESSION["current_page"] == "Unplanned Activity"){
    $unplannedActivityText = "(current)";
  }elseif($_SESSION["current_page"] == "Main page"){
    $mainPageText = "(current)";
  }elseif($_SESSION["current_page"] == "Add project"){
    $addProjectText = "(current)";
  }

?>

<div class="container-fluid">
<nav class="navbar navbar-expand-sm navbar-dark bg-dark " >
<div class="container-fluid">
<a class="navbar-brand" 
href="<?php echo '/myownlifedashboard/dashboard/view/index.php?name='.$name?>"
id="mainPage">
Academic & personal dashboard
</a>
  <button class="navbar-toggler bg-dark" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" >
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" 
        href="<?php echo '/myownlifedashboard/dashboard/view/academic/mainPage/index.php?name='.$name?>" 
        id="academicMainPage">
        Main page <?php echo $mainPageText?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" 
        href="<?php echo '/myownlifedashboard/dashboard/view/academic/unplannedActivity/index.php?name='.$name?>" 
        id="unplannedActivityNavbar">
        Unplanned Activity <?php echo $unplannedActivityText?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" 
        href="<?php echo '/myownlifedashboard/dashboard/view/academic/addProject/index.php?name='.$name?>" 
        id="addProjectNavbar">
        New Project <?php echo $addProjectText?>
       </a>
      </li>

    </ul>
  </div>
  </div>
</nav>
</div>
