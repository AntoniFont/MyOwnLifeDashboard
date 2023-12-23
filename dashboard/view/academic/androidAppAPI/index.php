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

        <h1>La hora actual en el servidor es
            <?php echo date("Y-m-d H:i:s"); ?>
        </h1>
        <p>Existe una aplicacion para movil que bloquea ciertas apps según si has completado o no el mínimo diario.</p>
        <p>Si estás estudiando, desbloquea las aplicaciones y una vez cumplas el minimo diario critico bajo unas
            circustancias, las deja desbloqueadas
            el resto del día.
        </p>
        <p>Existen 2 sistemas, que se comportan de manera ligeramente diferente.</p>
        <p>El sistema A esta diseñado para bloquear el Spotify y el B para bloquear el instagram.</p>
        <p>El sistema A bloquea desde el primer momento del día, mientras que el sistema B bloquea a partir de las 16.
        </p>
        <p>En el sistema A realmente no siempre es necesario cumplir el 100% del mínimo diario critico, ya que tener que
            cumplir 1 hora
            a las 22:00 para solo poder disfrutar de 2 horas de ocio no es muy justo. Por eso, la exigencia se equilibra
            en base a lo siguiente:
        </p>
        <ul>
            <li>Hasta las 9, es necesario cumplir el 100% del minimo diario critico para desbloquear las aplicaciones el
                resto del día.</li>
            <li>De 9 a 10h30min, es necesario cumplir el 90% del minimo diario critico para desbloquear las aplicaciones
                el
                resto del día.</li>
            <li>De 10h30min a 12h, es necesario cumplir el 80% del minimo diario critico para desbloquear las
                aplicaciones
                el resto del día.</li>
            <li>De 12h a 13h30min, es necesario cumplir el 70% del minimo diario critico para desbloquear las
                aplicaciones
                el resto del día.</li>
            <li>De 13h30min a 15h, es necesario cumplir el 60% del minimo diario critico para desbloquear las
                aplicaciones
                el resto del día.</li>
            <li>De 15h a 16h30min, es necesario cumplir el 50% del minimo diario critico para desbloquear las
                aplicaciones
                el resto del día.</li>
            <li>De 16h30min a 18h, es necesario cumplir el 40% del minimo diario critico para desbloquear las
                aplicaciones
                el resto del día.</li>
            <li>De 18h a 19h30min, es necesario cumplir el 30% del minimo diario critico para desbloquear las
                aplicaciones
                el resto del día.</li>
            <li>De 19h30min a 21h, es necesario cumplir el 20% del minimo diario critico para desbloquear las
                aplicaciones
                el resto del día.</li>
            <li>De 21h a 22h30min, es necesario cumplir el 10% del minimo diario critico para desbloquear las
                aplicaciones
                el resto del día.</li>
            <li>De 22h30min a 24h, es necesario cumplir el 5% del minimo diario critico para desbloquear las
                aplicaciones el
                resto del día.</li>
        </ul>
        <p>Finalmente, unos links de referencia.</p>
        <li><a href="./setGoingToUIB.php">Pagina para desactivar el sistema A (toni) una vez al día durante 40 minutos
                (simula
                que estas en el trayecto a la uni)</a></li>
        <li><a href="./shouldBlock.php">Pagina para comprobar si se debe bloquear o no el movil en el sistema A</a></li>
        <li><a href="./shouldBlockSufi.php">Pagina para comprobar si se debe bloquear o no el movil en el sistema B</a></li>
    </div>
</body>