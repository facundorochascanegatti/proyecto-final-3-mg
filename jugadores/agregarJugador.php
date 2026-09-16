<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

$resultadoCategorias = mysqli_query($conn, "SELECT * FROM categorias");
$resultadoClubes = mysqli_query($conn, "SELECT * FROM club");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cedula = $_POST["cedula"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $categorias = $_POST["categorias"];
    $club = $_POST["club"];

    $sqlChequeo = "SELECT * FROM jugadores WHERE cedula = '$cedula'";
    $resultadoChequeo = mysqli_query($conn, $sqlChequeo);

    if (mysqli_num_rows($resultadoChequeo) > 0) {
        echo "Ya existe un jugador registrado con esa cédula.";
    } else {
        $sql = "INSERT INTO jugadores
                (nombre, apellido, cedula, fecha_nacimiento, id_categoria, id_club)
                VALUES ('$nombre', '$apellido', '$cedula', '$fecha_nacimiento', $categorias, $club)";

        if (mysqli_query($conn, $sql)) {
            header("Location: gestionarJugadores.php");
            exit();
        } else {
            echo "Error al agregar jugador: " . mysqli_error($conn);
        }
    }
}
?>

<form action="gestionarJugadores.php" method="post">
    <h1>Gestionar Jugadores</h1>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" required><br><br>
    <label for="cedula">Cédula:</label>
    <input type="text" id="cedula" name="cedula" required><br><br>
    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>
    <label for="categorias">Categorias:</label>
    <select name="categorias" id="categorias" required>
        <option value="">Seleccione una categoría</option>
        <?php while ($filaCategorias = mysqli_fetch_assoc($resultadoCategorias)): ?>
            <option value="<?= htmlspecialchars($filaCategorias['id']) ?>"><?= htmlspecialchars($filaCategorias['año']) ?></option>
        <?php endwhile; ?>
    </select><br><br>
    <label for="club">Club:</label>
    <select name="club" id="club" required>
        <option value="">Seleccione un club</option>
        <?php while ($filaClubes = mysqli_fetch_assoc($resultadoClubes)): ?>
            <option value="<?= htmlspecialchars($filaClubes['id']) ?>"><?= htmlspecialchars($filaClubes['nombre']) ?></option>
        <?php endwhile; ?>
    </select><br><br>
    <input type="submit" value="Agregar Jugador">
</form>