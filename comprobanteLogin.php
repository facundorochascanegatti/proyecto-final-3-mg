<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario  = $_POST["username"];
    $password = $_POST["password"];

    $conn = mysqli_connect("localhost", "root", "", "liga");

    $sql = "SELECT * FROM login WHERE usuario = '$usuario' AND contraseña = '$password'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        $_SESSION["usuario"] = $usuario;

        if ($usuario == "administrador") {
            header("Location: indexadmin.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    mysqli_close($conn);
}
?>