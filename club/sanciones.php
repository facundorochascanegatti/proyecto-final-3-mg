<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirClub();

$miClub = (int) $_SESSION["id_club"];
$verCat = isset($_GET["categoria"]) ? (int) $_GET["categoria"] : 0;

$donde = "";
if ($verCat > 0) {
    $donde = " AND jugadores.id_categoria = $verCat";
}

// Acumulación de tarjetas por jugador (solo de mi club)
$acumulado = mysqli_query($conn, "SELECT jugadores.nombre, jugadores.apellido, categorias.año,
        SUM(sanciones.tipo = 'Amarilla') AS amarillas,
        SUM(sanciones.tipo = 'Roja') AS rojas
    FROM sanciones
    INNER JOIN jugadores ON sanciones.id_jugador = jugadores.id
    INNER JOIN categorias ON jugadores.id_categoria = categorias.id
    WHERE jugadores.id_club = $miClub $donde
    GROUP BY jugadores.id
    ORDER BY rojas DESC, amarillas DESC");

// Detalle de cada tarjeta
$detalle = mysqli_query($conn, "SELECT jugadores.nombre, jugadores.apellido, sanciones.tipo, sanciones.fecha, sanciones.motivo
    FROM sanciones
    INNER JOIN jugadores ON sanciones.id_jugador = jugadores.id
    WHERE jugadores.id_club = $miClub $donde
    ORDER BY sanciones.fecha DESC, sanciones.id DESC");

$categorias = mysqli_query($conn, "SELECT id, año FROM categorias ORDER BY año");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sanciones</title>
    <link rel="stylesheet" href="club.css">
</head>
<body>
<?php include "menu.php"; ?>
<main>
    <h1>Sanciones de mi club</h1>
    <p class="subtitulo">Solo lectura. Regla: 3 amarillas o 1 roja = suspendido</p>

    <form method="get" class="filtros">
        <select name="categoria">
            <option value="0">Todas las categorías</option>
            <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
                <option value="<?= $cat["id"] ?>" <?= $cat["id"] == $verCat ? "selected" : "" ?>>
                    <?= h($cat["año"]) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="submit" value="Filtrar">
        <button type="button" onclick="window.print()">Imprimir</button>
    </form>

    <div class="tarjeta">
        <h2>Acumulación por jugador</h2>
        <div class="tabla-scroll">
        <table>
            <tr><th>Jugador</th><th>Categoría</th><th>🟨 Amarillas</th><th>🟥 Rojas</th><th>Estado</th></tr>
            <?php while ($f = mysqli_fetch_assoc($acumulado)):
                $suspendido = $f["rojas"] > 0 || $f["amarillas"] >= 3; ?>
            <tr>
                <td><?= h($f["apellido"] . ", " . $f["nombre"]) ?></td>
                <td><?= h($f["año"]) ?></td>
                <td><?= (int) $f["amarillas"] ?></td>
                <td><?= (int) $f["rojas"] ?></td>
                <td class="<?= $suspendido ? "mal" : "ok" ?>"><?= $suspendido ? "Suspendido" : "Habilitado" ?></td>
            </tr>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($acumulado) == 0): ?>
                <tr><td colspan="5" class="vacio">Tu club no tiene tarjetas registradas.</td></tr>
            <?php endif; ?>
        </table>
        </div>
    </div>

    <div class="tarjeta">
        <h2>Detalle de tarjetas</h2>
        <div class="tabla-scroll">
        <table>
            <tr><th>Fecha</th><th>Jugador</th><th>Tarjeta</th><th>Motivo</th></tr>
            <?php while ($d = mysqli_fetch_assoc($detalle)): ?>
            <tr>
                <td><?= date("d/m/Y", strtotime($d["fecha"])) ?></td>
                <td><?= h($d["apellido"] . ", " . $d["nombre"]) ?></td>
                <td><?= $d["tipo"] == "Roja" ? "🟥 Roja" : "🟨 Amarilla" ?></td>
                <td><?= h($d["motivo"]) ?></td>
            </tr>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($detalle) == 0): ?>
                <tr><td colspan="4" class="vacio">Sin tarjetas.</td></tr>
            <?php endif; ?>
        </table>
        </div>
    </div>
</main>
</body>
</html>
