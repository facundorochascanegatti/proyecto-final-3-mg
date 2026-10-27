<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
require "../conexion.php";   // esto reemplaza al mysqli_connect

if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];

    // si la categoría tiene jugadores o partidos no se borra, porque esos quedarían sin categoría y desaparecerían de las listas
    $enUso = mysqli_query($conn, "SELECT id FROM jugadores WHERE id_categoria = $id UNION SELECT id FROM partidos WHERE id_categoria = $id");
    if (mysqli_num_rows($enUso) > 0) {
        header("Location: gestionarCategoria.php?enUso=1");
        exit();
    }

    $sql = "DELETE FROM categorias WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: gestionarCategoria.php");
exit();
?>