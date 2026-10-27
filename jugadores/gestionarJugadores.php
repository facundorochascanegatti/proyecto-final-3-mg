<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Jugadores</title>
    <link href="jugadores.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include "../nav/nav.php"; ?>
    </header>

    <?php include "agregarJugador.php"; ?>
    <?php include "listarJugadores.php"; ?>
</body>
</html>
