<?php
require_once __DIR__ . "/../auth.php";
requerirClub();
include __DIR__ . "/../fixture/datosPosiciones.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posiciones</title>
    <link rel="stylesheet" href="club.css">
</head>
<body>
<?php include "menu.php"; ?>
<main>
    <h1>Posiciones</h1>
    <p class="subtitulo">Solo lectura</p>

    <form method="get">
        <select name="comp" onchange="this.form.submit()">
            <?php while ($c = mysqli_fetch_assoc($competiciones)) { ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $comp ? "selected" : "" ?>>
                    <?= h($c['nombre']) ?>
                </option>
            <?php } ?>
        </select>

        <select name="cat" onchange="this.form.submit()">
            <option value="0">Todas las categorías</option>
            <?php while ($c = mysqli_fetch_assoc($categorias)) { ?>
                <option value="<?= $c['id'] ?>" <?= $c['id'] == $cat ? "selected" : "" ?>>
                    <?= h($c['año']) ?>
                </option>
            <?php } ?>
        </select>
    </form>

    <div class="tabla-scroll">
    <table>
        <tr>
            <th>#</th><th>Club</th><th>PJ</th><th>G</th><th>E</th><th>P</th>
            <th>GF</th><th>GC</th><th>DG</th><th>Pts</th>
        </tr>
        <?php
        $puesto = 1;
        foreach ($tabla as $f) {
            if ($f["pj"] > 0) {
                echo "<tr>";
                echo "<td>" . $puesto . "</td>";
                echo "<td>" . h($f["nombre"]) . "</td>";
                echo "<td>" . $f["pj"] . "</td>";
                echo "<td>" . $f["g"] . "</td>";
                echo "<td>" . $f["e"] . "</td>";
                echo "<td>" . $f["p"] . "</td>";
                echo "<td>" . $f["gf"] . "</td>";
                echo "<td>" . $f["gc"] . "</td>";
                echo "<td>" . ($f["gf"] - $f["gc"]) . "</td>";
                echo "<td>" . $f["pts"] . "</td>";
                echo "</tr>";
                $puesto++;
            }
        }
        if ($puesto == 1) {
            echo "<tr><td colspan='10' class='vacio'>Todavía no hay partidos jugados en esta competición.</td></tr>";
        }
        ?>
    </table>
    </div>

    <h2 style="text-align:center;color:white;">Fechas</h2>
    <div class="tabla-scroll">
    <table>
        <tr>
            <th>Fecha</th><th>Categoría</th><th>Local</th><th>Resultado</th><th>Visitante</th><th>Estado</th>
        </tr>
        <?php while ($f = mysqli_fetch_assoc($fechas)) { ?>
            <tr>
                <td><?= $f["fecha"] ? date("d/m/Y", strtotime($f["fecha"])) : "Sin fecha" ?></td>
                <td><?= h($f["categoria"]) ?></td>
                <td><?= h($f["local"]) ?></td>
                <td><?= ($f["goles_local"] === null || $f["goles_visitante"] === null) ? "vs" : $f["goles_local"] . " - " . $f["goles_visitante"] ?></td>
                <td><?= h($f["visitante"]) ?></td>
                <td><?= h($f["estado"]) ?></td>
            </tr>
        <?php } ?>
    </table>
    </div>
</main>
</body>
</html>
