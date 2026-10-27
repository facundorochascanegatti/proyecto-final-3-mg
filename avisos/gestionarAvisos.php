<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirAdmin();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Si se apretó "Eliminar"
    if (isset($_POST["eliminar"])) {
        $id = (int) $_POST["eliminar"];

        $stmt = mysqli_prepare($conn, "DELETE FROM avisos WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        header("Location: gestionarAvisos.php");
        exit();
    }

    // Si no, se apretó "Publicar"
    $titulo = trim($_POST["titulo"]);
    $contenido = trim($_POST["contenido"]);

    if ($titulo == "" || $contenido == "") {
        $mensaje = "Completá el título y el contenido.";
    } else {
        $fecha = date("Y-m-d");

        $stmt = mysqli_prepare($conn, "INSERT INTO avisos (titulo, contenido, fecha) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $titulo, $contenido, $fecha);
        mysqli_stmt_execute($stmt);

        header("Location: gestionarAvisos.php");
        exit();
    }
}

// Los avisos más recientes primero
$avisos = mysqli_query($conn, "SELECT * FROM avisos ORDER BY fecha DESC, id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar avisos</title>
    <link rel="stylesheet" href="../club/club.css">
</head>
<body>

<nav class="menu">
    <a href="../admin/indexadmin.php">Inicio</a>
    <a href="../sanciones/gestionarSanciones.php">Sanciones</a>
    <a href="../carnets/gestionarCarnets.php">Carnets</a>
    <a href="../categoria/gestionarCategoria.php">Categorias</a>
    <a href="../clubes/gestionClubes.php">Clubes</a>
    <a href="../jugadores/gestionarJugadores.php">Jugadores</a>
    <a href="../fixture/gestionarPartidos.php">Partidos</a>
    <a href="gestionarAvisos.php">Avisos</a>
    <a href="../login/logout.php?rol=admin" class="salir">Salir</a>
</nav>

<main>
    <h1>Avisos y comunicados</h1>
    <p class="subtitulo">Lo que publiques lo ven todos los clubes</p>

    <div class="tarjeta">
        <h2>Nuevo aviso</h2>

        <?php if ($mensaje != ""): ?>
            <p class="mal"><?= h($mensaje) ?></p>
        <?php endif; ?>

        <form method="post">
            <p><input type="text" name="titulo" placeholder="Título" maxlength="100" required style="width:100%"></p>
            <p><textarea name="contenido" placeholder="Escribí el comunicado..." required></textarea></p>
            <input type="submit" value="Publicar">
        </form>
    </div>

    <div class="tarjeta">
        <h2>Avisos publicados</h2>

        <?php while ($aviso = mysqli_fetch_assoc($avisos)): ?>
            <div class="aviso">
                <b><?= h($aviso["titulo"]) ?></b>
                <small><?= date("Y-m-d", strtotime($aviso["fecha"])) ?></small>

                <div><?= h($aviso["contenido"]) ?></div>

                <form method="post" onsubmit="return confirm('¿Eliminar este aviso?')" style="margin-top:8px">
                    <input type="hidden" name="eliminar" value="<?= $aviso["id"] ?>">
                    <button type="submit" class="rojo">Eliminar</button>
                </form>
            </div>
        <?php endwhile; ?>

        <?php if (mysqli_num_rows($avisos) == 0): ?>
            <p class="vacio">Todavía no publicaste avisos.</p>
        <?php endif; ?>
    </div>
</main>

</body>
</html>