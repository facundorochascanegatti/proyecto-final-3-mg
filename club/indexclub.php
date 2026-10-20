<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirClub();

$miClub = (int) $_SESSION["id_club"];

// Datos del club
$club = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM club WHERE id = $miClub"));

// Cantidad de jugadores
$totalJugadores = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jugadores WHERE id_club = $miClub"))["total"];

// Jugadores con carnet vigente
$vigentes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jugadores
    INNER JOIN carnets ON carnets.id_jugador = jugadores.id
    WHERE jugadores.id_club = $miClub AND carnets.fecha_vencimiento >= CURDATE()"))["total"];

// Jugadores suspendidos (3 amarillas o 1 roja)
$suspendidos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM (
    SELECT sanciones.id_jugador FROM sanciones
    INNER JOIN jugadores ON sanciones.id_jugador = jugadores.id
    WHERE jugadores.id_club = $miClub
    GROUP BY sanciones.id_jugador
    HAVING SUM(sanciones.tipo = 'Roja') > 0 OR SUM(sanciones.tipo = 'Amarilla') >= 3) AS s"))["total"];

// Próximos partidos programados
$partidos = mysqli_query($conn, "SELECT partidos.fecha, local.nombre AS nombre_local, visitante.nombre AS nombre_visitante, categorias.año
    FROM partidos
    INNER JOIN club AS local ON partidos.id_club_local = local.id
    INNER JOIN club AS visitante ON partidos.id_club_visitante = visitante.id
    INNER JOIN categorias ON partidos.id_categoria = categorias.id
    WHERE (partidos.id_club_local = $miClub OR partidos.id_club_visitante = $miClub)
    AND partidos.estado = 'programado'
    ORDER BY partidos.fecha ASC LIMIT 3");

// Últimos avisos
$avisos = mysqli_query($conn, "SELECT * FROM avisos ORDER BY fecha DESC, id DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del club</title>
    <link rel="stylesheet" href="club.css">
</head>
<body>
<?php include "menu.php"; ?>
<main>
    <h1>Bienvenido, <?= h($club["nombre"]) ?></h1>
    <p class="subtitulo">Panel de tu club</p>

    <div class="grilla">
        <div class="tarjeta"><div class="numero"><?= $totalJugadores ?></div>Jugadores</div>
        <div class="tarjeta"><div class="numero ok"><?= $vigentes ?></div>Con carnet vigente</div>
        <div class="tarjeta"><div class="numero mal"><?= $suspendidos ?></div>Suspendidos</div>
    </div>

    <div class="tarjeta">
        <h2>Próximos partidos</h2>
        <?php if (mysqli_num_rows($partidos) == 0): ?>
            <p class="vacio">No hay partidos programados.</p>
        <?php else: ?>
            <?php while ($p = mysqli_fetch_assoc($partidos)): ?>
                <p><b><?= h($p["nombre_local"]) ?></b> vs <b><?= h($p["nombre_visitante"]) ?></b>
                   - Categoría <?= h($p["año"]) ?> - <?= date("d/m/Y", strtotime($p["fecha"])) ?></p>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <div class="tarjeta">
        <h2>Últimos avisos</h2>
        <?php if (mysqli_num_rows($avisos) == 0): ?>
            <p class="vacio">No hay avisos publicados.</p>
        <?php else: ?>
            <?php while ($a = mysqli_fetch_assoc($avisos)): ?>
                <div class="aviso">
                    <b><?= h($a["titulo"]) ?></b> <small><?= date("d/m/Y", strtotime($a["fecha"])) ?></small>
                    <div><?= nl2br(h($a["contenido"])) ?></div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
