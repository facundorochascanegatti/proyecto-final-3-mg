
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Partidos</title>

    <link href="partidos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<header>
    <nav>
        <a href="../admin/indexadmin.php" class="home"><i class="fa-solid fa-house"></i></a>
        <a href="../sanciones/gestionSanciones.php">Sanciones</a>
        <a href="../admin/gestionCarnet.php">Carnets</a>
        <a href="../categoria/gestionarCategoria.php">Categorias</a>
        <a href="../clubes/gestionClubes.php">Clubes</a>
        <a href="../jugadores/gestionarJugadores.php">Jugadores</a>
        <a href="gestionarPartidos.php">Partidos</a>
    </nav>
</header>

<?php include("agregarPartido.php"); ?>
<?php include("listarPartidos.php"); ?>

</body>
</html>
