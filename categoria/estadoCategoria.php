<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require "../conexion.php";

// solo se acepta POST (el formulario de listarCategoria.php)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int) $_POST["id"];

    // 1 - activo da la vuelta el valor: si estaba en 1 pasa a 0, y si estaba en 0 pasa a 1
    $stmt = mysqli_prepare($conn, "UPDATE categorias SET activo = 1 - activo WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header("Location: gestionarCategoria.php");
exit();