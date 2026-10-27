<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require "../conexion.php";   // esto reemplaza al mysqli_connect

/* esta variable guarda los datos del club, la iniciamos en null por si no se encuentra */
$club = null;

/* verifica si se recibio un id por GET, si es asi, busca el club en la base de datos */
if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $resultado = mysqli_query($conn, "SELECT * FROM club WHERE id = $id");
    $club = mysqli_fetch_assoc($resultado);
}

/* verifica si se recibio un formulario por POST, si es asi, actualiza el nombre del club */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST["id"];
    $nombreClub = mysqli_real_escape_string($conn, trim($_POST["nombreClub"]));

    mysqli_query($conn, "UPDATE club SET nombre = '$nombreClub' WHERE id = $id");

    header("Location: gestionClubes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="clubes.css">
    <title>Editar Club</title>
</head>
<body>

    <header>
        <?php include '../nav/nav.php'; ?>
    </header>

    <?php if ($club): ?>
    <h1 class="tituloClubes">Editar Club</h1>
    <div class="Casilla">
        <form action="editarClub.php" method="post">
            <input type="hidden" name="id" value="<?= $club['id'] ?>">
            <input type="text" id="nombreClub" name="nombreClub" required class="nombreClub" value="<?= htmlspecialchars($club['nombre']) ?>">
            <br><br>
            <input type="submit" value="Guardar Cambios" class="Agregar">
        </form>
    </div>
    <?php endif; ?>

</body>
</html>