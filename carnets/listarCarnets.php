<?php
// Conexión a la base de datos "liga"
$conn = mysqli_connect("localhost", "root", "", "liga");

// Todos los jugadores con su carnet (LEFT JOIN: también aparecen los que no tienen)
$sql = "SELECT jugadores.nombre, jugadores.apellido, jugadores.cedula, club.nombre AS club,
        carnets.id AS id_carnet, carnets.foto, carnets.fecha_vencimiento
    FROM jugadores
    INNER JOIN club ON jugadores.id_club = club.id
    LEFT JOIN carnets ON carnets.id_jugador = jugadores.id
    ORDER BY club.nombre, jugadores.apellido";
$resultado = mysqli_query($conn, $sql);

// Fecha de hoy, para saber si el carnet sigue vigente
$hoy = date("Y-m-d");
?>

<h1 class="tituloSeccion">Carnets de los jugadores</h1>

<div class="Tabla">
<table class="tablaClubes">
    <tr>
        <th><i class="fa-solid fa-image"></i></th>
        <th>Jugador</th>
        <th>Cédula</th>
        <th>Club</th>
        <th>Vence</th>
        <th>Estado</th>
        <th><i class="fa-solid fa-trash"></i></th>
    </tr>
    <?php
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        // Foto en miniatura (si tiene carnet)
        echo "<td>" . ($fila["foto"] ? "<a href='fotos/" . $fila["foto"] . "' target='_blank'><img src='fotos/" . $fila["foto"] . "' class='fotoCarnet'></a>" : "-") . "</td>";
        echo "<td>" . htmlspecialchars($fila["apellido"] . ", " . $fila["nombre"]) . "</td>";
        echo "<td>" . htmlspecialchars($fila["cedula"]) . "</td>";
        echo "<td>" . htmlspecialchars($fila["club"]) . "</td>";
        if (!$fila["id_carnet"]) {
            // Sin carnet cargado
            echo "<td>-</td><td class='suspendido'>Sin carnet</td><td></td>";
        } else {
            // Vigente si todavía no pasó la fecha de vencimiento
            $vigente = $fila["fecha_vencimiento"] >= $hoy;
            echo "<td>" . date("d/m/Y", strtotime($fila["fecha_vencimiento"])) . "</td>";
            echo "<td class='" . ($vigente ? "habilitado" : "suspendido") . "'>" . ($vigente ? "Vigente" : "Vencido") . "</td>";
            echo "<td><a href='eliminarCarnet.php?id=" . $fila["id_carnet"] . "' onclick=\"return confirm('¿Borrar este carnet?')\">Eliminar</a></td>";
        }
        echo "</tr>";
    }
    if (mysqli_num_rows($resultado) == 0) {
        echo "<tr><td colspan='7' class='vacio'>Todavía no hay jugadores cargados.</td></tr>";
    }
    ?>
</table>
</div>
