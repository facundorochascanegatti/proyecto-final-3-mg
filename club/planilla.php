<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirClub();

$idClub = (int) $_SESSION["id_club"];
$idCat = isset($_GET["categoria"]) ? (int) $_GET["categoria"] : 0;

$club = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nombre, logo FROM club WHERE id = $idClub"));
$categorias = mysqli_query($conn, "SELECT id, año FROM categorias ORDER BY año");

$cat = null;
if ($idCat > 0) {
    $cat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT año FROM categorias WHERE id = $idCat"));
}

$esMenor = $cat && $cat["año"] >= 2013 && $cat["año"] <= 2016;

$titulares = $esMenor ? 9 : 11;
$suplentes = $esMenor ? 9 : 8;

function filas($cantidad) {
    for ($i = 1; $i <= $cantidad; $i++) {
        echo "<tr><td>$i</td><td></td><td></td></tr>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planilla de equipo</title>
    <link rel="stylesheet" href="club.css">
</head>
<body>
<?php include "menu.php"; ?>

<main>
    <h1>Planilla de titulares y suplentes</h1>
    <p class="subtitulo">Elegí la categoría y presioná imprimir</p>

    <form method="get" class="filtros">
        <select name="categoria" required>
            <option value="">Seleccione una categoría</option>
            <?php while ($c = mysqli_fetch_assoc($categorias)) { ?>
                <option value="<?= $c["id"] ?>">
                    <?= h($c["año"]) ?>
                </option>
            <?php } ?>
        </select>
        <input type="submit" value="Generar planilla">

        <?php if ($cat) { ?>
            <button type="button" onclick="window.print()">Imprimir</button>
        <?php } ?>
    </form>

    <?php if ($cat) { ?>

    <div class="hoja">
        <div class="encabezado">
            <?php if ($club["logo"]) { ?>
                <img src="../clubes/logos/<?= h($club["logo"]) ?>" alt="logo">
            <?php } ?>

            <div>
                <h2><?= h($club["nombre"]) ?></h2>
                <h3>Categoría: <?= h($cat["año"]) ?></h3>
            </div>
        </div>

        <p>Técnico: <span class="linea"></span> Ayudante técnico: <span class="linea"></span></p>
        <p>Kinesiólogo: <span class="linea"></span> Delegado: <span class="linea"></span></p>

        <h3>Titulares (<?= $titulares ?>)</h3>
        <table>
            <tr><th>N°</th><th>Nombre y apellido</th><th>Cédula</th></tr>
            <?php filas($titulares); ?>
        </table>

        <h3>Suplentes <?= $esMenor ? "(cambios libres)" : "(6 cambios + 2 en el entretiempo)" ?></h3>
        <table>
            <tr><th>N°</th><th>Nombre y apellido</th><th>Cédula</th></tr>
            <?php filas($suplentes); ?>
        </table>
    </div>

    <div class="hoja">
        <h2><?= h($club["nombre"]) ?> - <?= h($cat["año"]) ?> (dorso)</h2>

        <h3>Observaciones del árbitro</h3>
        <div class="caja"></div>

        <h3>Cambios</h3>
        <table>
            <tr><th>Minuto</th><th>Sale</th><th>Entra</th></tr>
            <?php for ($i = 0; $i < 8; $i++) { ?>
                <tr><td></td><td></td><td></td></tr>
            <?php } ?>
        </table>

        <h3>Tarjetas</h3>
        <table>
            <tr><th>Jugador</th><th>Amarilla / Roja</th><th>Minuto</th></tr>
            <?php for ($i = 0; $i < 4; $i++) { ?>
                <tr><td></td><td></td><td></td></tr>
            <?php } ?>
        </table>

        <p><b>Resultado:</b> <?= h($club["nombre"]) ?>
            <span class="linea"></span> - <span class="linea"></span> Rival
        </p>

        <div class="firmas">
            <div>Firma del delegado</div>
            <div>Firma del árbitro</div>
        </div>
    </div>

    <?php } ?>
</main>
</body>
</html>