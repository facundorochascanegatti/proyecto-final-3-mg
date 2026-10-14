<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Sanciones</title>
    <link href="sanciones.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <header>
        <!-- BARRA DE NAVEGACIÓN -->
        <nav>
            <a href="../admin/indexadmin.php" class="home">
                <i class="fa-solid fa-house"></i>
            </a>
            <a href="../sanciones/gestionarSanciones.php">Sanciones</a>
            <a href="../carnets/gestionarCarnets.php">Carnets</a>
            <a href="../categoria/gestionarCategoria.php">Categorias</a>
            <a href="../clubes/gestionClubes.php">Clubes</a>
            <a href="../jugadores/gestionarJugadores.php">Jugadores</a>
        </nav>
    </header>
<!-- Botón para ir a los boletines en PDF -->
<div class="botonera">
    <a href="boletines.php" class="boton"><i class="fa-solid fa-file-pdf"></i> Boletines de sanciones</a>
</div>
<!-- INCLUDE: el formulario de tarjetas y la tabla de sanciones -->
<?php include("agregarSancion.php"); ?>
<?php include("listarSanciones.php"); ?>
</body>
</html>
