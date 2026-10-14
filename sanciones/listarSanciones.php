<?php
// Conexión a la base de datos "liga"
$conn = mysqli_connect("localhost", "root", "", "liga");

// Filtros por club y por categoría (si vienen vacíos se muestra todo)
$filtroClub = isset($_GET["club"]) ? (int)$_GET["club"] : 0;
$filtroCategoria = isset($_GET["categoria"]) ? (int)$_GET["categoria"] : 0;

$donde = "";
if ($filtroClub > 0) { $donde .= " AND jugadores.id_club = $filtroClub"; }
if ($filtroCategoria > 0) { $donde .= " AND jugadores.id_categoria = $filtroCategoria"; }

// ACUMULACIÓN: cuántas amarillas y rojas tiene cada jugador.
// Regla de la liga: 3 amarillas o 1 roja = suspendido.
$sqlAcumulado = "SELECT jugadores.id, jugadores.nombre, jugadores.apellido, club.nombre AS club, categorias.año,
        SUM(sanciones.tipo = 'Amarilla') AS amarillas,
        SUM(sanciones.tipo = 'Roja') AS rojas
    FROM sanciones
    INNER JOIN jugadores ON sanciones.id_jugador = jugadores.id
    INNER JOIN club ON jugadores.id_club = club.id
    INNER JOIN categorias ON jugadores.id_categoria = categorias.id
    WHERE 1 $donde
    GROUP BY jugadores.id
    ORDER BY rojas DESC, amarillas DESC";
$resultadoAcumulado = mysqli_query($conn, $sqlAcumulado);

// Clubes y categorías para los filtros
$resultadoClubes = mysqli_query($conn, "SELECT * FROM club");
$resultadoCategorias = mysqli_query($conn, "SELECT * FROM categorias");
?>

<h1 class="tituloSeccion">Sanciones por jugador</h1>
<p class="subtitulo">3 amarillas o 1 roja = suspendido</p>

<!-- Filtros por club y categoría -->
<form action="gestionarSanciones.php" method="get" class="filtros">
    <select name="club">
        <option value="0">Todos los clubes</option>
        <?php while ($c = mysqli_fetch_assoc($resultadoClubes)): ?>
            <option value="<?= $c['id'] ?>" <?= $c['id'] == $filtroClub ? 'selected' : '' ?>><?= htmlspecialchars($c['nombre']) ?></option>
        <?php endwhile; ?>
    </select>
    <select name="categoria">
        <option value="0">Todas las categorías</option>
        <?php while ($cat = mysqli_fetch_assoc($resultadoCategorias)): ?>
            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $filtroCategoria ? 'selected' : '' ?>><?= htmlspecialchars($cat['año'] . " " . $cat['genero']) ?></option>
        <?php endwhile; ?>
    </select>
    <input type="submit" value="Filtrar">
</form>

<!-- Tabla con la acumulación de tarjetas -->
<div class="Tabla">
<table class="tablaClubes">
    <tr>
        <th>Jugador</th>
        <th>Club</th>
        <th>Categoría</th>
        <th>Amarillas</th>
        <th>Rojas</th>
        <th>Estado</th>
        <th><i class="fa-solid fa-rotate-left"></i></th>
    </tr>
    <?php
    while ($fila = mysqli_fetch_assoc($resultadoAcumulado)) {
        // 3 amarillas o una roja: no puede jugar
        $suspendido = $fila["rojas"] > 0 || $fila["amarillas"] >= 3;
        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila["apellido"] . ", " . $fila["nombre"]) . "</td>";
        echo "<td>" . htmlspecialchars($fila["club"]) . "</td>";
        echo "<td>" . htmlspecialchars($fila["año"]) . "</td>";
        echo "<td>" . $fila["amarillas"] . "</td>";
        echo "<td>" . $fila["rojas"] . "</td>";
        echo "<td class='" . ($suspendido ? "suspendido" : "habilitado") . "'>" . ($suspendido ? "Suspendido" : "Habilitado") . "</td>";
        // por si se cargó una tarjeta por error: borra la última de ese jugador
        echo "<td><a href='eliminarSancion.php?jugador=" . $fila["id"] . "' onclick=\"return confirm('¿Quitar la última tarjeta de este jugador?')\">Quitar última</a></td>";
        echo "</tr>";
    }
    // si no hay ninguna tarjeta (o ninguna con ese filtro)
    if (mysqli_num_rows($resultadoAcumulado) == 0) {
        echo "<tr><td colspan='7' class='vacio'>Todavía no hay tarjetas registradas.</td></tr>";
    }
    ?>
</table>
</div>

