<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirClub();

$avisos = mysqli_query($conn, "SELECT * FROM avisos ORDER BY fecha DESC, id DESC");
$boletines = mysqli_query($conn, "SELECT * FROM boletines ORDER BY fecha DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avisos y boletines</title>
    <link rel="stylesheet" href="club.css">
</head>
<body>
<?php include "menu.php"; ?>
<main>
    <h1>Avisos y boletines</h1>
    <p class="subtitulo">Publicados por la liga (solo lectura)</p>

    <div class="tarjeta">
        <h2>Avisos</h2>
        <?php while ($a = mysqli_fetch_assoc($avisos)): ?>
            <div class="aviso">
                <b><?= h($a["titulo"]) ?></b> <small><?= date("d/m/Y", strtotime($a["fecha"])) ?></small>
                <div><?= nl2br(h($a["contenido"])) ?></div>
            </div>
        <?php endwhile; ?>
        <?php if (mysqli_num_rows($avisos) == 0): ?>
            <p class="vacio">No hay avisos publicados.</p>
        <?php endif; ?>
    </div>

    <div class="tarjeta">
        <h2>Boletines de sanciones (PDF)</h2>
        <div class="tabla-scroll">
        <table>
            <tr><th>Fecha</th><th>Boletín</th><th>PDF</th></tr>
            <?php while ($b = mysqli_fetch_assoc($boletines)): ?>
            <tr>
                <td><?= date("d/m/Y", strtotime($b["fecha"])) ?></td>
                <td><?= h($b["titulo"]) ?></td>
                <td><a href="../sanciones/boletines/<?= h($b["archivo"]) ?>" target="_blank">Ver PDF</a></td>
            </tr>
            <?php endwhile; ?>
            <?php if (mysqli_num_rows($boletines) == 0): ?>
                <tr><td colspan="3" class="vacio">Todavía no hay boletines.</td></tr>
            <?php endif; ?>
        </table>
        </div>
    </div>
</main>
</body>
</html>
