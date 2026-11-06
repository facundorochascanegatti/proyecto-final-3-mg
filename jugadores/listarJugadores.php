
<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require_once __DIR__ . "/../conexion.php";

// LEFT JOIN: si un jugador tiene una categoría o un club que no existe igual aparece
$sql = "SELECT jugadores.*, categorias.año, club.nombre AS nombre_club
        FROM jugadores
        LEFT JOIN categorias ON jugadores.id_categoria = categorias.id
        LEFT JOIN club ON jugadores.id_club = club.id";

$resultado = mysqli_query($conn, $sql);
?>

<br><br>

<!-- buscador para filtrar jugadores -->
<div class="buscadorAdmin">
    <input type="text" id="buscador" placeholder="Buscar jugador por nombre, apellido, cédula, club...">
</div>

<!-- tabla de jugadores -->
<div class="Tabla">

<table class="tablaJugadores" id="tablaJugadores" border="1">

    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Cédula</th>
        <th>Fecha de Nacimiento</th>
        <th>Categorías</th>
        <th>Club</th>
        <th>Masa</th>
        <th>Altura</th>
        <th>Velocidad (m/s)</th>
        <th>F.Peso</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>

    <?php
    while ($fila = mysqli_fetch_assoc($resultado)) {

        echo "<tr>";
        echo "<td>" . htmlspecialchars($fila["nombre"]) . "</td>";
        echo "<td>" . htmlspecialchars($fila["apellido"]) . "</td>";
        echo "<td>" . htmlspecialchars($fila["cedula"]) . "</td>";
        echo "<td>" . $fila["fecha_nacimiento"] . "</td>";
        echo "<td>" . ($fila["año"] ? htmlspecialchars($fila["año"]) : "Sin categoría") . "</td>";
        echo "<td>" . ($fila["nombre_club"] ? htmlspecialchars($fila["nombre_club"]) : "Sin club") . "</td>";
        echo "<td>" . $fila["masa"] . "</td>";
        echo "<td>" . $fila["altura"] . "</td>";
        echo "<td>" . $fila["velocidad"] . "</td>";
        echo "<td>" . $fila["peso"] . "</td>";
        echo "<td><a href='editarJugador.php?id=" . $fila["id"] . "'>Editar</a></td>";
        echo "<td><a href='eliminarJugador.php?id=" . $fila["id"] . "' onclick=\"return confirm('¿Eliminar este jugador?')\">Eliminar</a></td>";
        echo "</tr>";
    }
    ?>

</table>
</div>
