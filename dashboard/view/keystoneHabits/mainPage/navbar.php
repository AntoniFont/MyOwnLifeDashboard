<div class="container-fluid">
<nav class="navbar navbar-expand-sm navbar-dark bg-dark " >
<div class="container-fluid">
<a class="navbar-brand" href="/myownlifedashboard/index.php" id="mainPage">Academic & personal dashboard</a>
</nav>
</div>

<script>
    let params = new URLSearchParams(document.location.search);
    let name = params.get("name"); 
    $("#mainPage").attr("href",$("#mainPage").attr("href") + "?name=" + name)
</script>