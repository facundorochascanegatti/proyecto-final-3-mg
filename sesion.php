<?php
// se la carpeta del proyecto y la raiz del servidor, cambiando \ por / para que ande en windows
$carpetaProyecto = str_replace("\\", "/", __DIR__);
$carpetaServidor = str_replace("\\", "/", $_SERVER["DOCUMENT_ROOT"]);

// definimos BASE_URL una sola vez (si ya existe no la pisa)
// es la parte de la ruta que queda al restar la raiz del servidor a la carpeta del proyecto
// ej: si el proyecto esta en htdocs/proyectofinal queda "/proyectofinal"
if (!defined("BASE_URL")) {
    define("BASE_URL", rtrim(substr($carpetaProyecto, strlen($carpetaServidor)), "/"));
}

// inicia la sesion segun el rol (admin o club)
// cada rol tiene su propia cookie asi no se pisan las sesiones entre si
function iniciarSesionPorRol($rol) {
    // solo se aceptan estos dos roles, cualquier otro es un error
    if ($rol !== "admin" && $rol !== "club") {
        throw new InvalidArgumentException("El rol de sesión no es válido.");
    }

    // nombre de la cookie de sesion segun el rol
    $nombreSesion = $rol === "admin" ? "LIGA_ADMIN_SESSID" : "LIGA_CLUB_SESSID";

    // si ya hay una sesion abierta verifico que sea la del mismo rol
    if (session_status() === PHP_SESSION_ACTIVE) {
        if (session_name() !== $nombreSesion) {
            throw new RuntimeException("La sesión ya fue iniciada con otro rol.");
        }
        // si es la misma no hay que hacer nada mas
        return;
    }

    // el nombre se tiene que setear antes del session_start
    session_name($nombreSesion);

    // configuracion de la cookie de sesion
    session_set_cookie_params(
        0,                                                  // dura hasta cerrar el navegador
        BASE_URL === "" ? "/" : BASE_URL,                   // la cookie solo vale dentro de la carpeta del proyecto
        "",                                                 // dominio por defecto
        !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off", // solo por https si el sitio usa https
        true                                                // httponly, js no puede leer la cookie
    );

    // samesite Lax para evitar que la cookie se mande desde otros sitios (proteccion csrf)
    ini_set("session.cookie_samesite", "Lax");
    session_start();
}

// devuelve que rol de sesion corresponde a la pagina que se esta pidiendo
function rolSesionDeLaSolicitud() {
    // ruta del script actual con / en vez de \
    $rutaScript = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"] ?? "");

    // caso especial del logout, el rol viene por GET (logout.php?rol=club)
    // porque el logout esta fuera de las carpetas del club y no se podria deducir por la ruta
    if (
        basename($rutaScript) === "logout.php" &&
        isset($_GET["rol"]) &&
        ($_GET["rol"] === "admin" || $_GET["rol"] === "club")
    ) {
        return $_GET["rol"];
    }

    // si la ruta empieza con /club/ es sesion de club
    $rutaClub = BASE_URL . "/club/";

    // cualquier otra pagina se toma como admin
    return strpos($rutaScript, $rutaClub) === 0 ? "club" : "admin";
}
?>