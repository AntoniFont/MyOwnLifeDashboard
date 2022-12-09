<?php include 'header.php'; ?>
<div class="container">
    <div class="row justify-content-end gy-6    ">
        <div class="col-xxl-6">
            <div class="d-flex justify-content-center">
                <h1 id="timer">00:00:00</h1>
            </div>
        </div>

        <div class="col-xxl-6">
            <div class="d-flex xxl-6">
                <button class="btn btn-secondary w-100 text-start dropdown-toggle " type="button"
                    data-bs-toggle="dropdown" id="selectCourseTitle">
                    Selecciona asignatura
                </button>
                <ul class="dropdown-menu" id="selectCourse">
                    <li><a class="dropdown-item" onclick="courseClicked(-1)">Undefined</a></li>

                </ul>
            </div>
            <div class="d-flex xxl-6">

                <button class="btn btn-secondary text-start w-100 dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" id="selectTypeOfStudyTitle">
                    Selecciona tipo de trabajo
                </button>
                <ul class="dropdown-menu" id="selectTypeOfStudy">
                    <li><a class="dropdown-item" onclick="typeOfStudyClicked(-1)">Undefined</a></li>
                </ul>
            </div>

            <div class="d-flex xxl-6">

                <button class="btn btn-secondary text-start w-100 dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" id="selectProjectTitle">
                    Selecciona proyecto
                </button>
                <ul class="dropdown-menu" id="selectProject">
                    <li><a class="dropdown-item" onclick="projectClicked(-1)">Undefined</a></li>
                </ul>
            </div>


        </div>

        <div class="col">


        </div>

    </div>
    <div class="row">
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

</div>
<?php include 'footer.php'; ?>