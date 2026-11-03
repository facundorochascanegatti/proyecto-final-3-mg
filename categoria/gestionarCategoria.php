<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require "../conexion.php";

$mensaje = "";

// botón Activar / Desactivar de la lista (viene de listarCategoria.php)
if (isset($_POST["cambiar_estado"])) {
    $id = (int) $_POST["id"];

    // 1 - activo da la vuelta el valor: si estaba en 1 pasa a 0, y si estaba en 0 pasa a 1
    $stmt = mysqli_prepare($conn, "UPDATE categorias SET activo = 1 - activo WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    // vuelve a cargar la página para que no se repita al actualizar
    header("Location: gestionarCategoria.php");
    exit();
}

if (isset($_POST["año"])) {
    $año = trim($_POST["año"]);

    // tiene que ser un año de 4 números (por ejemplo 2015) o la palabra Femenino
    if (!preg_match('/^\d{4}$/', $año) && $año != "Femenino") {
        $mensaje = "Escriba un año de 4 números (por ejemplo 2015) o Femenino.";
    } else {
        // consulta preparada: el ? se reemplaza por el dato de forma segura
        $stmt = mysqli_prepare($conn, "SELECT id FROM categorias WHERE año = ?");
        mysqli_stmt_bind_param($stmt, "s", $año);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            $mensaje = "Esa categoria ya esta registrada, intente con otra.";
        } else {
            // la categoría nueva queda activa porque el campo activo vale 1 por defecto
            $stmt = mysqli_prepare($conn, "INSERT INTO categorias (año) VALUES (?)");
            mysqli_stmt_bind_param($stmt, "s", $año);
            mysqli_stmt_execute($stmt);

            $mensaje = "Categoría guardada correctamente";
        }
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