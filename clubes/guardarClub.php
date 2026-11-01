<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtiene los datos del formulario
    $nombreClub = trim($_POST["nombreClub"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($nombreClub == "" || $password == "") {
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

    // Crea el club
    $sqlClub = "INSERT INTO club (nombre) VALUES ('$nombreSeguro')";

    if (mysqli_query($conn, $sqlClub)) {

        $idClub = mysqli_insert_id($conn);

        // Crea la cuenta usando el nombre del club como usuario
        $sqlUsuario = "INSERT INTO usuarios
                        (usuario, `contraseña`, rol, id_club)
                        VALUES ('$nombreSeguro', '$passwordSeguro', 'club', $idClub)";

        if (mysqli_query($conn, $sqlUsuario)) {
            mysqli_commit($conn);
            header("Location: gestionClubes.php");
            exit();
        }
    }

    mysqli_rollback($conn);

    header("Location: gestionClubes.php?error=datos");
    exit();
}
?>
