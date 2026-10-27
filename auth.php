<?php

require_once __DIR__ . "/sesion.php";
iniciarSesionPorRol(rolSesionDeLaSolicitud());

// Protege los textos que se muestran en HTML
function h($texto) {
    return htmlspecialchars((string) $texto, ENT_QUOTES, "UTF-8");
}

// Verifica que el usuario haya iniciado sesión
function requerirLogin() {
    if (!isset($_SESSION["usuario"])) {
        header("Location: " . BASE_URL . "/login/login.php");
        exit();
    }
}

// Permite el acceso solamente al administrador
function requerirAdmin() {
    requerirLogin();

    if ($_SESSION["rol"] !== "admin") {
        header("Location: " . BASE_URL . "/club/indexclub.php");
        exit();
    }
}

// Permite el acceso al club que inició sesión
function requerirClub() {
    requerirLogin();

    if ($_SESSION["rol"] === "admin") {
        header("Location: " . BASE_URL . "/admin/indexadmin.php");
        exit();
    }

    if (empty($_SESSION["id_club"])) {
        header("Location: " . BASE_URL . "/login/logout.php?rol=club");
        exit();
    }
}
?>
