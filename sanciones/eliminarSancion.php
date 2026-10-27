<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
// Conexión a la base de datos "liga"
require_once __DIR__ . "/../conexion.php";

// Quita la última tarjeta cargada a ese jugador (por si se cargó por error)
if (isset($_GET["jugador"])) {
    $idJugador = (int)$_GET["jugador"];
    mysqli_query($conn, "DELETE FROM sanciones WHERE id_jugador = $idJugador ORDER BY id DESC LIMIT 1");
}

// Vuelve a la página de sanciones
header("Location: gestionarSanciones.php");
exit();
