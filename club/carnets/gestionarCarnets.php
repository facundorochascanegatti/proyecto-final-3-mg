<?php
// solo puede entrar un club que inició sesión
require_once __DIR__ . "/../../auth.php";
requerirClub();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnets de Aptitud Física</title>
    <link href="carnets.css" rel="stylesheet">
</head>
<body>
    <header>
        <?php include __DIR__ . "/../menu.php"; ?>
    </header>
<!-- INCLUDE: el formulario para subir el carnet y la lista de carnets -->
<?php include("agregarCarnet.php"); ?>
<?php include("listarCarnets.php"); ?>
</body>
</html>
