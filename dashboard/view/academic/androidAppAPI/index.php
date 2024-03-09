<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/loginLogic.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/ObjectiveDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/UserDAO.php");

$_SESSION["current_page"] = "Android App Info";
$ObjectiveDAO = new ObjectiveDAO();
$UserDAO = new UserDAO();
$user = $UserDAO->getUserFromNickname($_GET["name"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Android app info</title>

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

</head>

<body>
    <?php include '../navbar.php'; ?>
    <div class="container mt-3">

        <h1>The current time is:
            <?php echo date("Y-m-d H:i:s"); ?>
        </h1>
        <h1>Android app info</h1>
        <p>He creado una aplicacion para movil que bloquea ciertas apps según lo que responda una api de este server.
        </p>
        <p>En general, he puesto que si has estudiado el suficiente tiempo hoy antes de cierta hora, no se bloquea el
            movil.</p>
        <p>De momento, los criterios para bloquear estan hardcodeados en el server, para los 2 usuarios que estamos
            activo en la pagina, yo (toni) y mi amigo sufi.</p>
        <p>Nos hemos puesto autobloqueo (obviamente) y bloqueo cruzado, es decir que si uno no ha estudiado lo
            suficiente
            hoy, se bloquea el movil del otro para mayor presión.</p>
        <p>En el futuro, estos criterios deberian estar en una base de datos, y deberian ser configurables por el
            usuario </p>

        <p>Existen 2 versiones de la app, y cada uno tiene una de ellas instaladas. A mi me bloquea mis apps favoritas
            (instagram)
            y a mi amigo sus apps favoritas (tiktok,videojuegos...) </p>

        <p> Para poder checkear rapidamente los criterios (que suelen ir cambiando de semana a semana) y el estado
            actual, aqui se muestran</p>
        <h1>Datos Toni</h1>
        <?php
        require_once("studyCriteria.php");
        $datosToni = getToniStudyCriteria();
        $studyBaselineByDays = $datosToni->getStudyBaselineByDays();
        ?>
        <!-- CAMPOS:
         <th> La api ha devuelto que se debe bloquear el movil de toni?</th>
                <th> Maximo a estudiar cada dia en minutos</th>
                <th> Hora de corte</th>
                <th> Dia de excepcion</th>
                <th> Bloqueo progresivo</th>
                <th> Media diaria</th>
            -->
        <!-- BOOTSTRAP STYLE TABLE -->
        <table class="table">
            <thead>
                <tr>
                    <th> Campo </th>
                    <th> Valor </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> La api ha devuelto que se debe bloquear el movil de toni?</td>
                    <td>
                        <bold>
                            <?php require_once("shouldBlockThePhoneOfToni.php"); ?>
                        </bold>
                    </td>
                </tr>
                <tr>
                    <td> Dice el server que ha estudiado suficiente en el momento actual?</td>
                    <td>
                        <bold>
                            <?php require_once("shouldBlockAPhoneBackend.php");
                            echo didUserStudyEnoughToday("toni", $datosToni) ? "si" : "no";
                            ?>
                        </bold>
                    </td>
                <tr>
                    <td> Maximo a estudiar cada dia </td>
                    <td>
                        <ul>
                            <li> Domingo:
                                <?php echo $studyBaselineByDays[0]; ?> minutos
                            </li>
                            <li> Lunes:
                                <?php echo $studyBaselineByDays[1]; ?> minutos
                            </li>
                            <li> Martes:
                                <?php echo $studyBaselineByDays[2]; ?> minutos
                            </li>
                            <li> Miercoles:
                                <?php echo $studyBaselineByDays[3]; ?> minutos
                            </li>
                            <li> Jueves:
                                <?php echo $studyBaselineByDays[4]; ?> minutos
                            </li>
                            <li> Viernes:
                                <?php echo $studyBaselineByDays[5]; ?> minutos
                            </li>
                            <li> Sabado:
                                <?php echo $studyBaselineByDays[6]; ?> minutos
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td> Hora maxima a la que se tiene que haber cumplido el objetivo</td>
                    <td>
                        <?php echo $datosToni->getFormattedCotoutMinuteString(); ?>
                    </td>
                </tr>
                <tr>
                    <td> Dia de excepcion</td>
                    <td>
                        <?php echo $datosToni->getExceptionDay(); ?>
                    </td>
                </tr>
                <tr>
                    <td> Bloqueo progresivo</td>
                    <td>
                        <?php echo $datosToni->getProgressiveBlock(); ?>
                    </td>
                </tr>
                <tr>
                    <td> Media diaria esperada</td>
                    <td>
                        <?php echo $datosToni->getAverageDailyBaseline(); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <h1>Datos Sufi</h1>
        <?php
        $datosSufi = getSufiStudyCriteria();
        $studyBaselineByDays = $datosSufi->getStudyBaselineByDays();
        ?>
        <!-- CAMPOS:
         <th> La api ha devuelto que se debe bloquear el movil de toni?</th>
                <th> Maximo a estudiar cada dia en minutos</th>
                <th> Hora de corte</th>
                <th> Dia de excepcion</th>
                <th> Bloqueo progresivo</th>
                <th> Media diaria</th>
            -->
        <!-- BOOTSTRAP STYLE TABLE -->
        <table class="table">
            <thead>
                <tr>
                    <th> Campo </th>
                    <th> Valor </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> La api ha devuelto que se debe bloquear el movil de sufi?</td>
                    <td>
                        <bold>
                            <?php require_once("shouldBlockThePhoneOfSufi.php"); ?>
                        </bold>
                    </td>
                </tr>
                <tr>
                    <td> Dice el server que ha estudiado suficiente en el momento actual?</td>
                    <td>
                        <bold>
                            <?php require_once("shouldBlockAPhoneBackend.php");
                            echo didUserStudyEnoughToday("sufi.mago", $datosSufi) ? "si" : "no";
                            ?>
                        </bold>
                    </td>
                </tr>
                <tr>
                    <td> Maximo a estudiar cada dia </td>
                    <td>
                        <ul>
                            <li> Domingo:
                                <?php echo $studyBaselineByDays[0]; ?> minutos
                            </li>
                            <li> Lunes:
                                <?php echo $studyBaselineByDays[1]; ?> minutos
                            </li>
                            <li> Martes:
                                <?php echo $studyBaselineByDays[2]; ?> minutos
                            </li>
                            <li> Miercoles:
                                <?php echo $studyBaselineByDays[3]; ?> minutos
                            </li>
                            <li> Jueves:
                                <?php echo $studyBaselineByDays[4]; ?> minutos
                            </li>
                            <li> Viernes:
                                <?php echo $studyBaselineByDays[5]; ?> minutos
                            </li>
                            <li> Sabado:
                                <?php echo $studyBaselineByDays[6]; ?> minutos
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td> Hora maxima a la que se tiene que haber cumplido el objetivo</td>
                    <td>
                        <?php echo $datosSufi->getFormattedCotoutMinuteString(); ?>
                    </td>
                </tr>
                <tr>
                    <td> Dia de excepcion</td>
                    <td>
                        <?php echo $datosSufi->getExceptionDay(); ?>
                    </td>
                </tr>
                <tr>
                    <td> Bloqueo progresivo</td>
                    <td>
                        <?php echo $datosSufi->getProgressiveBlock(); ?>
                    </td>
                </tr>
                <tr>
                    <td> Media diaria esperada</td>
                    <td>
                        <?php echo $datosSufi->getAverageDailyBaseline(); ?>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</body>