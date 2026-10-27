
<?php
require "../conexion.php";

// Obtener la competición y categoría seleccionadas
$comp = isset($_GET["comp"]) ? (int) $_GET["comp"] : 1;
$cat = isset($_GET["cat"]) ? (int) $_GET["cat"] : 0;

$competiciones = mysqli_query($conn, "SELECT * FROM competicion");
$categorias = mysqli_query($conn, "SELECT * FROM categorias");

// Filtrar por categoría si se seleccionó una
$filtro = "";
if ($cat > 0) {
    $filtro = " AND p.id_categoria = $cat";
}

// Crear la tabla con los clubes activos
$tabla = [];
$clubes = mysqli_query($conn, "SELECT id, nombre FROM club WHERE activo = 1");

while ($club = mysqli_fetch_assoc($clubes)) {
    $tabla[$club["id"]] = [
        "nombre" => $club["nombre"],
        "pj" => 0, "g" => 0, "e" => 0, "p" => 0,
        "gf" => 0, "gc" => 0, "pts" => 0
    ];
}

// Obtener los partidos jugados
$partidos = mysqli_query($conn, "SELECT * FROM partidos p
    WHERE p.id_competicion = $comp AND p.estado = 'jugado' $filtro");

// Calcular las estadísticas de cada club
while ($partido = mysqli_fetch_assoc($partidos)) {
    $local = $partido["id_club_local"];
    $visitante = $partido["id_club_visitante"];
    $golesLocal = $partido["goles_local"];
    $golesVisitante = $partido["goles_visitante"];

    $tabla[$local]["pj"]++;
    $tabla[$visitante]["pj"]++;

    $tabla[$local]["gf"] += $golesLocal;
    $tabla[$local]["gc"] += $golesVisitante;
    $tabla[$visitante]["gf"] += $golesVisitante;
    $tabla[$visitante]["gc"] += $golesLocal;

    if ($golesLocal > $golesVisitante) {
        $tabla[$local]["g"]++;
        $tabla[$local]["pts"] += 3;
        $tabla[$visitante]["p"]++;
    } elseif ($golesLocal < $golesVisitante) {
        $tabla[$visitante]["g"]++;
        $tabla[$visitante]["pts"] += 3;
        $tabla[$local]["p"]++;
    } else {
        $tabla[$local]["e"]++;
        $tabla[$visitante]["e"]++;
        $tabla[$local]["pts"]++;
        $tabla[$visitante]["pts"]++;
    }
}

// Ordenar por puntos y diferencia de goles
usort($tabla, function ($club1, $club2) {
    if ($club1["pts"] != $club2["pts"]) {
        return $club2["pts"] - $club1["pts"];
    }

    $diferencia1 = $club1["gf"] - $club1["gc"];
    $diferencia2 = $club2["gf"] - $club2["gc"];

    return $diferencia2 - $diferencia1;
});

// Obtener las fechas con los nombres de los clubes
$fechas = mysqli_query($conn, "SELECT p.*, l.nombre AS local, v.nombre AS visitante, c.`año` AS categoria
    FROM partidos p
    JOIN club l ON p.id_club_local = l.id
    JOIN club v ON p.id_club_visitante = v.id
    LEFT JOIN categorias c ON p.id_categoria = c.id
    WHERE p.id_competicion = $comp $filtro
    ORDER BY p.fecha");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posiciones</title>
</head>
<body>

<h1>Tabla de posiciones</h1>

<form method="get">
    <select name="comp" onchange="this.form.submit()">
        <?php while ($competicion = mysqli_fetch_assoc($competiciones)) { ?>
            <option value="<?= $competicion["id"] ?>" <?= $competicion["id"] == $comp ? "selected" : "" ?>>
                <?= $competicion["nombre"] ?>
            </option>
        <?php } ?>
    </select>

    <select name="cat" onchange="this.form.submit()">
        <option value="0">Todas las categorías</option>
        <?php while ($categoria = mysqli_fetch_assoc($categorias)) { ?>
            <option value="<?= $categoria["id"] ?>" <?= $categoria["id"] == $cat ? "selected" : "" ?>>
                <?= $categoria["año"] ?>
            </option>
        <?php } ?>
    </select>
</form>

<table border="1">
    <tr>
        <th>#</th>
        <th>Club</th>
        <th>PJ</th>
        <th>G</th>
        <th>E</th>
        <th>P</th>
        <th>GF</th>
        <th>GC</th>
        <th>DG</th>
        <th>Pts</th>
    </tr>

    <?php
    $puesto = 1;

    foreach ($tabla as $club) {
        if ($club["pj"] > 0) {
    ?>
        <tr>
            <td><?= $puesto ?></td>
            <td><?= $club["nombre"] ?></td>
            <td><?= $club["pj"] ?></td>
            <td><?= $club["g"] ?></td>
            <td><?= $club["e"] ?></td>
            <td><?= $club["p"] ?></td>
            <td><?= $club["gf"] ?></td>
            <td><?= $club["gc"] ?></td>
            <td><?= $club["gf"] - $club["gc"] ?></td>
            <td><?= $club["pts"] ?></td>
        </tr>
    <?php
            $puesto++;
        }
    }
    ?>
</table>

<h2>Fechas</h2>

<table border="1">
    <tr>
        <th>Fecha</th>
        <th>Categoría</th>
        <th>Local</th>
        <th>Resultado</th>
        <th>Visitante</th>
        <th>Estado</th>
    </tr>

    <?php while ($partido = mysqli_fetch_assoc($fechas)) { ?>
        <tr>
            <td><?= $partido["fecha"] ?></td>
            <td><?= $partido["categoria"] ?></td>
            <td><?= $partido["local"] ?></td>
            <td>
                <?php
                if ($partido["estado"] == "jugado") {
                    echo $partido["goles_local"] . " - " . $partido["goles_visitante"];
                } else {
                    echo "vs";
                }
                ?>
            </td>
            <td><?= $partido["visitante"] ?></td>
            <td><?= $partido["estado"] ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>
