<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Jugadores</title>
    <link href="../css/jugadores.css" rel="stylesheet">
</head>
<body>

<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

$sql = "SELECT jugadores.*, categorias.año, club.nombre AS nombre_club
        FROM jugadores
        INNER JOIN categorias ON jugadores.id_categoria = categorias.id
        INNER JOIN club ON jugadores.id_club = club.id";
$resultado = mysqli_query($conn, $sql);
?>
<br><br>
<!-- ESTO ES UNA TABLA PARA LISTAR LOS JUGADORES -->
<div class="Tabla">
<table class="tablaClubes" border="1">
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Cédula</th>
        <th>Fecha de Nacimiento</th>
        <th>Categorías</th>
        <th>Club</th>
        <th>Masa</th>
        <th>Altura</th>
        <th>Velocidad</th>
        <th>Peso</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>
    <!-- ESTO ES UN WHILE PARA LISTAR LOS JUGADORES EN LA TABLA -->
    <!-- EL MYSQLI_FETCH_ASSOC() ES PARA QUE LOS DATOS SE MUESTREN EN LA TABLA -->
    <?php
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $fila["nombre"] . "</td>";
        echo "<td>" . $fila["apellido"] . "</td>";
        echo "<td>" . $fila["cedula"] . "</td>";
        echo "<td>" . $fila["fecha_nacimiento"] . "</td>";
        echo "<td>" . $fila["año"] . "</td>";
        echo "<td>" . $fila["nombre_club"] . "</td>";
        echo "<td>" . $fila["masa"] . "</td>";
        echo "<td>" . $fila["altura"] . "</td>";
        echo "<td>" . $fila["velocidad"] . "</td>";
        echo "<td>" . $fila["peso"] . "</td>";
        echo "<td><a href='editarJugador.php?id=" . $fila["id"] . "'>Editar</a></td>";
        echo "<td><a href='eliminarJugador.php?id=" . $fila["id"] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    ?>
<!-- ESTO ES PARA CERRAR LA TABLA -->
</table>
</div>
</body>
</html>