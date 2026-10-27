<?php
require_once __DIR__ . "/../../auth.php";
requerirClub();
// Conexión a la base de datos "liga"
require_once __DIR__ . "/../../conexion.php";

$miClub = (int) $_SESSION["id_club"];

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];

    // Primero se borra la foto de la carpeta, después el carnet de la base
    // (solo si el carnet es de un jugador de este club)
    $resultado = mysqli_query($conn, "SELECT carnets.foto FROM carnets
        INNER JOIN jugadores ON carnets.id_jugador = jugadores.id
        WHERE carnets.id = $id AND jugadores.id_club = $miClub");
    $carnet = mysqli_fetch_assoc($resultado);
    if ($carnet) {
        if (file_exists(__DIR__ . "/fotos/" . $carnet["foto"])) {
            unlink(__DIR__ . "/fotos/" . $carnet["foto"]);
        }
        mysqli_query($conn, "DELETE FROM carnets WHERE id = $id");
    }
}

// Vuelve a la página de carnets
header("Location: gestionarCarnets.php");
exit();
