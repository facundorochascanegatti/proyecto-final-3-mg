<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirClub();

$miClub = (int) $_SESSION["id_club"];

// Por defecto se ve el propio club; se puede elegir otro club (solo lectura)
$verClub = isset($_GET["club"]) ? (int) $_GET["club"] : $miClub;
$verCat = isset($_GET["categoria"]) ? (int) $_GET["categoria"] : 0;

$clubes = mysqli_query($conn, "SELECT id, nombre FROM club ORDER BY nombre");
$categorias = mysqli_query($conn, "SELECT id, año FROM categorias ORDER BY año");

$club = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nombre FROM club WHERE id = $verClub"));

$donde = "";
if ($verCat > 0) {
    $donde = " AND jugadores.id_categoria = $verCat";
}

$sql = "SELECT jugadores.nombre, jugadores.apellido, jugadores.cedula, jugadores.fecha_nacimiento,
        categorias.año, carnets.foto, carnets.fecha_vencimiento
    FROM jugadores
    INNER JOIN categorias ON jugadores.id_categoria = categorias.id
    LEFT JOIN carnets ON carnets.id_jugador = jugadores.id
    WHERE jugadores.id_club = $verClub $donde
    ORDER BY categorias.año, jugadores.apellido";
$resultado = mysqli_query($conn, $sql);
$hoy = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugadores</title>
    <link rel="stylesheet" href="club.css">
    <script src="../js/buscador.js"></script>
</head>
<body>
<?php include "menu.php"; ?>
<main>
    <h1>Jugadores de <?= h($club["nombre"] ?? "-") ?></h1>
    <p class="subtitulo">Solo lectura<?= $verClub != $miClub ? " (estás viendo otro club)" : "" ?></p>

<!-- elegir el club y la categoría a ver (al cambiar se recarga la página) -->
<form method="get" class="filtros">
    <select name="club" onchange="this.form.submit()">
        <?php while ($c = mysqli_fetch_assoc($clubes)): ?>
            <option value="<?= $c["id"] ?>" <?= $c["id"] == $verClub ? "selected" : "" ?>><?= h($c["nombre"]) ?></option>
        <?php endwhile; ?>
    </select>
    <select name="categoria" onchange="this.form.submit()">
        <option value="0">Todas las categorías</option>
        <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
            <option value="<?= $cat["id"] ?>" <?= $cat["id"] == $verCat ? "selected" : "" ?>><?= h($cat["año"]) ?></option>
        <?php endwhile; ?>
    </select>
    <input type="text" id="buscador" placeholder="Buscar jugador...">
    <button type="button" onclick="window.print()">Imprimir lista</button>
</form>

    <div class="tabla-scroll">
    <table id="tablaJugadores">
        <tr>
            <th>Foto carnet</th>
            <th>Jugador</th>
            <th>Cédula</th>
            <th>Nacimiento</th>
            <th>Categoría</th>
            <th>Carnet de aptitud</th>
        </tr>
        <?php while ($j = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td>
                <?php if ($j["foto"]): ?>
                    <a href="carnets/fotos/<?= h($j["foto"]) ?>" target="_blank"><img class="foto" src="carnets/fotos/<?= h($j["foto"]) ?>" alt="carnet"></a>
                <?php else: ?>-<?php endif; ?>
            </td>
            <td><?= h($j["nombre"] . " " . $j["apellido"]) ?></td>
            <td><?= h($j["cedula"]) ?></td>
            <td><?= $j["fecha_nacimiento"] ? date("d/m/Y", strtotime($j["fecha_nacimiento"])) : "-" ?></td>
            <td><?= h($j["año"]) ?></td>
            <td>
                <?php if (!$j["fecha_vencimiento"]): ?>
                    <span class="mal">Sin carnet</span>
                <?php elseif ($j["fecha_vencimiento"] >= $hoy): ?>
                    <span class="ok">Vigente</span> (vence <?= date("d/m/Y", strtotime($j["fecha_vencimiento"])) ?>)
                <?php else: ?>
                    <span class="mal">Vencido</span> (<?= date("d/m/Y", strtotime($j["fecha_vencimiento"])) ?>)
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
        <?php if (mysqli_num_rows($resultado) == 0): ?>
            <tr><td colspan="6" class="vacio">No hay jugadores para mostrar.</td></tr>
        <?php endif; ?>
    </table>
    </div>
</main>
</body>
</html>
