<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require "../conexion.php";

$mensaje = "";

// eliminarCategoria.php vuelve con ?enUso=1 si la categoría tenía jugadores o partidos
if (isset($_GET["enUso"])) {
    $mensaje = "No se puede eliminar una categoría que tiene jugadores o partidos.";
}

if (isset($_POST["año"])) {
    $año = mysqli_real_escape_string($conn, $_POST["año"]);

    $buscar = "SELECT * FROM categorias WHERE año = '$año'";
    $resultado = mysqli_query($conn, $buscar);

    if (mysqli_num_rows($resultado) > 0) {
        $mensaje = "Esa categoria ya esta registrada, intente con otra.";
    } else {
        $sql = "INSERT INTO categorias (año) VALUES ('$año')";
        mysqli_query($conn, $sql);

        $mensaje = "Categoría guardada correctamente";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../categoria/categoria.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Gestionar Categorías</title>
</head>
<body>
    <header>
        <?php include '../nav/nav.php'; ?>
    </header>

    <form action="gestionarCategoria.php" method="post">
        <h1 class="tituloCategoria">Gestionar Categorías</h1>

        <?php if ($mensaje != ""): ?>
            <p class="parrafoCategoria"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <label for="año">Año de categoría:</label>
        <input type="text" id="año" name="año" required>
        <br><br>

        <input type="submit" value="Agregar Categoría">
    </form>

    <?php include("listarCategoria.php"); ?>
</body>
</html>
