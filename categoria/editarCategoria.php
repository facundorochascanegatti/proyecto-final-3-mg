<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require_once "../conexion.php";

$id = (int) ($_GET["id"] ?? $_POST["id"] ?? 0);

$resultado = mysqli_query($conn, "SELECT * FROM categorias WHERE id = $id AND genero = 'Masculino'");
$categoria = mysqli_fetch_assoc($resultado);

if (!$categoria) {
    header("Location: gestionarCategoria.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $año = trim($_POST["año"]);

    if (!preg_match('/^\d{4}$/', $año)) {
        $error = "El año debe tener 4 números, por ejemplo 2015.";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE categorias SET año = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $año, $id);

        try {
            mysqli_stmt_execute($stmt);
            header("Location: gestionarCategoria.php");
            exit();
        } catch (mysqli_sql_exception $e) {
            $error = "Esa categoría ya está registrada.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="categoria.css" rel="stylesheet">
    <title>Editar Categoría</title>
</head>
<body>
    <h1 class="tituloCategoria">Editar Categoría</h1>

    <?php if ($error): ?>
        <p class="parrafoCategoria"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="editarCategoria.php?id=<?= $id ?>" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label for="año">Año de categoría:</label>
        <input type="text" id="año" name="año" maxlength="4" required value="<?= htmlspecialchars($categoria["año"]) ?>">
        <input type="submit" value="Guardar">
    </form>
</body>
</html>