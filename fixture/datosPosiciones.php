<?php
// Este archivo calcula la tabla de posiciones y las fechas de una competición.
// Lo usan fixture/posiciones.php (admin) y club/posiciones.php (clubes).
require_once __DIR__ . "/../conexion.php";

// copa elegida (si no eligió ninguna, la primera) y categoría (0 = todas)
$comp = isset($_GET["comp"]) ? (int) $_GET["comp"] : 1;
$cat = isset($_GET["cat"]) ? (int) $_GET["cat"] : 0;

$competiciones = mysqli_query($conn, "SELECT * FROM competicion");
$categorias = mysqli_query($conn, "SELECT * FROM categorias ORDER BY año");

// si eligió una categoría, agregamos esa condición a las consultas
$filtroCat = "";
if ($cat > 0) {
    $filtroCat = " AND p.id_categoria = $cat";
}

// 1. armamos la tabla con todos los clubes activos en cero
$tabla = [];
$clubes = mysqli_query($conn, "SELECT id, nombre FROM club WHERE activo = 1");
while ($c = mysqli_fetch_assoc($clubes)) {
    $tabla[$c["id"]] = [
        "nombre" => $c["nombre"],
        "pj" => 0, "g" => 0, "e" => 0, "p" => 0,
        "gf" => 0, "gc" => 0, "pts" => 0
    ];
}

// 2. recorremos solo los partidos jugados de esa copa y sumamos los datos
$jugados = mysqli_query($conn, "SELECT * FROM partidos p
    WHERE p.id_competicion = $comp AND p.estado = 'jugado'
    AND p.goles_local IS NOT NULL AND p.goles_visitante IS NOT NULL $filtroCat");

while ($p = mysqli_fetch_assoc($jugados)) {
    $local = $p["id_club_local"];
    $visita = $p["id_club_visitante"];
    $golesLocal = $p["goles_local"];
    $golesVisita = $p["goles_visitante"];

    // si un club del partido está inactivo, lo salteamos
    if (!isset($tabla[$local]) || !isset($tabla[$visita])) {
        continue;
    }

    $tabla[$local]["pj"]++;
    $tabla[$visita]["pj"]++;

    $tabla[$local]["gf"] += $golesLocal;
    $tabla[$local]["gc"] += $golesVisita;
    $tabla[$visita]["gf"] += $golesVisita;
    $tabla[$visita]["gc"] += $golesLocal;

    if ($golesLocal > $golesVisita) {
        $tabla[$local]["g"]++;
        $tabla[$local]["pts"] += 3;
        $tabla[$visita]["p"]++;
    } elseif ($golesLocal < $golesVisita) {
        $tabla[$visita]["g"]++;
        $tabla[$visita]["pts"] += 3;
        $tabla[$local]["p"]++;
    } else {
        $tabla[$local]["e"]++;
        $tabla[$visita]["e"]++;
        $tabla[$local]["pts"] += 1;
        $tabla[$visita]["pts"] += 1;
    }
}

// 3. ordenamos: más puntos arriba, y si empatan, mejor diferencia de gol
usort($tabla, function ($a, $b) {
    if ($b["pts"] != $a["pts"]) {
        return $b["pts"] - $a["pts"];
    }
    return ($b["gf"] - $b["gc"]) - ($a["gf"] - $a["gc"]);
});

// 4. consulta de las fechas (con los nombres de los clubes)
$fechas = mysqli_query($conn, "SELECT p.*, l.nombre AS local, v.nombre AS visitante, c.año AS categoria
    FROM partidos p
    INNER JOIN club l ON p.id_club_local = l.id
    INNER JOIN club v ON p.id_club_visitante = v.id
    LEFT JOIN categorias c ON p.id_categoria = c.id
    WHERE p.id_competicion = $comp $filtroCat
    ORDER BY p.fecha IS NULL, p.fecha ASC");
?>
