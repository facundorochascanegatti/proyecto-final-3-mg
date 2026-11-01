<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirClub();

// obtiene los avisos y boletines de la base de datos
$avisos = mysqli_query($conn, "SELECT * FROM avisos ORDER BY fecha DESC, id DESC");
// obtiene los boletines de la base de datos
// mysqli_query es una función de PHP que ejecuta una consulta SQL en la base de datos y devuelve un resultado

//$boletines sirve para obtener los boletines de sanciones de la base de datos,
// ordenados por fecha descendente y por id descendente. Esto permite mostrar los boletines más recientes primero.
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

                // la función date() formatea la fecha del boletín en formato "d/m/Y" (día/mes/año) para mostrarla en la tabla
                // strtotime() convierte la fecha del boletín en un timestamp para que date() pueda formatearla correctamente
                <td><?= date("d/m/Y", strtotime($b["fecha"])) ?></td>
                // h() es una función que escapa caracteres especiales en HTML para evitar inyecciones de código malicioso
                <td><?= h($b["titulo"]) ?></td>
                // el enlace al PDF del boletín se genera dinámicamente usando la ruta relativa "../sanciones/boletines/" y el nombre del archivo almacenado en la base de datos
                //target="_blank" hace que el PDF se abra en una nueva pestaña del navegador
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
