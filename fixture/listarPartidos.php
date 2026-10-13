
<?php
require_once __DIR__ . "/../conexion.php";

$sql = "SELECT partidos.*,
        local.nombre AS nombre_local,
        visitante.nombre AS nombre_visitante,
        categorias.año AS nombre_categoria
        FROM partidos
        INNER JOIN club AS local
        ON partidos.id_club_local = local.id
        INNER JOIN club AS visitante
        ON partidos.id_club_visitante = visitante.id
        INNER JOIN categorias
        ON partidos.id_categoria = categorias.id
        ORDER BY partidos.fecha IS NULL DESC, partidos.fecha ASC";

$resultado = mysqli_query($conn, $sql);
?>

<div class="Tabla">
    <table class="tablaPartidos" border="1">
        <tr>
            <th>Club local</th>
            <th>Club visitante</th>
            <th>Categoría</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Resultado</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </tr>

        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($fila['nombre_local']); ?></td>
            <td><?php echo htmlspecialchars($fila['nombre_visitante']); ?></td>
            <td><?php echo htmlspecialchars($fila['nombre_categoria']); ?></td>

            <td>
                <?php
                if ($fila['fecha'] == NULL) {
                    echo "Sin fecha";
                } else {
                    echo htmlspecialchars($fila['fecha']);
                }
                ?>
            </td>

            <td><?php echo htmlspecialchars($fila['estado']); ?></td>

            <td>
                <?php
                if ($fila['goles_local'] === NULL ||
                    $fila['goles_visitante'] === NULL) {
                    echo "-";
                } else {
                    echo $fila['goles_local'] . " - " . $fila['goles_visitante'];
                }
                ?>
            </td>

            <td>
                <a href="editarPartido.php?id=<?php echo $fila['id']; ?>">Editar</a>
            </td>

            <td>
                <a href="eliminarPartido.php?id=<?php echo $fila['id']; ?>"
                   onclick="return confirm('¿Seguro que querés eliminar este partido?');">
                    Eliminar
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
