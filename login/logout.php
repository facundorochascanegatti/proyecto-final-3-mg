<?php
require_once __DIR__ . "/../sesion.php";

$rol = rolSesionDeLaSolicitud();
iniciarSesionPorRol($rol);
session_destroy();

$parametrosCookie = session_get_cookie_params();
setcookie(session_name(), "", time() - 42000, $parametrosCookie["path"], $parametrosCookie["domain"], $parametrosCookie["secure"], $parametrosCookie["httponly"]);

header("Location: login.php");
exit();
