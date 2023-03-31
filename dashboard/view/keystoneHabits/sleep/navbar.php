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
        <a class="nav-link" href="/myownlifedashboard/keystoneHabits/sleep/mainPage/index.php" id="sleepMainPage">Main page</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/myownlifedashboard/keystoneHabits/sleep/addSleepEvent/index.php" id="addSleepEventNavbar">Add sleep event</a>
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
    $("#sleepMainPage").attr("href",$("#sleepMainPage").attr("href") + "?name=" + name)
    $("#addSleepEventNavbar").attr("href",$("#addSleepEventNavbar").attr("href") + "?name=" + name)
</script>