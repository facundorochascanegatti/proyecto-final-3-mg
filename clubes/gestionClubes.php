<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

$clubEditar = null;

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM club WHERE id = $id";
    $resultado = mysqli_query($conn, $sql);
    $clubEditar = mysqli_fetch_assoc($resultado);
}

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
            <a href="../admin/indexadmin.php" class="home">
                <i class="fa-solid fa-house"></i>
            </a>
            <a href="gestionSanciones.php">Sanciones</a>
            <a href="admin/gestionCarnets.php">Carnets</a>
            <a href="../admin/gestionarCategoria.php">Categorias</a>
            <a href="../clubes/gestionClubes.php">Clubes</a>
            <a href="../jugadores/gestionarJugadores.php">Jugadores</a>
        </nav>
    </header>

    <h1 class="tituloClubes"><?= $clubEditar ? "Editar Club" : "Agregar Club" ?></h1>
    <div class="Casilla">
        <form action="guardarClub.php" method="post">
            <?php if ($clubEditar): ?>
                <input type="hidden" name="id" value="<?= $clubEditar['id'] ?>">
            <?php endif; ?>
            <input type="text" id="nombreClub" name="nombreClub" required="Nombre del Club" class="nombreClub" value="<?= $clubEditar ? $clubEditar['nombre'] : '' ?>"><br><br>
            <input type="submit" value="<?= $clubEditar ? 'Guardar Cambios' : 'Agregar' ?>" class="Agregar">
        </form>
    </div>

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
            echo "<td><a href='gestionClubes.php?id=" . $fila["id"] . "'>Editar Nombre</a></td>";
            echo "</tr>";
        }
        ?>

    </table>
    </div>
</body>
</html>