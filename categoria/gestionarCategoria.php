<?php
require "../conexion.php";

if (isset($_POST["año"])) {
    $año = mysqli_real_escape_string($conn, $_POST["año"]);

    $buscar = "SELECT * FROM categorias WHERE año = '$año'";
    $resultado = mysqli_query($conn, $buscar);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<p class='mensajeError'>Esa categoria ya esta registrada, intente con otra.</p>";
    } else {
        $sql = "INSERT INTO categorias (año) VALUES ('$año')";
        mysqli_query($conn, $sql);

        echo "<p class='mensajeError'>Categoría guardada correctamente</p>";
    }
}

$categorias = mysqli_query($conn, "SELECT * FROM categorias ORDER BY año");
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
        <nav>
            <?php include '../nav/nav.php'; ?>
        </nav>
    </header>

    <form action="gestionarCategoria.php" method="post">
        <h1 class="tituloCategoria">Gestionar Categorías</h1>

        <label for="año">Año de categoría:</label>
        <input type="text" id="año" name="año" required>
        <br><br>

        <input type="submit" value="Agregar Categoría">
    </form>
</body>
</html>

<?php include("listarCategoria.php"); ?>
