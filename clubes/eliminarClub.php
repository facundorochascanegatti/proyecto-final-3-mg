<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require "../conexion.php";   // esto reemplaza al mysqli_connect

// Verifica si se recibió un ID por la URL
if (isset($_GET["id"])) {

    // Guarda el ID recibido, (int) hace que solo pueda ser un número
    $id = (int) $_GET["id"];

    // si el club tiene jugadores o partidos no se borra, porque esos quedarían sin club y desaparecerían de las listas
    $enUso = mysqli_query($conn, "SELECT id FROM jugadores WHERE id_club = $id UNION SELECT id FROM partidos WHERE id_club_local = $id OR id_club_visitante = $id");
    if (mysqli_num_rows($enUso) > 0) {
        header("Location: gestionClubes.php?enUso=1");
        exit();
    }

    // Elimina el club que corresponde al ID recibido
    $sql = "DELETE FROM club WHERE id = $id";
    mysqli_query($conn, $sql);
}

// Redirige nuevamente a la página de gestión de clubes
header("Location: gestionClubes.php");

// Detiene la ejecución del código
exit();