<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Partidos</title>

    <link href="partidos.css" rel="stylesheet">
</head>
<body>

<header>
    <?php include "../nav/nav.php"; ?>
</header>

<?php include("agregarPartido.php"); ?>
<?php include("listarPartidos.php"); ?>

</body>
</html>
