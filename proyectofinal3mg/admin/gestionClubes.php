<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$conn = mysqli_connect("localhost", "root", "", "liga");

$club = $_POST["nombreClub"];

$sql = "INSERT INTO club (clubes)
        VALUES ('$club')";

mysqli_query($conn, $sql);

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/clubes.css">
    <title>Agregar clubes</title>
</head>
<body>
    <h1 class="tituloClubes">Agregar Club</h1>
    <form action="gestionClubes.php" method="post">
        <label for="nombreClub">Nombre del Club:</label>
        <input type="text" id="nombreClub" name="nombreClub" required><br><br>
        <input type="submit" value="Agregar Club">
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$conn = mysqli_connect("localhost", "root", "", "liga");

$sql = "SELECT clubes FROM club";
$resultado = mysqli_query($conn, $sql);

while ($fila = mysqli_fetch_assoc($resultado)) {
}
}
?>



///
<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

$sql = "SELECT * FROM club";
$resultado = mysqli_query($conn, $sql);
?>

<table class="tablaClubes" border="1">
    <tr>
        <th>ID</th>
        <th>Club</th>
    </tr>

    <?php
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>" . $fila["id"] . "</td>";
        echo "<td>" . $fila["clubes"] . "</td>";
        echo "<td><a href='gestionarClubes.php?id=" . $fila["id"] . "'>Eliminar</a></td>";
        echo "</tr>";
    }
    ?>
</table>
//agregar columna mañana, en teoria el select sirve (que es para poder mostrar los datos del club) pero no se si lo hace bien, hay que probarlo.
//acomodar esta mierda y entenderlo despues.