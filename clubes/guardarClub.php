<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtiene los datos del formulario
    $nombreClub = trim($_POST["nombreClub"] ?? "");
    $password = $_POST["password"] ?? "";
    $presidente = $_POST["presidente"] ?? "";
    $estadio = $_POST["estadio"] ?? "";
    $fundacion = $_POST["fundacion"] ?? "";

    if ($nombreClub == "" || $password == "" || $fundacion == "") {
        header("Location: gestionClubes.php?error=datos");
        exit();
    }

    // El nombre del club también será el usuario
    $nombreSeguro = mysqli_real_escape_string($conn, $nombreClub);

    // Comprueba si el usuario ya existe
    $consulta = mysqli_query(
        $conn,
        "SELECT usuario FROM usuarios WHERE usuario = '$nombreSeguro'"
    );

    if (mysqli_num_rows($consulta) > 0) {
        header("Location: gestionClubes.php?error=usuario");
        exit();
    }

    // Encripta la contraseña
    $passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);
    $passwordSeguro = mysqli_real_escape_string($conn, $passwordEncriptada);

    mysqli_begin_transaction($conn);

    try {
        mysqli_query($conn, "INSERT INTO club (nombre) VALUES ('$nombreSeguro')");
        $idClub = mysqli_insert_id($conn);

        mysqli_query($conn, "INSERT INTO usuarios
                    (usuario, `contraseña`, rol, id_club)
                    VALUES ('$nombreSeguro', '$passwordSeguro', 'club', $idClub)");

        mysqli_commit($conn);
        header("Location: gestionClubes.php");
        exit();

    } catch (mysqli_sql_exception $e) {
        // si falló cualquiera de los dos inserts, se deshace todo
        mysqli_rollback($conn);
        header("Location: gestionClubes.php?error=datos");
        exit();
    }
}
?>
