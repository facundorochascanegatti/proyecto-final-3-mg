<?php
// incluye la conexión a la base de datos, asi no tenemos q hacer una conexion en cada archivo y se hace mas seguro
require_once __DIR__ . "/../conexion.php";

// esto incluye las funciones de seguridad y comprueba que el usuario sea un club
require_once __DIR__ . "/../auth.php";
requerirClub();

// obtiene todos los avisos de la base de datos.
// ORDER BY fecha DESC ordena los avisos desde el más reciente al más antiguo
// si dos avisos tienen la misma fecha, el sistema agarra el ID para ordenarlos
$avisos = mysqli_query($conn, "SELECT * FROM avisos ORDER BY fecha DESC, id DESC");

// obtiene todos los boletines de sanciones de la base de datos
// los ordena desde el más nuevo al más viejo
$boletines = mysqli_query($conn, "SELECT * FROM boletines ORDER BY fecha DESC, id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <!-- deja que la página se adapte al tamaño de la pantalla del dispositivo -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Avisos y boletines</title>

    <!-- conecta el archivo CSS que contiene los estilos de esta página -->
    <link rel="stylesheet" href="club.css">
</head>
<body>

<!-- incluye el menú de navegación del club, aca seria lo mismo q nav/nav.css en el panel del admin -->
<?php include "menu.php"; ?>

<main>
    <h1>Avisos y boletines</h1>

    <!-- indica que los avisos y boletines son publicados por la liga y solamente se pueden consultar -->
    <p class="subtitulo">Publicados por la liga (solo lectura)</p>

    <!-- esta es la tarjeta q muestra los avisos de la liga, es lo primero q va a ver el club al logearse -->
    <div class="tarjeta">
        <h2>Avisos</h2>

        <!-- esto recorre los avisos y guarda los datos en un array, permitiendo acceder a ellos mediante el nombre de las columnas -->
        <?php while ($a = mysqli_fetch_assoc($avisos)): ?>
            <div class="aviso">

                <!-- esto muestra el titulo y la fecha del aviso -->
                <b><?= h($a["titulo"]) ?></b>
                <small><?= date("d/m/Y", strtotime($a["fecha"])) ?></small>

                <!-- muestra lo q hay en el aviso (osea el contenido) y mantiene los saltos de línea -->
                <div><?= nl2br(h($a["contenido"])) ?></div>

            </div>
        <?php endwhile; ?>

        <!-- Comprueba si no existen avisos publicados. -->
        <?php if (mysqli_num_rows($avisos) == 0): ?>

            <!-- Si no hay avisos, muestra un mensaje. -->
            <p class="vacio">No hay avisos publicados.</p>

        <?php endif; ?>
    </div>

    <!-- Tarjeta que muestra los boletines de sanciones en formato PDF. -->
    <div class="tarjeta">
        <h2>Boletines de sanciones (PDF)</h2>

        <!-- Permite controlar el desplazamiento horizontal de la tabla. -->
        <div class="tabla-scroll">

        <table>

            <!-- Encabezados de las columnas de la tabla. -->
            <tr>
                <th>Fecha</th>
                <th>Boletín</th>
                <th>PDF</th>
            </tr>

            <!-- Recorre los boletines y guarda cada uno en un array asociativo. -->
            <?php while ($b = mysqli_fetch_assoc($boletines)): ?>
            <tr>

                <!-- Muestra la fecha del boletín en formato día/mes/año. -->
                <td><?= date("d/m/Y", strtotime($b["fecha"])) ?></td>

                <!-- Muestra el título del boletín utilizando h() para proteger el texto. -->
                <td><?= h($b["titulo"]) ?></td>

                <!-- Crea un enlace al PDF utilizando el nombre del archivo guardado en la base de datos. -->
                <!-- target="_blank" permite abrir el PDF en una nueva pestaña. -->
                <td><a href="../sanciones/boletines/<?= h($b["archivo"]) ?>" target="_blank">Ver PDF</a></td>

            </tr>
            <?php endwhile; ?>

            <!-- Comprueba si no existen boletines publicados. -->
            <?php if (mysqli_num_rows($boletines) == 0): ?>

                <!-- Si no hay boletines, muestra un mensaje que ocupa las tres columnas. -->
                <tr><td colspan="3" class="vacio">Todavía no hay boletines.</td></tr>

            <?php endif; ?>

        </table>
        </div>
    </div>
</main>
</body>
</html>