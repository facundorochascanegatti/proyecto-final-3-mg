<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require_once __DIR__ . "/../conexion.php";


// Inicializa la variable de error como cadena vacía
$error = "";

$jugadores = mysqli_query($conn, "
    SELECT jugadores.id, jugadores.nombre, jugadores.apellido, club.nombre AS club
    FROM jugadores
    INNER JOIN club ON jugadores.id_club = club.id
    ORDER BY jugadores.apellido
");

//
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST["jugador"];
    $tipo = $_POST["tipo"];
    $fecha = $_POST["fecha"];
    $motivo = trim($_POST["motivo"]);

    // Validación de los datos
    //el explode separa la fecha en partes, y checkdate valida que sea una fecha válida
    $jugador = mysqli_query($conn, "SELECT id FROM jugadores WHERE id = $id");
    $partes = explode("-", $fecha);


    if (mysqli_num_rows($jugador) == 0) {
        $error = "Seleccione un jugador.";
    } elseif ($tipo != "Amarilla" && $tipo != "Roja") {
        $error = "Tarjeta inválida.";
    } elseif (
        count($partes) != 3 ||
        !checkdate((int)$partes[1], (int)$partes[2], (int)$partes[0])
    ) {
        $error = "Fecha inválida.";
    } elseif ($fecha > date("Y-m-d")) {
        $error = "La fecha no puede ser futura.";
    } else {
        $sql = "INSERT INTO sanciones (id_jugador, tipo, fecha, motivo)
                VALUES (?, ?, ?, ?)";
                

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "isss", $id, $tipo, $fecha, $motivo);
        mysqli_stmt_execute($stmt);

        header("Location: gestionarSanciones.php");
        exit();
    }
}
?>

<form action="gestionarSanciones.php" method="post">

    <h1>Registrar Tarjeta</h1>

    <?php if ($error != ""): ?>
        <p class="aviso"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <label>Jugador:</label>
    <select name="jugador" required>
        <option value="">Seleccione un jugador</option>

        <?php while ($fila = mysqli_fetch_assoc($jugadores)): ?>
            <option value="<?= $fila['id'] ?>">
                <?= htmlspecialchars($fila['apellido'] . ", " . $fila['nombre'] . " (" . $fila['club'] . ")") ?>
            </option>
        <?php endwhile; ?>
    </select>

    <br>

    <label>Tarjeta:</label>
    <select name="tipo" required>
        <option value="Amarilla">Amarilla</option>
        <option value="Roja">Roja</option>
    </select>

    <br>

    <label>Fecha:</label>
    <input type="date" name="fecha"
        value="<?= date('Y-m-d') ?>"
            max="<?= date('Y-m-d') ?>" required>

    <br>

    <label>Motivo:</label>
    <input type="text" name="motivo"
    placeholder="Ej: falta fuerte" maxlength="150">

    <br>

    <input type="submit" value="Registrar Tarjeta">

</form>