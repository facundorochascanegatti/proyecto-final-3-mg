<?php
require "../conexion.php";   // esto reemplaza al mysqli_connect

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM jugadores WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: gestionarJugadores.php");
exit();
?>