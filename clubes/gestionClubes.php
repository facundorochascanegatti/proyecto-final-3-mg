<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require "../conexion.php";
 
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
        <?php include '../nav/nav.php'; ?>
    </header>
        <form action="guardarClub.php" method="post">
            <h1>Agregar Club</h1>
            <?php
            // eliminarClub.php vuelve con ?enUso=1 si el club tenía jugadores o partidos
            if (isset($_GET["enUso"])) {
                echo "<p style='color: white;'>No se puede eliminar un club que tiene jugadores o partidos.</p>";
            }
            ?>
            <label for="nombreClub">Nombre del Club:</label>
            <input type="text" id="nombreClub" name="nombreClub" required class="nombreClub" value="">
            <br><br>
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
            echo "<td>" . htmlspecialchars($fila["nombre"]) . "</td>";
            echo "<td><a href='eliminarClub.php?id=" . $fila["id"] . "' onclick=\"return confirm('¿Eliminar este club?')\">Eliminar</a></td>";
            echo "<td><a href='editarClub.php?id=" . $fila["id"] . "'>Editar Nombre</a></td>";
            echo "</tr>";
        }
        ?>
 
    </table>
    </div>
</body>
</html>