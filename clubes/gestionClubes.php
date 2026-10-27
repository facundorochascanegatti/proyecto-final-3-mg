<?php
$conn = mysqli_connect("localhost", "root", "", "liga");
 
$sql = "SELECT * FROM club";
$resultado = mysqli_query($conn, $sql);
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="clubes.css">
    <title>Agregar clubes</title>
</head>
<body>
 
    <header>
        <nav>
            <?php include '../nav/nav.php'; ?>
        </nav>
    </header>
        <form action="guardarClub.php" method="post">
            <h1>Agregar Club</h1>
            <label for="nombreClub">Nombre del Club:</label>
            <input type="text" id="nombreClub" name="nombreClub" required="Nombre del Club" class="nombreClub" value="">
            <br><br>
            <label for="contraseña">Contraseña del Club:</label>
            <input type="number" id="contraseña" name="Contraseña del Club" required="Contraseña del Club" class="contraseña" value="">
            <input type="submit" value="Agregar" class="Agregar">
        </form>
 
    <div class="Tabla">
    <table class="tablaClubes">
        <tr>
            <th><i class="fa-solid fa-hashtag"></i></th>
            <th><i class="fa-solid fa-futbol"></i> Club</th>
            <th><i class="fa-solid fa-trash"></i></th>
            <th><i class="fa-solid fa-pen-to-square"></i></th>
        </tr>
 
        <?php
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $fila["id"] . "</td>";
            echo "<td>" . $fila["nombre"] . "</td>";
            echo "<td><a href='eliminarClub.php?id=" . $fila["id"] . "'>Eliminar</a></td>";
            echo "<td><a href='editarClub.php?id=" . $fila["id"] . "'>Editar Nombre</a></td>";
            echo "</tr>";
        }
        ?>
 
    </table>
    </div>
</body>
</html>