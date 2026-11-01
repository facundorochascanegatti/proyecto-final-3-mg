
<?php
// Incluye la conexión a la base de datos.
require_once __DIR__ . "/../conexion.php";

// Incluye las funciones de seguridad y verifica que el usuario sea un club.
require_once __DIR__ . "/../auth.php";
requerirClub();

// Obtiene el ID del club que inició sesión.
$miClub = (int) $_SESSION["id_club"];

// Busca los datos del club en la base de datos.
// el msqli_fetch_assoc(msqly_query) 
$club = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM club WHERE id = $miClub"));

// Cuenta la cantidad total de jugadores que tiene el club.
$totalJugadores = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jugadores WHERE id_club = $miClub"))["total"];

// Cuenta los jugadores que tienen un carnet vigente.
// Para eso comprueba que la fecha de vencimiento sea mayor o igual a la fecha actual.
$vigentes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM jugadores
    INNER JOIN carnets ON carnets.id_jugador = jugadores.id
    WHERE jugadores.id_club = $miClub AND carnets.fecha_vencimiento >= CURDATE()"))["total"];

// Cuenta los jugadores suspendidos.
// Un jugador queda suspendido si tiene al menos una tarjeta roja o tres amarillas.
$suspendidos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM (
    SELECT sanciones.id_jugador FROM sanciones
    INNER JOIN jugadores ON sanciones.id_jugador = jugadores.id
    WHERE jugadores.id_club = $miClub
    GROUP BY sanciones.id_jugador
    HAVING SUM(sanciones.tipo = 'Roja') > 0 OR SUM(sanciones.tipo = 'Amarilla') >= 3) AS s"))["total"];

// Busca los próximos tres partidos programados del club.
// Obtiene los nombres de los dos clubes, la categoría y la fecha.
// Los ordena desde el partido más próximo al más lejano.
$partidos = mysqli_query($conn, "SELECT partidos.fecha, local.nombre AS nombre_local, visitante.nombre AS nombre_visitante, categorias.año
    FROM partidos
    INNER JOIN club AS local ON partidos.id_club_local = local.id
    INNER JOIN club AS visitante ON partidos.id_club_visitante = visitante.id
    INNER JOIN categorias ON partidos.id_categoria = categorias.id
    WHERE (partidos.id_club_local = $miClub OR partidos.id_club_visitante = $miClub)
    AND partidos.estado = 'programado'
    ORDER BY partidos.fecha ASC LIMIT 3");

// Busca los últimos tres avisos publicados.
// Los ordena desde el más reciente al más antiguo.
$avisos = mysqli_query($conn, "SELECT * FROM avisos ORDER BY fecha DESC, id DESC LIMIT 3");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <!-- Permite que la página se adapte al tamaño de la pantalla del dispositivo. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel del club</title>

    <!-- Conecta el archivo CSS que contiene los estilos de esta página. -->
    <link rel="stylesheet" href="club.css">
</head>
<body>

<!-- Incluye el menú de navegación del club. -->
<?php include "menu.php"; ?>

<main>

    <!-- Muestra el nombre del club que inició sesión. -->
    <h1>Bienvenido, <?= h($club["nombre"]) ?></h1>

    <!-- Subtítulo del panel. -->
    <p class="subtitulo">Panel de tu club</p>

    <!-- Tarjeta que muestra los últimos avisos publicados. -->
    <div class="tarjeta">
        <h2>Últimos avisos</h2>

        <!-- Comprueba si existen avisos publicados. -->
        <?php if (mysqli_num_rows($avisos) == 0): ?>

            <!-- Si no hay avisos, muestra un mensaje. -->
            <p class="vacio">No hay avisos publicados.</p>

        <?php else: ?>

            <!-- Recorre los avisos y muestra su título, fecha y contenido. -->
            <?php while ($a = mysqli_fetch_assoc($avisos)): ?>
                <div class="aviso">

                    <!-- Muestra el título y la fecha del aviso. -->
                    <b><?= h($a["titulo"]) ?></b>
                    <small><?= date("d/m/Y", strtotime($a["fecha"])) ?></small>

                    <!-- Muestra el contenido y conserva los saltos de línea. -->
                    <div><?= nl2br(h($a["contenido"])) ?></div>

                </div>
            <?php endwhile; ?>

        <?php endif; ?>
    </div>

    <!-- Tarjeta que muestra los próximos partidos del club. -->
    <div class="tarjeta">
        <h2>Próximos partidos</h2>

        <!-- Comprueba si el club tiene partidos programados. -->
        <?php if (mysqli_num_rows($partidos) == 0): ?>

            <!-- Si no hay partidos, muestra un mensaje. -->
            <p class="vacio">No hay partidos programados.</p>

        <?php else: ?>

            <!-- Recorre los partidos encontrados y muestra sus datos. -->
            <?php while ($p = mysqli_fetch_assoc($partidos)): ?>
                <p>
                    <b><?= h($p["nombre_local"]) ?></b> vs
                    <b><?= h($p["nombre_visitante"]) ?></b>
                    - Categoría <?= h($p["año"]) ?>
                    - <?= date("d/m/Y", strtotime($p["fecha"])) ?>
                </p>
            <?php endwhile; ?>

        <?php endif; ?>
    </div>

    <!-- Grilla que organiza las estadísticas principales del club. -->
    <div class="grilla">

        <!-- Muestra la cantidad total de jugadores. -->
        <div class="tarjeta">
            <div class="numero"><?= $totalJugadores ?></div>
            Jugadores
        </div>

        <!-- Muestra la cantidad de jugadores con carnet vigente. -->
        <div class="tarjeta">
            <div class="numero ok"><?= $vigentes ?></div>
            Con carnet vigente
        </div>

        <!-- Muestra la cantidad de jugadores suspendidos. -->
        <div class="tarjeta">
            <div class="numero mal"><?= $suspendidos ?></div>
            Suspendidos
        </div>
    </div>
</main>
</body>
</html>
