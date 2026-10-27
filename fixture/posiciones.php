<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php include __DIR__ . "/datosPosiciones.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posiciones</title>
    <link href="partidos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>

<header>
    <?php include '../nav/nav.php'; ?>
</header>

<div class="Casilla">
    <h1 class="tituloPartidos">Posiciones</h1>

    <!-- filtros: al cambiar uno se recarga la página con ?comp=..&cat=.. -->
    <form method="get">
        <label for="comp">Competición:</label>
        <select name="comp" id="comp" onchange="this.form.submit()">
            <?php while ($c = mysqli_fetch_assoc($competiciones)) { ?>
                <option value="<?php echo $c['id']; ?>" <?php if ($c['id'] == $comp) { echo "selected"; } ?>>
                    <?php echo htmlspecialchars($c['nombre']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="cat">Categoría:</label>
        <select name="cat" id="cat" onchange="this.form.submit()">
            <option value="0">Todas las categorías</option>
            <?php while ($c = mysqli_fetch_assoc($categorias)) { ?>
                <option value="<?php echo $c['id']; ?>" <?php if ($c['id'] == $cat) { echo "selected"; } ?>>
                    <?php echo htmlspecialchars($c['año']); ?>
                </option>
            <?php } ?>
        </select>
    </form>
</div>

<div class="Tabla">
    <table class="tablaPartidos">
        <tr>
            <th>#</th><th>Club</th><th>PJ</th><th>G</th><th>E</th><th>P</th>
            <th>GF</th><th>GC</th><th>DG</th><th>Pts</th>
        </tr>
        <?php
        $puesto = 1;
        foreach ($tabla as $f) {
            // mostramos solo los clubes que jugaron algún partido
            if ($f["pj"] > 0) {
                echo "<tr>";
                echo "<td>" . $puesto . "</td>";
                echo "<td>" . htmlspecialchars($f["nombre"]) . "</td>";
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
            echo "<tr><td colspan='10'>Todavía no hay partidos jugados en esta competición.</td></tr>";
        }
        ?>
    </table>
</div>

<div class="Tabla">
    <table class="tablaPartidos">
        <tr>
            <th>Fecha</th><th>Categoría</th><th>Local</th><th>Resultado</th><th>Visitante</th><th>Estado</th>
        </tr>
        <?php while ($f = mysqli_fetch_assoc($fechas)) { ?>
            <tr>
                <td><?php echo $f["fecha"] == NULL ? "Sin fecha" : htmlspecialchars($f["fecha"]); ?></td>
                <td><?php echo htmlspecialchars($f["categoria"]); ?></td>
                <td><?php echo htmlspecialchars($f["local"]); ?></td>
                <td>
                    <?php
                    if ($f["goles_local"] === NULL || $f["goles_visitante"] === NULL) {
                        echo "vs";
                    } else {
                        echo $f["goles_local"] . " - " . $f["goles_visitante"];
                    }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($f["visitante"]); ?></td>
                <td><?php echo htmlspecialchars($f["estado"]); ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
