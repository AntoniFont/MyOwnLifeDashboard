<?php include 'header.php'; ?>
<div class="row">
    <div class="col">
        <div class="container">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Selecciona asignatura
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">ADIIU</a></li>
                <li><a class="dropdown-item" href="#">Xarxes</a></li>
                <li><a class="dropdown-item" href="#">Solucions</a></li>
                <li><a class="dropdown-item" href="#">Qualitat</a></li>
                <li><a class="dropdown-item" href="#">GP</a></li>
                <li><a class="dropdown-item" href="#">Concurrent</a></li>
            </ul>
        </div>
    </div>

    <div class="col">
        <div class="container">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Selecciona proyecto
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">No proyecto</a></li>
                <li><a class="dropdown-item" href="#">Placeholder 1</a></li>
                <li><a class="dropdown-item" href="#">Placeholder 2</a></li>
                <li><a class="dropdown-item" href="#">Placeholder 3</a></li>
                <li><a class="dropdown-item" href="#">Placeholder 4</a></li>
                <li><a class="dropdown-item" href="#">Placeholder 5</a></li>
            </ul>
        </div>
    </div>

    <div class="col">
        <div class="container">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Selecciona tipo de trabajo
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item">Estudio</a></li>
                <li><a class="dropdown-item">Repaso</a></li>
                <li><a class="dropdown-item">Ejercicios</a></li>
                <li><a class="dropdown-item">Placeholder 1</a></li>
                <li><a class="dropdown-item">Placeholder 2</a></li>
                <li><a class="dropdown-item">Placeholder 3</a></li>
            </ul>
        </div>
    </div>

</div>
<div class="row">
    <div class="col">
        <div class="container">
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

    <div class="col">
        <div class="container">
            <h1 id="timer">00:00:00</h1>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>