<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";
requerirAdmin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_anuncio'])) {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $contenido = mysqli_real_escape_string($conn, $_POST['contenido']);

    // la fecha es obligatoria en la tabla avisos, CURDATE() es la fecha de hoy
    mysqli_query($conn, "INSERT INTO avisos (titulo, contenido, fecha) VALUES ('$titulo', '$contenido', CURDATE())");
    header("Location: indexadmin.php");
    exit();
}

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    mysqli_query($conn, "DELETE FROM avisos WHERE id = $id");
    header("Location: indexadmin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/indexadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Index Admin</title>
</head>
<body>
    <header>
        <?php include '../nav/nav.php'; ?>
    </header>
    <main class="container mt-4">
        <section class="row">
            <div class="col-md-5">
                <div class="panel-glass">
                    <h1 class="text-white mb-3">Panel de Administracion</h1>
                    <h3 class="text-white mb-3">Publicar Anuncio</h3>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="text-white form-label">Título:</label>
                            <input type="text" name="titulo" class="form-control-custom" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-white form-label">Contenido:</label>
                            <textarea name="contenido" rows="4" class="form-control-custom" required></textarea>
                        </div>
                        <button type="submit" name="crear_anuncio" class="publicarA">Publicar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-7">
                <div class="panel-glass" style="max-height: 450px; overflow-y: auto;">
                    <h3 class="text-white mb-3">Anuncios Activos</h3>

                    <?php
                    $resultado = mysqli_query($conn, "SELECT * FROM avisos ORDER BY fecha DESC");

                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo '<div class="anuncio-card">';
                            echo '<h4 class="mb-1 tituloA" style="font-size: 16px;">' . htmlspecialchars($row['titulo']) . '</h4>';
                            echo '<small class="fechaA" style="font-size: 12px;">' . htmlspecialchars($row['fecha']) . '</small>';
                            echo '<p class="contenidoA mt-2" style="font-size: 14px;">' . nl2br(htmlspecialchars($row['contenido'])) . '</p>';
                            echo '<div class="text-end">';
                            echo '<a href="indexadmin.php?eliminar=' . (int) $row['id'] . '" onclick="return confirm(\'¿Seguro que quieres borrar este anuncio?\');" class="eliminarA">Eliminar</a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="text-center text-white">No hay anuncios publicados.</p>';
                    }
                    ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p class="Datix">DATIX</p>
        <p class="Llave">}</p>
    </footer>
</body>
</html>