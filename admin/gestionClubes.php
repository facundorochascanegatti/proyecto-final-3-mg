<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

$club = $_POST["nombreClub"];

$sql = "INSERT INTO club (clubes)
        VALUES ('$club')";

mysqli_query($conn, $sql);

echo "Club guardado correctamente";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/categoria.css" rel="stylesheet">
    <title>Gestionar Categorías</title>
</head>
<body>
    <h1 class="tituloCategoria">Gestionar clubes</h1>
    <p class="parrafoCategoria">Aquí puedes agregar los clubes.</p>
    <form action="gestionClubes.php" method="post">
        <label for="nombreClub">Nombre del Club:</label>
        <input type="text" id="nombreClub" name="nombreClub" required><br><br>
        <input type="submit" value="Agregar Club">
    </form>

</body>
</html>
