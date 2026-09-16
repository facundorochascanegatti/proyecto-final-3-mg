<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = mysqli_connect("localhost", "root", "", "liga");

$club = null;

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT * FROM club WHERE id = $id";
    $resultado = mysqli_query($conn, $sql);
    $club = mysqli_fetch_assoc($resultado);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombreClub = $_POST["nombreClub"];

    $stmt = mysqli_prepare($conn, "UPDATE club SET nombre = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $nombreClub, $id);
    mysqli_stmt_execute($stmt);

    header("Location: gestionClubes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Club</title>
</head>
<body>

    <h1>Editar Club</h1>

    <?php if ($club): ?>
        <form action="editarClub.php" method="post">
            <input type="hidden" name="id" value="<?= $club['id'] ?>">
            <input type="text" name="nombreClub" value="<?= $club['nombre'] ?>" required>
            <input type="submit" value="Guardar Cambios">
        </form>
    <?php else: ?>
        <p>No se encontró el club.</p>
    <?php endif; ?>

</body>
</html>