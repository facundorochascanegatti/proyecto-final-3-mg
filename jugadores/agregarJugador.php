<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/validarJugador.php";

// Consulta para obtener todas las categorías
$resultadoCategorias = mysqli_query($conn, "SELECT * FROM categorias");

// Consulta para obtener todos los clubes
$resultadoClubes = mysqli_query($conn, "SELECT * FROM club");

// Verifica si el formulario fue enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // esto obtiene los datos enviados desde el formulario
    // real_escape_string escapa las comillas para que no se pueda meter SQL, y (int) deja solo números
    $nombre = mysqli_real_escape_string($conn, trim($_POST["nombre"]));
    $apellido = mysqli_real_escape_string($conn, trim($_POST["apellido"]));
    $cedula = trim($_POST["cedula"]);
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $categorias = (int) $_POST["categorias"];
    $club = (int) $_POST["club"];
    $masa = $_POST["masa"];
    $altura = $_POST["altura"];

    // revisa nombre, apellido, cédula, fecha, categoría, club, masa y altura (está en validarJugador.php)
    $error = validarJugador($conn, trim($_POST["nombre"]), trim($_POST["apellido"]), $cedula, $fecha_nacimiento, $categorias, $club, $masa, $altura, 0);

    if ($error != "") {
        echo "<p class='mensajeError'>" . htmlspecialchars($error) . "</p>";
    } else {

        // aca abajo se calcula la parte de fisica, lo de mecanica clasica.
        $gravedad = 9.8;
        $peso = $masa * $gravedad;
        $velocidad = (2 * $gravedad * $altura) ** 0.5;

        // Consulta SQL para insertar un nuevo jugador
        $sql = "INSERT INTO jugadores
                (nombre, apellido, cedula, fecha_nacimiento, id_categoria, id_club, masa, altura, peso, velocidad)
                VALUES ('$nombre', '$apellido', '$cedula', '$fecha_nacimiento', $categorias, $club, $masa, $altura, $peso, $velocidad)";

        // Ejecuta la consulta y verifica si se agregó correctamente
        if (mysqli_query($conn, $sql)) {

            // Redirige a la página de gestión de jugadores
            header("Location: gestionarJugadores.php");

            // Detiene la ejecución del código
            exit();

        } else {

            // Muestra un mensaje con el error de la base de datos
            echo "Error al agregar jugador: " . mysqli_error($conn);
        }
    }
}
?>

<!-- Formulario para agregar un nuevo jugador -->
<form action="gestionarJugadores.php" method="post">

    <!-- Título del formulario -->
    <h1>Gestionar Jugadores</h1>

    <div class="field-row">

        <div class="field">
            <!-- Campo para ingresar el nombre -->
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="field">
            <!-- Campo para ingresar el apellido -->
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>

    </div>
    
    <div class="field">
        <!-- Campo para ingresar la cédula -->
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" maxlength="8" required>
    </div>
    
    <div class="field">
        <!-- Campo para seleccionar la fecha de nacimiento -->
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" min="2013-01-01" max="2020-12-31" required>
    </div>

    <div class="field-row">
        
        <div class="field">
            <!-- Campo para ingresar la masa -->
            <label for="masa">Peso:</label>
            <input type="number" id="masa" name="masa" required>
        </div>

        <div class="field">
            <!-- Campo para ingresar la altura -->
            <label for="altura">Altura:</label>
            <input type="number" step="0.01" id="altura" name="altura" required>
        </div>
    </div>

    <div class="field-row">

        <div class="field">
            <!-- Campo para seleccionar una categoría -->
            <label for="categorias">Categorias:</label>
            <select name="categorias" id="categorias" required>

            <!-- Opción inicial del menú desplegable -->
            <option value="">Seleccione una categoría</option>

            <!-- Recorre todas las categorías obtenidas de la base de datos -->
            <?php while ($filaCategorias = mysqli_fetch_assoc($resultadoCategorias)): ?>

                <!-- Muestra el ID y el año de cada categoría -->
                <option value="<?= htmlspecialchars($filaCategorias['id']) ?>"><?= htmlspecialchars($filaCategorias['año']) ?></option>

            <?php endwhile; ?>

            </select>
        </div>
        
        <div class="field">

            <!-- Campo para seleccionar un club -->
            <label for="club">Club:</label>
            <select name="club" id="club" required>

                <!-- Opción inicial del menú desplegable -->
                <option value="">Seleccione un club</option>

                <!-- Recorre todos los clubes obtenidos de la base de datos -->
                <?php while ($filaClubes = mysqli_fetch_assoc($resultadoClubes)): ?>

                    <!-- Muestra el ID y el nombre de cada club -->
                    <option value="<?= htmlspecialchars($filaClubes['id']) ?>"><?= htmlspecialchars($filaClubes['nombre']) ?></option>

                <?php endwhile; ?>

            </select>

        </div>
    </div>
  
    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Agregar Jugador">

</form>
