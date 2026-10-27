<?php
// Barra de navegación del club. Se incluye en todas las páginas del club.
// BASE_URL es la carpeta del proyecto (sale de sesion.php), así los links andan desde club/ y desde club/carnets/
?>
<nav class="menu">
    <a href="<?= BASE_URL ?>/club/indexclub.php">Inicio</a>
    <a href="<?= BASE_URL ?>/club/jugadores.php">Jugadores</a>
    <a href="<?= BASE_URL ?>/club/sanciones.php">Sanciones</a>
    <a href="<?= BASE_URL ?>/club/partidos.php">Partidos</a>
    <a href="<?= BASE_URL ?>/club/posiciones.php">Posiciones</a>
    <a href="<?= BASE_URL ?>/club/avisos.php">Avisos y boletines</a>
    <a href="<?= BASE_URL ?>/club/carnets/gestionarCarnets.php">Carnets</a>
    <a href="<?= BASE_URL ?>/club/planilla.php">Planilla</a>
    <a href="<?= BASE_URL ?>/login/logout.php?rol=club" class="salir">Cerrar Sesión</a>
</nav>
