```php
<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

// Obtener jugadores y sus clubes
$resultadoJugadores = mysqli_query($conn, "SELECT jugadores.id, jugadores.nombre, jugadores.apellido, club.nombre AS club
FROM jugadores INNER JOIN club ON jugadores.id_club = club.id ORDER BY jugadores.apellido");

$errorCarnet = "";

// Procesa el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto"])) {

    //$idjugador y $vencimiento sirven para validar que se haya seleccionado un jugador y una fecha de vencimiento
    $idJugador = $_POST["jugador"];
    $vencimiento = $_POST["vencimiento"];

    //esto obtiene la extension del archivo subido, puede ser jpg, jpeg o png.
    $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
    $extension = strtolower($extension);

    // esto valida la extension de la foto del carnet, si no es jpg, jpeg o png, muestra un error
    if (!in_array($extension, ["jpg", "jpeg", "png"])) {
        $errorCarnet = "La foto tiene que ser JPG, JPEG o PNG.";
    } else {

        // esto sirve para guardar la foto del carnet en la carpeta fotos con un nombre unico basado en el id del jugador
        $nombreFoto = "jugador_" . $idJugador . "." . $extension;
        // esto sirve para mover la foto a la carpeta "fotos"
        move_uploaded_file($_FILES["foto"]["tmp_name"], __DIR__ . "/fotos/" . $nombreFoto);

        // esto sirve para guardar o actualizar la foto y la fecha de vencimiento del carnet en la base de datos
        $sql = "INSERT INTO carnets (id_jugador, foto, fecha_vencimiento) VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE foto = VALUES(foto), fecha_vencimiento = VALUES(fecha_vencimiento)";

        // esto prepara la consulta para evitar inyecciones SQL, osea sirve para mejorar la seguridad
        $stmt = mysqli_prepare($conn, $sql);

        // vincula cada "?" de la consulta con el valor q le corresponde
        mysqli_stmt_bind_param($stmt, "iss", $idJugador, $nombreFoto, $vencimiento);
        // ejecuta la consulta
        mysqli_stmt_execute($stmt);

        // redirige a la pagina de gestionar carnets despues de subir la foto y la fecha de vencimiento
        header("Location: gestionarCarnets.php");
        exit();
    }
}
?>

<form action="gestionarCarnets.php" method="post" enctype="multipart/form-data">

    <h1>Carnet de Aptitud Física</h1>

    <?php if ($errorCarnet != ""): ?>
        <p class="aviso"><?= $errorCarnet ?></p>
    <?php endif; ?>

    <label for="jugador">Jugador:</label>
    <select name="jugador" id="jugador" required>
        <option value="">Seleccione un jugador</option>
        <?php while ($jugador = mysqli_fetch_assoc($resultadoJugadores)): ?>
            <option value="<?= $jugador['id'] ?>"><?= htmlspecialchars($jugador['apellido'] . ", " . $jugador['nombre'] . " (" . $jugador['club'] . ")") ?></option>
        <?php endwhile; ?>
    </select><br>

    <label for="foto">Foto del carnet:</label>
    <input type="file" id="foto" name="foto" accept="image/*" required><br>

    <label for="vencimiento">Vence el:</label>
    <input type="date" id="vencimiento" name="vencimiento" required><br>

    <input type="submit" value="Subir Carnet">

</form>