<?php

$conn = mysqli_connect("localhost", "root", "", "liga");

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "SELECT * FROM club WHERE id = $id";

    $resultado = mysqli_query($conn, $sql);

    $club = mysqli_fetch_assoc($resultado);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $nombreClub = $_POST["nombreClub"];

    $sql = "UPDATE club SET clubes='$nombreClub' WHERE id=$id";

    mysqli_query($conn, $sql);

    header("Location: gestionClubes.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/clubes.css">
    <title>Editar Club</title>
</head>
<body>
    <h1 class="tituloClubes">Bienvenido a la edicion del club, a continuacion podra editar el nombre del club.</h1>
    <form action="editarClub.php" method="post">

    <input type="hidden" name="id" value="<?php echo $club["id"]; ?>">

    <label>Nombre del club:</label>

    <input type="text" name="nombreClub" value="<?php echo $club["clubes"]; ?>">

    <input type="submit" value="Guardar">

</form>
</body>
</html>