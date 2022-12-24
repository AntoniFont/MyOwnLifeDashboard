<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>

	<!---INCLUDE JQUERY--->
	<script src="https://code.jquery.com/jquery-3.6.1.js"
		integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

	<!---INCLUDE BOOTSTRAP-->
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
		crossorigin="anonymous"></script>

	<!--- INCLUDE HIGHCHARTS-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.3.2/highcharts.js"
		integrity="sha512-JVzXlL1mZb/G0YNUJtPqUzA/QtPMQLNpCtEBOV9R8P3Uskp4W0C+6SVZ3rpwnKcp/V/59YQoGNUYmB/N6do1sA=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>

<body>
	<?php include 'navbar.php'; ?>
	<div class="container mt-2">
		<div class="row">
			<div id="welcome" class="display-1 text-center text-primary">Welcome, </div>
		</div>

		<div class="row mt-5">
			<div class="col-sm-6">
				<div class="row">
					<a id="academicLink" href="./academic/mainPage/index.php">
						<div class="d-flex justify-content-center">
							<img src="./compute250x360.png">
						</div>
					</a>
				</div>
				<div class="row">
					<div class="d-flex justify-content-center">
						<div class="display-4 mt-2 text-center">Academic</div></a>
					</div>
				</div>

				<div class="row">
					<div class="d-flex justify-content-center mt-2">
						<p align="center">Computing engineering degree at the University of the Balearic Islands.
						</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<a id="keystoneHabitsLink" href="./keystoneHabits/mainPage/index.php">
						<div class="d-flex justify-content-center">
							<img src="./sport250x250.jpg">
						</div>
					</a>
				</div>
				<div class="row">
					<div class="d-flex justify-content-center">
						<div class="display-4 mt-2 text-center">Keystone habits</div>
					</div>
				</div>
				<div class="row">
					<div class="d-flex justify-content-center mt-2">
						<p align="center">The habits that allow you to better perform at all the others areas of your
							life: exercise, good sleep, etc.</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-3">
			<div class="display-6 mb-3 text-center">Your notifications</div>
			<div class="alert alert-success alert-dismissible" role="alert">
				A success notification! (WIP)
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<div class="alert alert-danger alert-dismissible" role="alert">
				A danger notification! (WIP)
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<div class="alert alert-warning alert-dismissible" role="alert">
				A warning notification! (WIP)
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<div class="alert alert-info alert-dismissible" role="alert">
				A info notification! (WIP)
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		</div>

	</div>
	</div>



</body>

<script>
	let params = new URLSearchParams(document.location.search);
	let name = params.get("name");
	$("#academicLink").attr("href", $("#academicLink").attr("href") + "?name=" + name)
	$("#keystoneHabitsLink").attr("href", $("#keystoneHabitsLink").attr("href") + "?name=" + name)
	$("#welcome").text($("#welcome").text() + name + "!")
</script>

</html>