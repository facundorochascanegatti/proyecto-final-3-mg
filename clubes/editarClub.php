<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require "../conexion.php";   // esto reemplaza al mysqli_connect

/* esta variable guarda los datos del club, la iniciamos en null por si no se encuentra */
$club = null;

/* verifica si se recibio un id por GET, si es asi, busca el club en la base de datos */
if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $resultado = mysqli_query($conn, "SELECT * FROM club WHERE id = $id");
    //esto de $club es el resultado de lo de arriba, si no encuentra el club, $club queda en null
    $club = mysqli_fetch_assoc($resultado);
}

/* verifica si se recibio un formulario por POST, si es asi, actualiza el nombre y el logo del club */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST["id"];
    $nombreClub = mysqli_real_escape_string($conn, trim($_POST["nombreClub"]));

    mysqli_query($conn, "UPDATE club SET nombre = '$nombreClub' WHERE id = $id");

    // si eligió un logo nuevo, lo guarda
    // $_FILES["logo"]["error"] == 0 significa que el archivo se subió bien
    if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {

        // la extensión tiene que ser jpg, jpeg o png
        $extension = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));

        if (in_array($extension, ["jpg", "jpeg", "png"])) {

            // nombre del archivo basado en el id del club, así no se repite
            $nombreLogo = "club_" . $id . "." . $extension;

            // mueve el archivo a la carpeta logos, si no se pudo no se guarda nada en la base
            if (move_uploaded_file($_FILES["logo"]["tmp_name"], __DIR__ . "/logos/" . $nombreLogo)) {

                // guarda el nombre del archivo en la base de datos
                $stmt = mysqli_prepare($conn, "UPDATE club SET logo = ? WHERE id = ?");
                mysqli_stmt_bind_param($stmt, "si", $nombreLogo, $id);
                mysqli_stmt_execute($stmt);
            }
        }
    }

    header("Location: gestionClubes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="clubes.css">
    <title>Editar Club</title>
</head>
<body>

    <header>
        <?php include '../nav/nav.php'; ?>
    </header>

    <?php if ($club): ?>
    <h1 class="tituloClubes">Editar Club</h1>
    <div class="Casilla">
        <form action="editarClub.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $club['id'] ?>">
            <input type="text" id="nombreClub" name="nombreClub" required class="nombreClub" value="<?= htmlspecialchars($club['nombre']) ?>">
            <br><br>

            <?php if ($club["logo"]): ?>
                <p>Logo actual:</p>
                <img src="logos/<?= htmlspecialchars($club['logo']) ?>" alt="logo" width="80">
                <br><br>
            <?php endif; ?>

            <label for="logo">Logo (JPG o PNG):</label>
            <input type="file" id="logo" name="logo" accept="image/png, image/jpeg">
            <br><br>

            <input type="submit" value="Guardar Cambios" class="Agregar">
        </form>
    </div>
    <?php endif; ?>

</body>
</html>