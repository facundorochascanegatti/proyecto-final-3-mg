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

        <?php if (isset($_GET["error"])): ?>
            <?php if ($_GET["error"] == "usuario"): ?>
                <p style="color: white;">Ese nombre de usuario ya existe.</p>
            <?php else: ?>
                <p style="color: white;">No se pudo crear el club. Revisá los datos.</p>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($_GET["enUso"])): ?>
            <p style="color: white;">No se puede eliminar un club que tiene jugadores o partidos.</p>
        <?php endif; ?>

        <label for="nombreClub">Nombre del Club:</label>
        <input type="text" id="nombreClub" name="nombreClub" required class="nombreClub" maxlength="100">
        <br><br>

        <label for="presidente">Nombre del Presidente:</label>
        <input type="text" id="presidente" name="presidente" required class="presidente" maxlength="100">

        <label for="estadio">Nombre del Estadio:</label>
        <input type="text" id="estadio" name="estadio" required class="estadio" maxlength="100">
        <br><br>

        <label for="fundacion">Año de fundación:</label>
        <input type="number" id="fundacion" name="fundacion" required class="fundacion" min="1800" max="<?= date("Y") ?>">

        <label for="password">Contraseña del Club:</label>
        <input type="password" id="password" name="password" minlength="6" required>
        <button type="button" onclick="password.type = password.type === 'password' ? 'text' : 'password'">👁</button>

        <br><br>

        <input type="submit" value="Agregar" class="Agregar">
    </form>

    <div class="Tabla">
    <table class="tablaClubes">

        <tr>
            <th><i class="fa-solid fa-hashtag"></i></th>
            <th><i class="fa-solid fa-image"></i></th>
            <th><i class="fa-solid fa-futbol"></i> Club</th>
            <th>Presidente</th>
            <th>Estadio</th>
            <th>Año de fundación</th>
            <th><i class="fa-solid fa-trash"></i></th>
            <th><i class="fa-solid fa-pen-to-square"></i></th>
        </tr>

        <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?= $fila["id"] ?></td>

                <td>
                    <?php if ($fila["logo"]): ?>
                        <img src="logos/<?= htmlspecialchars($fila["logo"]) ?>" alt="logo" width="40">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($fila["nombre"]) ?></td>
                <td><?= htmlspecialchars($fila["presidente"]) ?></td>
                <td><?= htmlspecialchars($fila["estadio"]) ?></td>
                <td><?= htmlspecialchars($fila["fundacion"]) ?></td>

                <td>
                    <a href="eliminarClub.php?id=<?= $fila["id"] ?>"
                        onclick="return confirm('¿Eliminar este club?')">
                        Eliminar
                    </a>
                </td>

                <td>
                    <a href="editarClub.php?id=<?= $fila["id"] ?>">
                        Editar
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>
</div>

</body>
</html>