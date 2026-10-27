<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require_once "../conexion.php";
require_once "validarJugador.php";

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
    $categoria = (int) $_POST["categorias"];
    $club = (int) $_POST["club"];
    $masa = $_POST["masa"];
    $altura = $_POST["altura"];

    // mismas reglas que al agregar (validarJugador.php), se pasa $id para que no choque con su propia cédula
    $error = validarJugador($conn, $nombre, $apellido, $cedula, $fechaNacimiento, $categoria, $club, $masa, $altura, $id);

    if ($error == "") {
        $gravedad = 9.8;
        $peso = $masa * $gravedad;
        $velocidad = (2 * $gravedad * $altura) ** 0.5;

        $stmt = mysqli_prepare($conn, "UPDATE jugadores SET nombre = ?, apellido = ?, cedula = ?, fecha_nacimiento = ?, id_categoria = ?, id_club = ?, masa = ?, altura = ?, peso = ?, velocidad = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssssiiddddi", $nombre, $apellido, $cedula, $fechaNacimiento, $categoria, $club, $masa, $altura, $peso, $velocidad, $id);
        mysqli_stmt_execute($stmt);

        header("Location: gestionarJugadores.php");
        exit();
    }
}

// para los desplegables de categoría y club
$categorias = mysqli_query($conn, "SELECT * FROM categorias");
$clubes = mysqli_query($conn, "SELECT * FROM club");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="jugadores.css" rel="stylesheet">
    <title>Editar Jugador</title>
</head>
<body>
    <header>
        <?php include "../nav/nav.php"; ?>
    </header>

    <form action="editarJugador.php?id=<?= $id ?>" method="post">
        <h1>Editar Jugador</h1>

        <?php if ($error): ?>
            <p class="mensajeError"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?= $id ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($jugador["nombre"]) ?>">

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required value="<?= htmlspecialchars($jugador["apellido"]) ?>">

        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" maxlength="8" required value="<?= htmlspecialchars($jugador["cedula"]) ?>">

        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" min="2013-01-01" max="2020-12-31" required value="<?= htmlspecialchars($jugador["fecha_nacimiento"]) ?>">

        <label for="masa">Masa:</label>
        <input type="text" id="masa" name="masa" required value="<?= htmlspecialchars($jugador["masa"]) ?>">

        <label for="altura">Altura:</label>
        <input type="text" id="altura" name="altura" required value="<?= htmlspecialchars($jugador["altura"]) ?>">

        <label for="categorias">Categoría:</label>
        <select name="categorias" id="categorias" required>
            <option value="">Seleccione una categoría</option>
            <?php while ($c = mysqli_fetch_assoc($categorias)): ?>
                <option value="<?= $c["id"] ?>" <?= $c["id"] == $jugador["id_categoria"] ? "selected" : "" ?>><?= htmlspecialchars($c["año"]) ?></option>
            <?php endwhile; ?>
        </select>

        <label for="club">Club:</label>
        <select name="club" id="club" required>
            <option value="">Seleccione un club</option>
            <?php while ($c = mysqli_fetch_assoc($clubes)): ?>
                <option value="<?= $c["id"] ?>" <?= $c["id"] == $jugador["id_club"] ? "selected" : "" ?>><?= htmlspecialchars($c["nombre"]) ?></option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Guardar">
    </form>
</body>
</html>
