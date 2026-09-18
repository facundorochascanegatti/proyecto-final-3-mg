<?php
// Conexión a la base de datos "liga"
$conn = mysqli_connect("localhost", "root", "", "liga");

// Verifica si se recibió un ID por la URL
if (isset($_GET["id"])) {

    // Guarda el ID recibido
    $id = $_GET["id"];

    // Elimina el club que corresponde al ID recibido
    $sql = "DELETE FROM club WHERE id = $id";
    mysqli_query($conn, $sql);
}

// Redirige nuevamente a la página de gestión de clubes
header("Location: gestionClubes.php");

// Detiene la ejecución del código
exit();