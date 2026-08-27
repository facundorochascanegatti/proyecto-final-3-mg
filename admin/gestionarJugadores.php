<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="gestionarJugadores.php" method="post">
        <h1>Gestionar Jugadores</h1>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required><br><br>
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>
        <input type="submit" value="Agregar Jugador">
    </form>
</body>
</html>

<?php

$conn = mysqli_connect("localhost", "root", "", "liga");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cedula = $_POST["cedula"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    

    $sql = "INSERT INTO jugadores (nombre, apellido, cedula, fecha_nacimiento) VALUES ('$nombre', '$apellido', '$cedula', '$fecha_nacimiento')";

    $sql = "SELECT jugadores.nombre, jugadores.apellido, jugadores.cedula,
            jugadores.fecha_nacimiento, club.nombre AS club
        FROM jugadores
        INNER JOIN club ON jugadores.id_club = club.id";

$resultado = mysqli_query($conn, $sql);

    mysqli_query($conn, $sql);

    header("Location: gestionarJugadores.php");
    exit();
}

$sql = "SELECT * FROM jugadores";
$resultado = mysqli_query($conn, $sql);



?>

<?php
    $conn = mysqli_connect("localhost", "root", "", "liga");

    $sql = "SELECT * FROM jugadores";
    $resultado = mysqli_query($conn, $sql);

?>
<table class="tablaClubes" border="1">
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Cédula</th>
        <th>Fecha de Nacimiento</th>

    </tr>

    <?php
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $fila["nombre"] . "</td>";
        echo "<td>" . $fila["apellido"] . "</td>";
        echo "<td>" . $fila["cedula"] . "</td>";
        echo "<td>" . $fila["fecha_nacimiento"] . "</td>";
        echo "<td>" . $fila["id_club"] . "</td>";
        echo "</tr>"
        ;
    }
    ?>

</table>