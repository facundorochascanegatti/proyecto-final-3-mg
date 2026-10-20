<?php
// Conexión a la base de datos "liga"
$conn = mysqli_connect("localhost", "root", "", "liga");

// Jugadores para el desplegable
$resultadoJugadores = mysqli_query($conn, "SELECT jugadores.id, jugadores.nombre, jugadores.apellido, club.nombre AS club
    FROM jugadores INNER JOIN club ON jugadores.id_club = club.id ORDER BY jugadores.apellido");

// Mensaje por si la foto no es válida
$errorCarnet = "";

// Si se envió el formulario, se guarda la foto en "fotos" y el carnet en la base
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto"])) {

    $idJugador = (int)$_POST["jugador"];
    $vencimiento = $_POST["vencimiento"];
    $extension = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

    // Solo fotos (jpg, png o webp)
    if (!in_array($extension, ["jpg", "jpeg", "png", "webp"])) {
        $errorCarnet = "La foto tiene que ser JPG, PNG o WEBP.";
    } else {
        // La foto se llama como el jugador, así se reemplaza si se sube una nueva
        $nombreFoto = "jugador_" . $idJugador . "." . $extension;
        move_uploaded_file($_FILES["foto"]["tmp_name"], __DIR__ . "/fotos/" . $nombreFoto);

        // Un carnet por jugador: si ya tenía uno, se actualiza (renovación)
        $stmt = mysqli_prepare($conn, "INSERT INTO carnets (id_jugador, foto, fecha_vencimiento) VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE foto = VALUES(foto), fecha_vencimiento = VALUES(fecha_vencimiento)");
        mysqli_stmt_bind_param($stmt, "iss", $idJugador, $nombreFoto, $vencimiento);
        mysqli_stmt_execute($stmt);

        header("Location: gestionarCarnets.php");
        exit();
    }
}
?>

<!-- Formulario para subir o renovar un carnet de aptitud física -->
<form action="gestionarCarnets.php" method="post" enctype="multipart/form-data">

    <h1>Carnet de Aptitud Física</h1>

    <?php if ($errorCarnet): ?>
        <p class="aviso"><?= $errorCarnet ?></p>
    <?php endif; ?>

    <label for="jugador">Jugador:</label>
    <select name="jugador" id="jugador" required>
        <option value="">Seleccione un jugador</option>
        <?php while ($filaJugador = mysqli_fetch_assoc($resultadoJugadores)): ?>
            <option value="<?= $filaJugador['id'] ?>"><?= htmlspecialchars($filaJugador['apellido'] . ", " . $filaJugador['nombre'] . " (" . $filaJugador['club'] . ")") ?></option>
        <?php endwhile; ?>
    </select><br>

    <label for="foto">Foto del carnet:</label>
    <input type="file" id="foto" name="foto" accept="image/*" required><br>

    <label for="vencimiento">Vence el:</label>
    <input type="date" id="vencimiento" name="vencimiento" required><br>

    <input type="submit" value="Subir Carnet">

</form>
