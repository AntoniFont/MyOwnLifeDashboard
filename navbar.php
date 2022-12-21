<div class="container-fluid">
<nav class="navbar navbar-expand-sm navbar-dark bg-dark " >
<div class="container-fluid">
<a class="navbar-brand" href="">Dashboard academico y personal</a>
  <button class="navbar-toggler bg-dark" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" >
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/myownlifedashboard/mainPage/index.php" id="mainpage">Main page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/myownlifedashboard/unplannedActivity" id="unplannedActivityNavbar">Unplanned Activity</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Example 3</a>
      </li>
    </ul>
  </div>
  </div>
</nav>
</div>

<script>
    let params = new URLSearchParams(document.location.search);
    let name = params.get("name"); 
    $("#mainpage").attr("href",$("#mainpage").attr("href") + "?name=" + name)
    $("#unplannedActivityNavbar").attr("href",$("#unplannedActivityNavbar").attr("href") + "?name=" + name)
</script>