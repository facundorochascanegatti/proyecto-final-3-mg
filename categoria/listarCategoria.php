<?php
require_once "../conexion.php";   // esto reemplaza al mysqli_connect

$sql = "SELECT año, genero, cantidad_jugadores, id FROM categorias";

$resultado = mysqli_query($conn, $sql);
?>

<div class="Tabla">
<table class="tablaClubes" border="1">
    <tr>
        <th>Año</th>
        <th>Genero</th>
        <th>Cantidad de Jugadores</th>
        <th>Editar</th>
        <th>Eliminar</th>
    </tr>

    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
    <tr>
        <?php
        echo "<td>" . htmlspecialchars($fila["año"]) . "</td>";
        echo "<td>" . htmlspecialchars($fila["genero"]) . "</td>";
        echo "<td>" . htmlspecialchars($fila["cantidad_jugadores"]) . "</td>";

        // Femenino es una categoría fija del sistema: no se edita ni se elimina
        if ($fila["genero"] !== "Femenino") {
            echo "<td><a href='editarCategoria.php?id=" . (int) $fila["id"] . "'>Editar</a></td>";
            echo "<td><a href='eliminarCategoria.php?id=" . (int) $fila["id"] . "'>Eliminar</a></td>";
        } else {
            echo "<td>-</td>";
            echo "<td>-</td>";
        }
        ?>
    </tr>
    <?php endwhile; ?>
</table>
</div>