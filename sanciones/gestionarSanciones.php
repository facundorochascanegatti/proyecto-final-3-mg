<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Sanciones</title>
    <link href="sanciones.css" rel="stylesheet">
</head>
<body>
    <header>
        <!-- BARRA DE NAVEGACIÓN -->
        <?php include '../nav/nav.php'; ?>
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
