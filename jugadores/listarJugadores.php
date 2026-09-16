<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

$sql = "SELECT jugadores.*, categorias.año, club.nombre AS nombre_club
        FROM jugadores
        INNER JOIN categorias ON jugadores.id_categoria = categorias.id
        INNER JOIN club ON jugadores.id_club = club.id";
$resultado = mysqli_query($conn, $sql);
?>

<div class="Tabla">
<table class="tablaClubes" border="1">
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Cédula</th>
        <th>Fecha de Nacimiento</th>
        <th>Categorías</th>
        <th>Club</th>
    </tr>

    <?php
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $fila["nombre"] . "</td>";
        echo "<td>" . $fila["apellido"] . "</td>";
        echo "<td>" . $fila["cedula"] . "</td>";
        echo "<td>" . $fila["fecha_nacimiento"] . "</td>";
        echo "<td>" . $fila["año"] . "</td>";
        echo "<td>" . $fila["nombre_club"] . "</td>";
        echo "</tr>";
    }
    ?>
</table>
</div>