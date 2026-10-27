<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>

<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/validarPartido.php";

$resultadoClubes = mysqli_query($conn, "SELECT * FROM club WHERE activo = 1");
$resultadoCategorias = mysqli_query($conn, "SELECT * FROM categorias");
$resultadoCompeticiones = mysqli_query($conn, "SELECT * FROM competicion");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $local = (int) $_POST["EquipoLocal"];
    $visitante = (int) $_POST["EquipoVisitante"];
    $categoria = (int) $_POST["Categoria"];
    $competicion = (int) $_POST["Competicion"];
    $fecha = $_POST["fecha"];
    $golesLocal = trim($_POST["goles_local"]);
    $golesVisitante = trim($_POST["goles_visitante"]);

    // si no cargó los goles, se guardan como NULL
    if ($golesLocal == "" || $golesVisitante == "") {
        $golesLocalSQL = "NULL";
        $golesVisitanteSQL = "NULL";
    } else {
        $golesLocalSQL = (int) $golesLocal;
        $golesVisitanteSQL = (int) $golesVisitante;
    }

    // el estado sale solo: sin fecha, programado, o jugado si ya se cargaron los goles
    if ($fecha == "") {
        $estado = "sin_fecha";
    } elseif ($golesLocal != "" || $golesVisitante != "") {
        $estado = "jugado";
    } else {
        $estado = "programado";
    }

    // revisa clubes, fecha, estado y goles (está en validarPartido.php)
    $error = validarPartido($local, $visitante, $fecha, $estado, $golesLocal, $golesVisitante);

    if ($error != "") {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    } else {
        if ($fecha == "") {
            $fechaSQL = "NULL";
        } else {
            $fechaSQL = "'" . mysqli_real_escape_string($conn, $fecha) . "'";
        }

        $sql = "INSERT INTO partidos
                (id_club_local, id_club_visitante, id_categoria, id_competicion, fecha, estado, goles_local, goles_visitante)
                VALUES
                ($local, $visitante, $categoria, $competicion, $fechaSQL, '$estado', $golesLocalSQL, $golesVisitanteSQL)";

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

        <label for="Competicion">Competición:</label>
        <select name="Competicion" id="Competicion" required>
            <?php while ($competicion = mysqli_fetch_assoc($resultadoCompeticiones)) { ?>
                <option value="<?php echo $competicion['id']; ?>">
                    <?php echo htmlspecialchars($competicion['nombre']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha (opcional):</label>
        <input type="date" name="fecha" id="fecha">

        <label for="golesLocal">Goles del club local (solo si ya se jugó):</label>
        <input type="number" name="goles_local" id="golesLocal" min="0">

        <label for="golesVisitante">Goles del club visitante (solo si ya se jugó):</label>
        <input type="number" name="goles_visitante" id="golesVisitante" min="0">

        <input class="Agregar" type="submit" value="Agregar partido">
    </form>
</div>
