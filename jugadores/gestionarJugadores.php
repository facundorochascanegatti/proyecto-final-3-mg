<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Jugadores</title>
    <link href="jugadores.css" rel="stylesheet">
    <!-- ESTO DE ABAJO ES UNA BARRA DE NAVEGACION PARA LA PAGINA -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
        <header>

        <!-- ESTO DE ABAJO ES UNA BARRA DE NAVEGACIÓN PARA LA PÁGINA -->
        <nav>
            <a href="../admin/indexadmin.php" class="home">
                <i class="fa-solid fa-house"></i>
            </a>
            <a href="gestionSanciones.php">Sanciones</a>
            <a href="admin/gestionCarnets.php">Carnets</a>
            <a href="../categoria/gestionarCategoria.php">Categorias</a>
            <a href="../clubes/gestionClubes.php">Clubes</a>
            <a href="../jugadores/gestionarJugadores.php">Jugadores</a>
        </nav>
    </header>
<!-- ESTO ES UN INCLUDE, SIRVE PARA BASICAMENTE INCLUIR EL CODIGO DE OTRO ARCHIVO, EN ESTE CASO ES PARA INCLUIR EL CODIGO DE AGREGAR JUGADOR, LISTAR JUGADORES Y EDITAR JUGADOR -->
<?php include("agregarJugador.php"); ?>
<?php include("listarJugadores.php"); ?>
<?php include("editarJugador.php"); ?>
</body>
</html>