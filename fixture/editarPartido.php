
<?php
require_once __DIR__ . "/../conexion.php";

if (!isset($_GET["id"])) {
    header("Location: gestionarPartidos.php");
    exit();
}

$id = (int) $_GET["id"];

$sql = "SELECT * FROM partidos WHERE id = $id";
$resultado = mysqli_query($conn, $sql);
$partido = mysqli_fetch_assoc($resultado);

if (!$partido) {
    echo "No se encontró el partido.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $local = (int) $_POST["EquipoLocal"];
    $visitante = (int) $_POST["EquipoVisitante"];
    $categoria = (int) $_POST["Categoria"];
    $fecha = $_POST["fecha"];
    $estado = $_POST["estado"];
    $golesLocal = $_POST["goles_local"];
    $golesVisitante = $_POST["goles_visitante"];

    if ($local == $visitante) {
        $mensaje = "Los dos clubes no pueden ser el mismo.";
    } else {
        if ($fecha == "") {
            $fechaSQL = "NULL";

            if ($estado == "programado") {
                $estado = "sin_fecha";
            }
        } else {
            $fechaSQL = "'" . mysqli_real_escape_string($conn, $fecha) . "'";
        }

        if ($golesLocal == "" || $golesVisitante == "") {
            $golesLocalSQL = "NULL";
            $golesVisitanteSQL = "NULL";
        } else {
            $golesLocalSQL = (int) $golesLocal;
            $golesVisitanteSQL = (int) $golesVisitante;
        }

        $estado = mysqli_real_escape_string($conn, $estado);

        $sql = "UPDATE partidos SET
                id_club_local = $local,
                id_club_visitante = $visitante,
                id_categoria = $categoria,
                fecha = $fechaSQL,
                estado = '$estado',
                goles_local = $golesLocalSQL,
                goles_visitante = $golesVisitanteSQL
                WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            header("Location: gestionarPartidos.php");
            exit();
        } else {
            $mensaje = "Error al modificar: " . mysqli_error($conn);
        }
    }
}

$resultadoClubes = mysqli_query($conn, "SELECT * FROM club WHERE activo = 1");
$resultadoCategorias = mysqli_query($conn, "SELECT * FROM categorias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar partido</title>
    <link rel="stylesheet" href="partidos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<header>
    <nav>
        <a href="gestionarPartidos.php">Volver a partidos</a>
        <a href="../admin/indexadmin.php" class="home">
            <i class="fa-solid fa-house"></i>
        </a>
    </nav>
</header>

<div class="Casilla">
    <form action="editarPartido.php?id=<?php echo $id; ?>" method="post">
        <h1 class="tituloPartidos">Editar partido</h1>

        <?php
        if (isset($mensaje)) {
            echo "<p>" . htmlspecialchars($mensaje) . "</p>";
        }
        ?>

        <label for="EquipoLocal">Club local:</label>
        <select name="EquipoLocal" id="EquipoLocal" required>
            <?php while ($club = mysqli_fetch_assoc($resultadoClubes)) { ?>
                <option value="<?php echo $club['id']; ?>"
                    <?php if ($club['id'] == $partido['id_club_local']) {
                        echo "selected";
                    } ?>>
                    <?php echo htmlspecialchars($club['nombre']); ?>
                </option>
            <?php } ?>
        </select>

        <?php
        $resultadoClubes = mysqli_query($conn, "SELECT * FROM club WHERE activo = 1");
        ?>

        <label for="EquipoVisitante">Club visitante:</label>
        <select name="EquipoVisitante" id="EquipoVisitante" required>
            <?php while ($club = mysqli_fetch_assoc($resultadoClubes)) { ?>
                <option value="<?php echo $club['id']; ?>"
                    <?php if ($club['id'] == $partido['id_club_visitante']) {
                        echo "selected";
                    } ?>>
                    <?php echo htmlspecialchars($club['nombre']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="Categoria">Categoría:</label>
        <select name="Categoria" id="Categoria" required>
            <?php while ($categoria = mysqli_fetch_assoc($resultadoCategorias)) { ?>
                <option value="<?php echo $categoria['id']; ?>"
                    <?php if ($categoria['id'] == $partido['id_categoria']) {
                        echo "selected";
                    } ?>>
                    <?php echo htmlspecialchars($categoria['año']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha"
            value="<?php
            if ($partido['fecha'] != NULL) {
                echo htmlspecialchars($partido['fecha']);
            }
            ?>">

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <?php
            $estados = array(
                "sin_fecha",
                "programado",
                "jugado",
                "pendiente",
                "suspendido"
            );

            foreach ($estados as $opcion) {
                if ($opcion == $partido['estado']) {
                    echo "<option value='$opcion' selected>$opcion</option>";
                } else {
                    echo "<option value='$opcion'>$opcion</option>";
                }
            }
            ?>
        </select>

        <label for="goles_local">Goles del club local:</label>
        <input type="number" min="0" name="goles_local" id="goles_local"
            value="<?php
            if ($partido['goles_local'] !== NULL) {
                echo $partido['goles_local'];
            }
            ?>">

        <label for="goles_visitante">Goles del club visitante:</label>
        <input type="number" min="0" name="goles_visitante" id="goles_visitante"
            value="<?php
            if ($partido['goles_visitante'] !== NULL) {
                echo $partido['goles_visitante'];
            }
            ?>">

        <input class="Agregar" type="submit" value="Guardar cambios">
    </form>
</div>

</body>
</html>
