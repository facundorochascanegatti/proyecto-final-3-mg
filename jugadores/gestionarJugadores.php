```php
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
    <header>
        <nav>
            <?php include "../nav/nav.php"; ?>
        </nav>
    </header>

    <?php include "agregarJugador.php"; ?>
    <?php include "listarJugadores.php"; ?>

    <?php if (isset($_GET["id"])): ?>
        <?php include "editarJugador.php"; ?>
    <?php endif; ?>
</body>
</html>
```