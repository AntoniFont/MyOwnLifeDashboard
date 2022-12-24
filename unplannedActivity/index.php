<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My own life </title>

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


    <script src="./scripts/otherThingsScript.js"> </script>
    <script src="./scripts/getAndAddDataScript.js"></script>
    <script src="./scripts/timerScript.js"></script>
</head>

<body>

    <?php include '../navbar.php'; ?>
    <div class="container-fluid">
        <div class="row gy-3 justify-content-end align-items-center mt-4">
            <div class="col-sm-6">
                <div class="d-flex justify-content-center">
                    <h1 class="display-1" id="timer">00:00:00</h1>
                </div>
            </div>

            <div class="col-sm-6 mt-1">
                <div class="d-flex justify-content-center justify-content-sm-start sm-6">
                    <button class="btn btn-secondary  text-start dropdown-toggle " type="button"
                        data-bs-toggle="dropdown" id="selectCourseTitle">
                        Selecciona asignatura
                    </button>
                    <ul class="dropdown-menu" id="selectCourse">
                        <li><a class="dropdown-item" onclick="courseClicked(-1)">Undefined</a></li>

                    </ul>
                </div>

                <div class="d-flex justify-content-center justify-content-sm-start sm-6 mt-1">

                    <button class="btn btn-secondary text-start  dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" id="selectProjectTitle">
                        Selecciona un proyecto
                    </button>
                    <ul class="dropdown-menu" id="selectProject">
                        <li><a class="dropdown-item" onclick="projectClicked(-1)">Undefined</a></li>
                    </ul>
                </div>

                <div class="d-flex justify-content-center justify-content-sm-start sm-6 mt-1">

                    <button class="btn btn-secondary text-start  dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" id="selectTypeOfStudyTitle">
                        Selecciona tipo de trabajo
                    </button>
                    <ul class="dropdown-menu" id="selectTypeOfStudy">
                        <li><a class="dropdown-item" onclick="typeOfStudyClicked(-1)">Undefined</a></li>
                    </ul>
                </div>

            </div>

        </div>


        <div class="row mt-3">
            <div class="col">
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" id="timerButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-stopwatch" viewBox="0 0 16 16">
                            <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z"></path>
                            <path
                                d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z">
                            </path>
                        </svg>
                        <p>Start Timer</p>
                    </button>
                </div>

            </div>
        </div>

        <br><br><br><br><br><br>

        <div class="accordion" id="acordeon">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne">
                        FEATURES TO BE FINISHED
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#acordeon">
                    <div class="accordion-body">


                        <div class="row">
                            <div class="col">
                                <h2>FEATURES THAT WORK, BUT SHOULD BE MADE PRETTIER: </h2>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <textarea placeholder="Descripción de la actividad realizada" cols="50" rows="3"
                                    id="description"></textarea>
                            </div>
                        </div>

                        <br>
                        <div class="row mt-3">
                            <div class="col">
                            <span>¿Estaban tus amigos en la misma habitación o sala de chat de voz de discord y os comunicabais? </span>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="question1Yes" value="option1" name="r1">
                                    <label class="form-check-label" for="inlineRadio3">Sí</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="question1No" value="option2" name="r1">
                                    <label class="form-check-label" for="inlineRadio4">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3" id="secondQuestion" style="display:none"> <!-- invisible until question1Yes is clicked -->
                            <div class="col">
                                <span>¿Que hacían tus amigos?</span>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="question2Answer1" value="option3" name="r2">
                                    <label class="form-check-label" for="inlineRadio1">Cada uno con lo suyo o con su parte, con la posibilidad de pedir ayuda o comentar</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="question2Answer2" value="option4" name="r2">
                                    <label class="form-check-label" for="inlineRadio2">Trabajabamos juntos en una misma tarea </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>