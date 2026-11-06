<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require "../conexion.php";

$club = null;

if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $resultado = mysqli_query($conn, "SELECT * FROM club WHERE id = $id");
    $club = mysqli_fetch_assoc($resultado);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST["id"];
    $nombreClub = mysqli_real_escape_string($conn, trim($_POST["nombreClub"]));
    $fundacion = (int) $_POST["fundacion"];
    $presidente = mysqli_real_escape_string($conn, trim($_POST["presidente"]));
    $estadio = mysqli_real_escape_string($conn, trim($_POST["estadio"]));

    mysqli_query($conn, "UPDATE club SET nombre = '$nombreClub', fundacion = $fundacion, presidente = '$presidente', estadio = '$estadio' WHERE id = $id");

    // si eligió un logo nuevo, lo guarda
    if (isset($_FILES["logo"]) && $_FILES["logo"]["error"] == 0) {

        $extension = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));

        if (in_array($extension, ["jpg", "jpeg", "png"])) {

            $nombreLogo = "club_" . $id . "." . $extension;

            if (move_uploaded_file($_FILES["logo"]["tmp_name"], __DIR__ . "/logos/" . $nombreLogo)) {

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

            <label for="fundacion">Año de fundación:</label>
            <input type="number" id="fundacion" name="fundacion" required value="<?= htmlspecialchars($club['fundacion']) ?>">
            <br><br>

            <label for="presidente">Presidente:</label>
            <input type="text" id="presidente" name="presidente" required value="<?= htmlspecialchars($club['presidente']) ?>">
            <br><br>

            <label for="estadio">Estadio:</label>
            <input type="text" id="estadio" name="estadio" required value="<?= htmlspecialchars($club['estadio']) ?>">
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