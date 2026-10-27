<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();

$conn = mysqli_connect("localhost", "root", "", "liga");

// Filtros
$club = (int) ($_GET["club"] ?? 0);
$categoria = (int) ($_GET["categoria"] ?? 0);

$filtro = "";

if ($club > 0) {
    $filtro .= " AND jugadores.id_club = $club";
}

if ($categoria > 0) {
    $filtro .= " AND jugadores.id_categoria = $categoria";
}

// Buscar sanciones de cada jugador
$sql = "SELECT jugadores.id, jugadores.nombre, jugadores.apellido,
        club.nombre AS club, categorias.año,
        SUM(sanciones.tipo = 'Amarilla') AS amarillas,
        SUM(sanciones.tipo = 'Roja') AS rojas
        FROM sanciones
        INNER JOIN jugadores ON sanciones.id_jugador = jugadores.id
        INNER JOIN club ON jugadores.id_club = club.id
        INNER JOIN categorias ON jugadores.id_categoria = categorias.id
        WHERE 1 $filtro
        GROUP BY jugadores.id
        ORDER BY rojas DESC, amarillas DESC";

$resultado = mysqli_query($conn, $sql);

// Datos para los filtros
$clubes = mysqli_query($conn, "SELECT * FROM club");
$categorias = mysqli_query($conn, "SELECT * FROM categorias");
?>

<h1 class="tituloSeccion">Sanciones por jugador</h1>
<p class="subtitulo">3 amarillas o 1 roja = suspendido</p>

<form action="gestionarSanciones.php" method="get" class="filtros">

    <select name="club">
        <option value="0">Todos los clubes</option>

        <?php while ($c = mysqli_fetch_assoc($clubes)) { ?>
            <option value="<?= $c['id'] ?>"
                <?= $club == $c['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['nombre']) ?>
            </option>
        <?php } ?>
    </select>

    <select name="categoria">
        <option value="0">Todas las categorías</option>

        <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
            <option value="<?= $cat['id'] ?>"
                <?= $categoria == $cat['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['año']) ?>
            </option>
        <?php } ?>
    </select>

    <input type="submit" value="Filtrar">
</form>

<div class="Tabla">
<table class="tablaClubes">
    <tr>
        <th>Jugador</th>
        <th>Club</th>
        <th>Categoría</th>
        <th>Amarillas</th>
        <th>Rojas</th>
        <th>Estado</th>
        <th>Acción</th>
    </tr>

    <?php
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {

            $suspendido = $fila["rojas"] > 0 || $fila["amarillas"] >= 3;

            echo "<tr>";

            echo "<td>" . htmlspecialchars($fila["nombre"] . "  " . $fila["apellido"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["club"]) . "</td>";
            echo "<td>" . htmlspecialchars($fila["año"]) . "</td>";
            echo "<td>" . $fila["amarillas"] . "</td>";
            echo "<td>" . $fila["rojas"] . "</td>";

            if ($suspendido) {
                echo "<td class='suspendido'>Suspendido</td>";
            } else {
                echo "<td class='habilitado'>Habilitado</td>";
            }

            echo "<td>
                <a href='eliminarSancion.php?jugador=" . $fila["id"] . "'
                onclick=\"return confirm('¿Quitar la última tarjeta de este jugador?')\">
                Quitar última</a>
                </td>";

            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7' class='vacio'>
        Todavía no hay tarjetas registradas.
        </td></tr>";
    }
    ?>
</table>
</div>