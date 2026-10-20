<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require_once "../conexion.php";

$id = (int) ($_GET["id"] ?? $_POST["id"] ?? 0);

$resultado = mysqli_query($conn, "SELECT * FROM jugadores WHERE id = $id");
$jugador = mysqli_fetch_assoc($resultado);

if (!$jugador) {
    header("Location: gestionarJugadores.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $cedula = trim($_POST["cedula"]);
    $fechaNacimiento = $_POST["fecha_nacimiento"];
    $masa = $_POST["masa"];
    $altura = $_POST["altura"];

    $gravedad = 9.8;
    $peso = $masa * $gravedad;
    $velocidad = (2 * $gravedad * $altura) ** 0.5;

    $stmt = mysqli_prepare($conn, "UPDATE jugadores SET nombre = ?, apellido = ?, cedula = ?, fecha_nacimiento = ?, masa = ?, altura = ?, peso = ?, velocidad = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssssidddi", $nombre, $apellido, $cedula, $fechaNacimiento, $masa, $altura, $peso, $velocidad, $id);

    try {
        mysqli_stmt_execute($stmt);
        header("Location: gestionarJugadores.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        $error = "No se pudieron guardar los cambios. Verificá que la cédula no esté registrada en otro jugador.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="jugadores.css" rel="stylesheet">
    <link href="../nav/nav.css" rel="stylesheet">
    <title>Editar Jugador</title>
</head>
<body>
    <header>
        <nav>
            <a href="gestionarJugadores.php">Volver a Jugadores</a>
            <a href="../admin/indexadmin.php" class="home">
                <i class="fa-solid fa-house"></i>
            </a>
        </nav>
    </header>

    <h1>Editar Jugador</h1>

    <?php if ($error): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="editarJugador.php?id=<?= $id ?>" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($jugador["nombre"]) ?>">

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required value="<?= htmlspecialchars($jugador["apellido"]) ?>">

        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required value="<?= htmlspecialchars($jugador["cedula"]) ?>">

        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required value="<?= htmlspecialchars($jugador["fecha_nacimiento"]) ?>">

        <label for="masa">Masa:</label>
        <input type="text" id="masa" name="masa" required value="<?= htmlspecialchars($jugador["masa"]) ?>">

        <label for="altura">Altura:</label>
        <input type="text" id="altura" name="altura" required value="<?= htmlspecialchars($jugador["altura"]) ?>">

        <input type="submit" value="Guardar">
    </form>
</body>
</html>
