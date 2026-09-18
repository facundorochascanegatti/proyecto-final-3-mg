<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM jugadores WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: gestionarJugadores.php");
exit();
?>