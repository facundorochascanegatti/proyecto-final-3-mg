<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require_once __DIR__ . "/../conexion.php";

$sql = "SELECT año, id, activo FROM categorias ORDER BY año";
$resultado = mysqli_query($conn, $sql);
?>

<div class="Tabla">
<table class="tablaClubes" border="1">
    <tr>
        <th>Año</th>
        <th>Estado</th>
        <th>Editar</th>
        <th>Activar / Desactivar</th>
    </tr>

    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
    <tr>
        <td><?= htmlspecialchars($fila["año"]) ?></td>
        <td><?= $fila["activo"] ? "Activa" : "Inactiva" ?></td>
        <td><a href="editarCategoria.php?id=<?= (int) $fila["id"] ?>">Editar</a></td>
        <td>
            <!-- es un formulario POST: cambiar el estado no se puede hacer entrando a un enlace -->
            <form action="gestionarCategoria.php" method="post"
                  onsubmit="return confirm('¿Cambiar el estado de esta categoría?')">
                <input type="hidden" name="id" value="<?= (int) $fila["id"] ?>">
                <input type="hidden" name="cambiar_estado" value="1">
                <input type="submit" value="<?= $fila["activo"] ? "Desactivar" : "Activar" ?>">
            </form>
        </td>
    </tr>
    <?php endwhile; ?>

    <?php if (mysqli_num_rows($resultado) == 0): ?>
    <tr>
        <td colspan="4">No hay categorías registradas.</td>
    </tr>
    <?php endif; ?>
</table>
</div>