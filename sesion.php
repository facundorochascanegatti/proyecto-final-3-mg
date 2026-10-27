<?php
$carpetaProyecto = str_replace("\\", "/", __DIR__);
$carpetaServidor = str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]);

if (!defined("BASE_URL")) {
    define("BASE_URL", rtrim(substr($carpetaProyecto, strlen($carpetaServidor)), "/"));
}

function iniciarSesionPorRol($rol) {
    if ($rol !== "admin" && $rol !== "club") {
        throw new InvalidArgumentException("El rol de sesión no es válido.");
    }

    $nombreSesion = $rol === "admin" ? "LIGA_ADMIN_SESSID" : "LIGA_CLUB_SESSID";

    if (session_status() === PHP_SESSION_ACTIVE) {
        if (session_name() !== $nombreSesion) {
            throw new RuntimeException("La sesión ya fue iniciada con otro rol.");
        }
        return;
    }

    session_name($nombreSesion);
    session_set_cookie_params(
        0,
        BASE_URL === "" ? "/" : BASE_URL,
        "",
        !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off",
        true
    );
    ini_set("session.cookie_samesite", "Lax");
    session_start();
}

function rolSesionDeLaSolicitud() {
    $rutaScript = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"] ?? "");

    if (
        basename($rutaScript) === "logout.php" &&
        isset($_GET["rol"]) &&
        ($_GET["rol"] === "admin" || $_GET["rol"] === "club")
    ) {
        return $_GET["rol"];
    }

    $rutaClub = BASE_URL . "/club/";

    return strpos($rutaScript, $rutaClub) === 0 ? "club" : "admin";
}
?>
