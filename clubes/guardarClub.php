<?php
// Conexión a la base de datos "liga"
$conn = mysqli_connect("localhost", "root", "", "liga");

// Verifica si el formulario fue enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtiene el nombre del club enviado desde el formulario
    $nombreClub = $_POST["nombreClub"];

    // Verifica si se recibió un ID para editar un club existente
    if (!empty($_POST["id"])) {

        // Guarda el ID del club
        $id = $_POST["id"];

        // Consulta SQL para actualizar el nombre del club
        $sql = "UPDATE club SET nombre = '$nombreClub' WHERE id = $id";

        // Ejecuta la consulta de actualización
        mysqli_query($conn, $sql);

    } else {

        // Consulta SQL para insertar un nuevo club
        $sql = "INSERT INTO club (nombre) VALUES ('$nombreClub')";

        // Ejecuta la consulta de inserción
        mysqli_query($conn, $sql);
    }

    // Redirige a la página de gestión de clubes
    header("Location: gestionClubes.php");

    // Detiene la ejecución del código
    exit();
}