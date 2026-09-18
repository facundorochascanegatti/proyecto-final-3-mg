<?php
// Conexión a la base de datos "liga"
$conn = mysqli_connect("localhost", "root", "", "liga");

// Consulta para obtener todas las categorías
$resultadoCategorias = mysqli_query($conn, "SELECT * FROM categorias");

// Consulta para obtener todos los clubes
$resultadoClubes = mysqli_query($conn, "SELECT * FROM club");

// Verifica si el formulario fue enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // esto obtiene los datos enviados desde el formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cedula = $_POST["cedula"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $categorias = $_POST["categorias"];
    $club = $_POST["club"];
    // aca abajo se calcula la parte de fisica, lo de mecanica clasica.
    $gravedad = 9.8;
    $masa = $_POST["masa"];
    $altura = $_POST["altura"];
    $velocidad = $_POST["velocidad"];

    // Consulta para verificar si ya existe un jugador con esa cédula
    $sqlChequeo = "SELECT * FROM jugadores WHERE cedula = '$cedula'";

    // Ejecuta la consulta de verificación
    $resultadoChequeo = mysqli_query($conn, $sqlChequeo);

    // Comprueba si se encontró algún jugador con esa cédula
    if (mysqli_num_rows($resultadoChequeo) > 0) {

        // Muestra un mensaje indicando que la cédula ya está registrada
        echo "Ya existe un jugador registrado con esa cédula.";

    } else {

        // Consulta SQL para insertar un nuevo jugador
        $sql = "INSERT INTO jugadores
                (nombre, apellido, cedula, fecha_nacimiento, id_categoria, id_club, masa, altura, peso, velocidad)
                VALUES ('$nombre', '$apellido', '$cedula', '$fecha_nacimiento', $categorias, $club, $masa, $altura, $masa * $gravedad, $velocidad)";

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

    <!-- Campo para ingresar el nombre -->
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <!-- Campo para ingresar el apellido -->
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" required><br><br>
    
    <!-- Campo para ingresar la cédula -->
    <label for="cedula">Cédula:</label>
    <input type="text" id="cedula" name="cedula" required><br><br>

    <!-- Campo para seleccionar la fecha de nacimiento -->
    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>

    <label for="masa">Masa:</label>
    <input type="text" id="masa" name="masa" required><br>

    <label for="altura">Altura:</label>
    <input type="text" id="altura" name="altura" required><br>

    <label for="velocidad">Velocidad:</label>
    <input type="text" id="velocidad" name="velocidad" required><br><br>

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

    </select><br><br>

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

    </select><br><br>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Agregar Jugador">

</form>