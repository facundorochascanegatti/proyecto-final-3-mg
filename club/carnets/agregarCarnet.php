<?php
require_once __DIR__ . "/../../auth.php";
requerirClub();
require_once __DIR__ . "/../../conexion.php";

// el club que inició sesión: cada club sube los carnets de sus propios jugadores
$miClub = (int) $_SESSION["id_club"];

// Obtener los jugadores del club
$resultadoJugadores = mysqli_query($conn, "SELECT jugadores.id, jugadores.nombre, jugadores.apellido, club.nombre AS club
FROM jugadores INNER JOIN club ON jugadores.id_club = club.id WHERE jugadores.id_club = $miClub ORDER BY jugadores.apellido");

$errorCarnet = "";

// Procesa el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["foto"])) {

    //$idjugador y $vencimiento sirven para validar que se haya seleccionado un jugador y una fecha de vencimiento
    $idJugador = (int) $_POST["jugador"];
    $vencimiento = $_POST["vencimiento"];

    // el jugador tiene que ser de este club (por si alguien cambia el número a mano)
    $jugador = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM jugadores WHERE id = $idJugador AND id_club = $miClub"));
    $partes = explode("-", $vencimiento);

    //esto obtiene la extension del archivo subido, puede ser jpg, jpeg o png.
    $extension = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
    $extension = strtolower($extension);

    if (!$jugador) {
        $errorCarnet = "Seleccione un jugador de su club.";
    } elseif (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $vencimiento) || !checkdate($partes[1], $partes[2], $partes[0])) {
        $errorCarnet = "La fecha de vencimiento no es válida.";
    } elseif ($vencimiento < date("Y-m-d")) {
        $errorCarnet = "Ese carnet ya está vencido.";
    } elseif (!in_array($extension, ["jpg", "jpeg", "png"])) {
        // esto valida la extension de la foto del carnet, si no es jpg, jpeg o png, muestra un error
        $errorCarnet = "La foto tiene que ser JPG, JPEG o PNG.";
    } else {

        // si ya tenía un carnet con otra foto (por ejemplo .png y ahora sube .jpg) se borra la vieja
        $anterior = mysqli_fetch_assoc(mysqli_query($conn, "SELECT foto FROM carnets WHERE id_jugador = $idJugador"));
        if ($anterior && file_exists(__DIR__ . "/fotos/" . $anterior["foto"])) {
            unlink(__DIR__ . "/fotos/" . $anterior["foto"]);
        }

        // esto sirve para guardar la foto del carnet en la carpeta fotos con un nombre unico basado en el id del jugador
        $nombreFoto = "jugador_" . $idJugador . "." . $extension;
        // esto sirve para mover la foto a la carpeta "fotos", si no se pudo no se sigue
        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], __DIR__ . "/fotos/" . $nombreFoto)) {
            $errorCarnet = "No se pudo subir la foto.";
        } else {

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
}
?>

<form action="gestionarCarnets.php" method="post" enctype="multipart/form-data">

    <h1>Carnet de Aptitud Física</h1>

    <?php if ($errorCarnet != ""): ?>
        <p class="aviso"><?= htmlspecialchars($errorCarnet) ?></p>
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
    <input type="date" id="vencimiento" name="vencimiento" min="<?= date('Y-m-d') ?>" required><br>

    <input type="submit" value="Subir Carnet">

</form>