
<?php
require_once __DIR__ . "/../conexion.php";

$resultadoClubes = mysqli_query($conn, "SELECT * FROM club WHERE activo = 1");
$resultadoCategorias = mysqli_query($conn, "SELECT * FROM categorias");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $local = (int) $_POST["EquipoLocal"];
    $visitante = (int) $_POST["EquipoVisitante"];
    $categoria = (int) $_POST["Categoria"];
    $fecha = $_POST["fecha"];
    $golesLocal = $_POST["goles_local"];
    $golesVisitante = $_POST["goles_visitante"];

    if ($local == $visitante) {
        echo "<p>Los dos clubes no pueden ser el mismo.</p>";
    } else {
        if ($fecha == "") {
            $fechaSQL = "NULL";
            $estado = "sin_fecha";
        } else {
            $fechaSQL = "'" . mysqli_real_escape_string($conn, $fecha) . "'";
            $estado = "programado";
        }

        $sql = "INSERT INTO partidos
                (id_club_local, id_club_visitante, id_categoria, fecha, estado, goles_local, goles_visitante)
                VALUES
                ($local, $visitante, $categoria, $fechaSQL, '$estado', $golesLocal, $golesVisitante)";

        if (mysqli_query($conn, $sql)) {
            header("Location: gestionarPartidos.php");
            exit();
        } else {
            echo "<p>Error al agregar el partido: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<div class="Casilla">
    <form action="gestionarPartidos.php" method="post">
        <h1 class="tituloPartidos">Agregar partido</h1>

        <label for="EquipoLocal">Club local:</label>
        <select name="EquipoLocal" id="EquipoLocal" required>
            <option value="">Seleccione un club</option>
            <?php while ($club = mysqli_fetch_assoc($resultadoClubes)) { ?>
                <option value="<?php echo $club['id']; ?>">
                    <?php echo htmlspecialchars($club['nombre']); ?>
                </option>
            <?php } ?>
        </select>

        <?php
        $resultadoVisitante = mysqli_query($conn, "SELECT * FROM club WHERE activo = 1");
        ?>

        <label for="EquipoVisitante">Club visitante:</label>
        <select name="EquipoVisitante" id="EquipoVisitante" required>
            <option value="">Seleccione un club</option>
            <?php while ($club = mysqli_fetch_assoc($resultadoVisitante)) { ?>
                <option value="<?php echo $club['id']; ?>">
                    <?php echo htmlspecialchars($club['nombre']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="Categoria">Categoría:</label>
        <select name="Categoria" id="Categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php while ($categoria = mysqli_fetch_assoc($resultadoCategorias)) { ?>
                <option value="<?php echo $categoria['id']; ?>">
                    <?php echo htmlspecialchars($categoria['año']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha (opcional):</label>
        <input type="date" name="fecha" id="fecha">

        <label for="golesLocal">Goles del club local:</label>
        <input type="number" name="goles_local" id="golesLocal" min="0">

        <label for="golesVisitante">Goles del club visitante:</label>
        <input type="number" name="goles_visitante" id="golesVisitante" min="0">

        <input class="Agregar" type="submit" value="Agregar partido">
    </form>
</div>
