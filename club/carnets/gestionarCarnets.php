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

    <nav>
        <?php include_once __DIR__ . "/../../club/menu.php";
        ?>
    </nav>
    </header>
<!-- INCLUDE: el formulario para subir el carnet y la lista de carnets -->
<?php include("agregarCarnet.php"); ?>
<?php include("listarCarnets.php"); ?>
</body>
</html>
