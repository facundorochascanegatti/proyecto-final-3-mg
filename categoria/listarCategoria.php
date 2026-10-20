<?php
require_once __DIR__ . "/../auth.php";
requerirAdmin();
require_once __DIR__ . "/../conexion.php";

$sql = "SELECT año, id FROM categorias ORDER BY año";
$resultado = mysqli_query($conn, $sql);
?>

<div class="Tabla">
<table class="tablaClubes" border="1">
    <tr>
        <th>Año</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>

    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
    <tr>
        <?php
        echo "<td>" . htmlspecialchars($fila["año"]) . "</td>";
        echo "<td><a href='editarCategoria.php?id=" . (int) $fila["id"] . "'>Editar</a></td>";
        echo "<td><a href='eliminarCategoria.php?id=" . (int) $fila["id"] . "'>Eliminar</a></td>";
        ?>
    </tr>
    <?php endwhile; ?>

    <?php if (mysqli_num_rows($resultado) == 0): ?>
    <tr>
        <td colspan="3">No hay categorías registradas.</td>
    </tr>
    <?php endif; ?>
</table>
</div>