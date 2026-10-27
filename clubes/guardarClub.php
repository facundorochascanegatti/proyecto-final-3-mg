<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require "../conexion.php";   // esto reemplaza al mysqli_connect

// Verifica si el formulario fue enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtiene el nombre del club enviado desde el formulario
    // real_escape_string escapa las comillas para que no se pueda meter SQL
    $nombreClub = mysqli_real_escape_string($conn, trim($_POST["nombreClub"]));

    // Consulta SQL para insertar un nuevo club (editar lo hace editarClub.php)
    $sql = "INSERT INTO club (nombre) VALUES ('$nombreClub')";

    // Ejecuta la consulta de inserción
    mysqli_query($conn, $sql);

    // Redirige a la página de gestión de clubes
    header("Location: gestionClubes.php");

    // Detiene la ejecución del código
    exit();
}