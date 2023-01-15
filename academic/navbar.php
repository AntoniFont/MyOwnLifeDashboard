<div class="container-fluid">
<nav class="navbar navbar-expand-sm navbar-dark bg-dark " >
<div class="container-fluid">
<a class="navbar-brand" href="/myownlifedashboard/index.php" id="mainPage">Academic & personal dashboard</a>
  <button class="navbar-toggler bg-dark" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" >
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/myownlifedashboard/academic/mainPage/index.php" id="academicMainPage">Main page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/myownlifedashboard/academic/unplannedActivity/index.php" id="unplannedActivityNavbar">Unplanned Activity</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/myownlifedashboard/academic/addProject/index.php" id="addProjectNavbar">New Project</a>
      </li>

    </ul>
  </div>
  </div>
</nav>
</div>

<script>
    let params = new URLSearchParams(document.location.search);
    let name = params.get("name"); 
    $("#mainPage").attr("href",$("#mainPage").attr("href") + "?name=" + name)
    $("#academicMainPage").attr("href",$("#academicMainPage").attr("href") + "?name=" + name)
    $("#unplannedActivityNavbar").attr("href",$("#unplannedActivityNavbar").attr("href") + "?name=" + name)
    $("#addProjectNavbar").attr("href",$("#addProjectNavbar").attr("href") + "?name=" + name)
</script>