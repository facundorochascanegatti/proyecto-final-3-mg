<?php
// esto sirve para conectar la base de datos
require_once __DIR__ . "/../conexion.php";

// las reglas para revisar un jugador (las mismas que usa editarJugador.php)
require_once "validarJugador.php";

// Consulta para obtener todas las categorías
$resultadoCategorias = mysqli_query($conn, "SELECT * FROM categorias WHERE activo = 1");

// Consulta para obtener todos los clubes
$resultadoClubes = mysqli_query($conn, "SELECT * FROM club");

// variable para guardar los errores
$error = "";

// Verifica si el formulario fue enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtiene los datos enviados desde el formulario
    $nombre = trim($_POST["nombre"]);
    $apellido = trim($_POST["apellido"]);
    $cedula = trim($_POST["cedula"]);
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $categorias = (int) $_POST["categorias"];
    $club = (int) $_POST["club"];
    $masa = $_POST["masa"];
    $altura = $_POST["altura"];
    $velocidad = $_POST["velocidad"];

    // revisa todo con las mismas reglas que al editar: letras en el nombre, cédula válida y sin repetir,
    // fecha real, categoría del año de nacimiento, club, masa y altura (0 = jugador nuevo)
    $error = validarJugador($conn, $nombre, $apellido, $cedula, $fecha_nacimiento, $categorias, $club, $masa, $altura, 0);

    // la velocidad tiene que ser un número que no sea negativo
    if ($error == "" && (!is_numeric($velocidad) || $velocidad < 0)) {
        $error = "La velocidad tiene que ser un número positivo.";
    }

    if ($error == "") {

        // Calcula el peso usando la gravedad
        $gravedad = 9.8;
        $peso = $masa * $gravedad;

            // Inserta el nuevo jugador en la base de datos
            $sql = "INSERT INTO jugadores
                    (nombre, apellido, cedula, fecha_nacimiento, id_categoria, id_club, masa, altura, peso, velocidad)
                    VALUES ('$nombre', '$apellido', '$cedula', '$fecha_nacimiento', $categorias, $club, $masa, $altura, $peso, $velocidad)";

            // Ejecuta la consulta
            if (mysqli_query($conn, $sql)) {

                header("Location: gestionarJugadores.php");
                exit();

            } else {

                $error = "Error al agregar jugador: " . mysqli_error($conn);

            }
    }
}
?>

<!-- Formulario para agregar un nuevo jugador -->
<form action="gestionarJugadores.php" method="post">

    <h1>Gestionar Jugadores</h1>

    <!-- muestra el mensaje si hay algun error -->
    <?php if ($error != "") { ?>
        <p class="mensajeError"><?= htmlspecialchars($error) ?></p>
    <?php } ?>

    <div class="field-row">

        <div class="field">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="field">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>

    </div>

    <div class="field">
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" maxlength="8" required>
    </div>

    <div class="field">
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
               min="2013-01-01" max="2020-12-31" required>
    </div>

    <div class="field-row">

        <div class="field">
            <label for="masa">Masa (kg):</label>
            <input type="number" id="masa" name="masa"
                   min="17" max="70" step="0.01" required>
        </div>

        <div class="field">
            <label for="altura">Altura (m):</label>
            <input type="number" step="0.01" id="altura" name="altura"
                   min="1.20" max="1.75" required>
        </div>

        <div class="field">
            <label for="velocidad">Velocidad (m/s):</label>
            <input type="number" step="0.01" id="velocidad" name="velocidad"
                   min="0" required>
        </div>

    </div>

    <div class="field-row">

        <div class="field">
            <label for="categorias">Categorías:</label>
            <select name="categorias" id="categorias" required>

                <option value="">Seleccione una categoría</option>

                <?php while ($filaCategorias = mysqli_fetch_assoc($resultadoCategorias)): ?>

                    <option value="<?= htmlspecialchars($filaCategorias['id']) ?>">
                        <?= htmlspecialchars($filaCategorias['año']) ?>
                    </option>

                <?php endwhile; ?>

            </select>
        </div>

        <div class="field">
            <label for="club">Club:</label>
            <select name="club" id="club" required>

                <option value="">Seleccione un club</option>

                <?php while ($filaClubes = mysqli_fetch_assoc($resultadoClubes)): ?>

                    <option value="<?= htmlspecialchars($filaClubes['id']) ?>">
                        <?= htmlspecialchars($filaClubes['nombre']) ?>
                    </option>

                <?php endwhile; ?>

            </select>
        </div>

    </div>
        <input type="submit" value="Agregar Jugador">
</form>

<!-- Scripts para avisar en vivo si la cédula es válida (ajustá la ruta si hace falta) -->
<script src="../js/ci.js"></script>
<script src="../js/validarCedula.js"></script>