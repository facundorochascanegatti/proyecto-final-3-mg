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

    $tabla[$local]["pj"]++; //partidos jugados
    $tabla[$visita]["pj"]++; //partidos jugados

    $tabla[$local]["gf"] += $golesLocal; // goles a favor
    $tabla[$local]["gc"] += $golesVisita; // goles en contra
    $tabla[$visita]["gf"] += $golesVisita; // goles a favor
    $tabla[$visita]["gc"] += $golesLocal; // goles en contra

    if ($golesLocal > $golesVisita) { // el local ganó
        $tabla[$local]["g"]++; // partidos ganados
        $tabla[$local]["pts"] += 3; // puntos
        $tabla[$visita]["p"]++; // partidos perdidos
    } elseif ($golesLocal < $golesVisita) { // el visitante ganó
        $tabla[$visita]["g"]++; // partidos ganados
        $tabla[$visita]["pts"] += 3; // puntos
        $tabla[$local]["p"]++; // partidos perdidos
    } else { // empataron
        $tabla[$local]["e"]++; // partidos empatados
        $tabla[$visita]["e"]++; // partidos empatados
        $tabla[$local]["pts"] += 1; // puntos
        $tabla[$visita]["pts"] += 1; // puntos
    }
}

// 3. ordenamos: más puntos arriba, y si empatan, mejor diferencia de gol
usort($tabla, function ($a, $b) { // compara dos clubes
    if ($b["pts"] != $a["pts"]) { // si los puntos son diferentes, ordena por puntos
        return $b["pts"] - $a["pts"]; // ordena de mayor a menor
    }
    return ($b["gf"] - $b["gc"]) - ($a["gf"] - $a["gc"]); // ordena por diferencia de goles
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
