<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirClub();

$miClub = (int) $_SESSION["id_club"];

// Partidos donde juega mi club (como local o visitante)
$partidos = mysqli_query($conn, "SELECT partidos.*, local.nombre AS nombre_local, visitante.nombre AS nombre_visitante, categorias.año
    FROM partidos
    INNER JOIN club AS local ON partidos.id_club_local = local.id
    INNER JOIN club AS visitante ON partidos.id_club_visitante = visitante.id
    INNER JOIN categorias ON partidos.id_categoria = categorias.id
    WHERE partidos.id_club_local = $miClub OR partidos.id_club_visitante = $miClub
    ORDER BY partidos.fecha IS NULL, partidos.fecha ASC");

// Nombres lindos para los estados
$nombresEstado = [
    "sin_fecha" => "Sin fecha",
    "programado" => "Programado",
    "jugado" => "Jugado",
    "pendiente" => "Pendiente",
    "suspendido" => "Suspendido"
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partidos</title>
    <link rel="stylesheet" href="club.css">
</head>
<body>
<?php include "menu.php"; ?>
<main>
    <h1>Partidos de mi club</h1>
    <p class="subtitulo">Solo lectura</p>

    <div class="tabla-scroll">
    <table>
        <tr><th>Fecha</th><th>Local</th><th>Visitante</th><th>Categoría</th><th>Estado</th><th>Resultado</th></tr>
        <?php while ($p = mysqli_fetch_assoc($partidos)): ?>
        <tr>
            <td><?= $p["fecha"] ? date("d/m/Y", strtotime($p["fecha"])) : "Sin fecha" ?></td>
            <td><?= $p["id_club_local"] == $miClub ? "<b>" . h($p["nombre_local"]) . "</b>" : h($p["nombre_local"]) ?></td>
            <td><?= $p["id_club_visitante"] == $miClub ? "<b>" . h($p["nombre_visitante"]) . "</b>" : h($p["nombre_visitante"]) ?></td>
            <td><?= h($p["año"]) ?></td>
            <td><?= h($nombresEstado[$p["estado"]] ?? $p["estado"]) ?></td>
            <td><?= ($p["goles_local"] === null || $p["goles_visitante"] === null) ? "-" : (int) $p["goles_local"] . " - " . (int) $p["goles_visitante"] ?></td>
        </tr>
        <?php endwhile; ?>
        <?php if (mysqli_num_rows($partidos) == 0): ?>
            <tr><td colspan="6" class="vacio">Tu club no tiene partidos cargados.</td></tr>
        <?php endif; ?>
    </table>
    </div>
</main>
</body>
</html>
