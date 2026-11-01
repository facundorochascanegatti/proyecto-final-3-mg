<?php
// Esto conecta con la base de datos.
require_once __DIR__ . "/../conexion.php";

// Esto incluye las funciones para controlar el acceso.
require_once __DIR__ . "/../auth.php";

// Esto comprueba que el usuario haya iniciado sesion como club.
requerirClub();

// Esto obtiene el id del club que inicio sesion.
$miClub = (int) $_SESSION["id_club"];

// Esto obtiene el club que queremos ver.
// Si no elegimos otro, muestra nuestro propio club.
$verClub = isset($_GET["club"]) ? (int) $_GET["club"] : $miClub;

// Esto obtiene la categoria elegida.
// Si no elegimos ninguna, guarda el valor 0.
$verCat = isset($_GET["categoria"]) ? (int) $_GET["categoria"] : 0;

// Esto obtiene todos los clubes y categorias de la base de datos.
$clubes = mysqli_query($conn, "SELECT id, nombre FROM club ORDER BY nombre");
$categorias = mysqli_query($conn, "SELECT id, año FROM categorias ORDER BY año");

// Esto busca el nombre del club que estamos viendo.
$club = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nombre FROM club WHERE id = $verClub"));

// Esto obtiene los datos de los jugadores, sus categorias y sus carnets.
$sql = "SELECT jugadores.nombre, jugadores.apellido, jugadores.cedula,
        jugadores.fecha_nacimiento, categorias.año, carnets.foto, carnets.fecha_vencimiento
        FROM jugadores
        INNER JOIN categorias ON jugadores.id_categoria = categorias.id
        LEFT JOIN carnets ON jugadores.id = carnets.id_jugador
        WHERE jugadores.id_club = $verClub";

// Si elegimos una categoria, agrega el filtro a la consulta.
if ($verCat > 0) {
    $sql .= " AND jugadores.id_categoria = $verCat";
}

// Esto ordena los jugadores por categoria y apellido.
$sql .= " ORDER BY categorias.año, jugadores.apellido";

// Esto ejecuta la consulta y guarda los resultados.
$resultado = mysqli_query($conn, $sql);

// Esto obtiene la fecha de hoy y cuenta los jugadores encontrados.
$hoy = date("Y-m-d");
$cantidad = mysqli_num_rows($resultado);
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
    <p class="subtitulo">
        Solo lectura<?= $verClub != $miClub ? " (estás viendo otro club)" : "" ?>
    </p>

    <form method="get" class="filtros">
        <select name="club" onchange="this.form.submit()">
            <?php while ($c = mysqli_fetch_assoc($clubes)) { ?>
                <option value="<?= $c["id"] ?>" <?= $c["id"] == $verClub ? "selected" : "" ?>>
                    <?= h($c["nombre"]) ?>
                </option>
            <?php } ?>
        </select>

        <select name="categoria" onchange="this.form.submit()">
            <option value="0">Todas las categorías</option>
            <?php while ($cat = mysqli_fetch_assoc($categorias)) { ?>
                <option value="<?= $cat["id"] ?>" <?= $cat["id"] == $verCat ? "selected" : "" ?>>
                    <?= h($cat["año"]) ?>
                </option>
            <?php } ?>
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

            <?php while ($j = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td>
                        <?php if ($j["foto"]) { ?>
                            <a href="carnets/fotos/<?= h($j["foto"]) ?>" target="_blank">
                                <img class="foto" src="carnets/fotos/<?= h($j["foto"]) ?>" alt="carnet">
                            </a>
                        <?php } else { echo "-"; } ?>
                    </td>

                    <td><?= h($j["nombre"] . " " . $j["apellido"]) ?></td>
                    <td><?= h($j["cedula"]) ?></td>

                    <td>
                        <?= $j["fecha_nacimiento"] ? date("d/m/Y", strtotime($j["fecha_nacimiento"])) : "-" ?>
                    </td>

                    <td><?= h($j["año"]) ?></td>

                    <td>
                        <?php
                        // Si no tiene fecha de vencimiento, no tiene carnet registrado.
                        if (!$j["fecha_vencimiento"]) {
                        ?>
                            <span class="mal">Sin carnet</span>

                        <?php
                        // Si la fecha de vencimiento es mayor o igual a hoy, el carnet esta vigente.
                        } elseif ($j["fecha_vencimiento"] >= $hoy) {
                        ?>
                            <span class="ok">Vigente</span>
                            (vence <?= date("d/m/Y", strtotime($j["fecha_vencimiento"])) ?>)

                        <?php
                        // Si no se cumple ninguna de las condiciones anteriores, el carnet esta vencido.
                        } else {
                        ?>
                            <span class="mal">Vencido</span>
                            (<?= date("d/m/Y", strtotime($j["fecha_vencimiento"])) ?>)
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>

            <?php
            // Si no se encontro ningun jugador, muestra un mensaje.
            if ($cantidad == 0) {
            ?>
                <tr>
                    <td colspan="6" class="vacio">No hay jugadores para mostrar.</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</main>
</body>
</html>
