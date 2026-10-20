<?php
// Conexión a la base de datos "liga"
$conn = mysqli_connect("localhost", "root", "", "liga");

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];

    // Primero se borra la foto de la carpeta, después el carnet de la base
    $resultado = mysqli_query($conn, "SELECT foto FROM carnets WHERE id = $id");
    $carnet = mysqli_fetch_assoc($resultado);
    if ($carnet && file_exists(__DIR__ . "/fotos/" . $carnet["foto"])) {
        unlink(__DIR__ . "/fotos/" . $carnet["foto"]);
    }
    mysqli_query($conn, "DELETE FROM carnets WHERE id = $id");
}

// Vuelve a la página de carnets
header("Location: gestionarCarnets.php");
exit();
