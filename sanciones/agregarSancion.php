<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
// Conexión a la base de datos "liga"
require_once __DIR__ . "/../conexion.php";

// Jugadores para el desplegable (con su club, así es más fácil encontrarlos)
$resultadoJugadores = mysqli_query($conn, "SELECT jugadores.id, jugadores.nombre, jugadores.apellido, club.nombre AS club
    FROM jugadores INNER JOIN club ON jugadores.id_club = club.id ORDER BY jugadores.apellido");

$errorSancion = "";

// Si se envió el formulario de la tarjeta, se guarda
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tipo"])) {

    $idJugador = (int) $_POST["jugador"];
    $tipo = $_POST["tipo"];
    $fecha = $_POST["fecha"];
    $motivo = trim($_POST["motivo"]);

    // que el jugador exista, que la tarjeta sea amarilla o roja, y que la fecha sea real y no del futuro
    $jugador = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM jugadores WHERE id = $idJugador"));
    $partes = explode("-", $fecha);

    if (!$jugador) {
        $errorSancion = "Seleccione un jugador.";
    } elseif ($tipo != "Amarilla" && $tipo != "Roja") {
        $errorSancion = "La tarjeta tiene que ser amarilla o roja.";
    } elseif (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $fecha) || !checkdate($partes[1], $partes[2], $partes[0])) {
        $errorSancion = "La fecha no es válida.";
    } elseif ($fecha > date("Y-m-d")) {
        $errorSancion = "No se puede cargar una tarjeta con fecha futura.";
    } else {
        // Se guarda con prepare para que nadie pueda meter SQL en el motivo
        $stmt = mysqli_prepare($conn, "INSERT INTO sanciones (id_jugador, tipo, fecha, motivo) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isss", $idJugador, $tipo, $fecha, $motivo);
        mysqli_stmt_execute($stmt);

        // Vuelve a la página para que no se repita la tarjeta al recargar
        header("Location: gestionarSanciones.php");
        exit();
    }
}
?>

<!-- Formulario para registrar una tarjeta -->
<form action="gestionarSanciones.php" method="post">

    <h1>Registrar Tarjeta</h1>

    <?php if ($errorSancion != ""): ?>
        <p class="aviso"><?= htmlspecialchars($errorSancion) ?></p>
    <?php endif; ?>

    <label for="jugador">Jugador:</label>
    <select name="jugador" id="jugador" required>
        <option value="">Seleccione un jugador</option>
        <?php while ($filaJugador = mysqli_fetch_assoc($resultadoJugadores)): ?>
            <option value="<?= $filaJugador['id'] ?>"><?= htmlspecialchars($filaJugador['apellido'] . ", " . $filaJugador['nombre'] . " (" . $filaJugador['club'] . ")") ?></option>
        <?php endwhile; ?>
    </select><br>

    <label for="tipo">Tarjeta:</label>
    <select name="tipo" id="tipo" required>
        <option value="Amarilla">Amarilla</option>
        <option value="Roja">Roja</option>
    </select><br>

    <label for="fecha">Fecha del partido:</label>
    <input type="date" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d') ?>" required><br>

    <label for="motivo">Motivo:</label>
    <input type="text" id="motivo" name="motivo" placeholder="Ej: falta fuerte, protestar..." maxlength="150"><br>

    <input type="submit" value="Registrar Tarjeta">

</form>
