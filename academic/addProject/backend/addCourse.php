<?php
try {
    //0. CONSTANTS
    $DAYS_DISPLAYED = 14;
    //1. IMPORTS 
    require dirname(__DIR__, 3) . "/connectToTheDatabase.php";
    //2. CONNECT TO THE DB
    $conection = connectToTheDatabase();
    ///3. FIRST QUERY 
//get from the username, the id, for example the username "peter" may be the id 2
    $query = "select id from user100 where nickname=\"" . $_GET["username"] . "\"";
    $idCon = mysqli_query($conection, $query);
    $id = mysqli_fetch_all($idCon)[0][0];
    //4. SECOND QUERY
    $query = "insert into projects100 (name,description,courseID,userID) values (?,?,?,?)";
    $stmt = $conection->prepare($query);
    $stmt->bind_param("ssii", $_GET["projectName"], $_GET["description"], $_GET["course"], $id);
    if ($stmt->execute()) {
        echo "todo fue bien, el dato fue insertado en la base de datos exitosamente";
        header("Location: ../../mainPage/index.php?name=" . $_GET["username"]);
        echo "<script>alert(\"todo fue bien, el dato fue insertado en la base de datos exitosamente\")</script>";
    } else {
        echo "<script>alert(\"hubo un error, pusiste algo mal, vuelve a intentarlo\")</script>";
    }
} catch (Exception $error) {
    echo "<script>alert(\"ERROR:".$error."\")</script>";
}
?>