
<?php
require_once __DIR__ . "/../conexion.php";

if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];

    $sql = "DELETE FROM partidos WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: gestionarPartidos.php");
exit();
