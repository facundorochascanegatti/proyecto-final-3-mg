<?php
require_once __DIR__ . "/../conexion.php";
require_once __DIR__ . "/../auth.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login.php");
    exit();
}

$usuario = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

// Consulta con prepare: así no se puede meter SQL en el usuario
$stmt = mysqli_prepare($conn, "SELECT usuario, `contraseña`, rol, id_club FROM usuarios WHERE usuario = ?");
mysqli_stmt_bind_param($stmt, "s", $usuario);
mysqli_stmt_execute($stmt);
$fila = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// password_verify compara la contraseña escrita con el hash guardado
if ($fila && password_verify($password, $fila["contraseña"])) {
    session_regenerate_id(true);
    $_SESSION["usuario"] = $fila["usuario"];
    $_SESSION["rol"] = $fila["rol"];
    $_SESSION["id_club"] = $fila["id_club"];

    if ($fila["rol"] === "admin") {
        header("Location: ../admin/indexadmin.php");
    } else {
        header("Location: ../club/indexclub.php");
    }
    exit();
}

header("Location: login.php?error=1");
exit();
