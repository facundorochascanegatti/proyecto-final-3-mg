<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnets de Aptitud Física</title>
    <link href="carnets.css" rel="stylesheet">
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
<!-- INCLUDE: el formulario para subir el carnet y la lista de carnets -->
<?php include("agregarCarnet.php"); ?>
<?php include("listarCarnets.php"); ?>
</body>
</html>
