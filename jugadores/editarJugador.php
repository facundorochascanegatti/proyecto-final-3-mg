<?php
/* esto sirve para conectar la base de datos "liga" */
$conn = mysqli_connect("localhost", "root", "", "liga");
/* esta variable guarda los datos del jugador, la iniciamos en null por si no se encuentra algun jugador */
$jugador = null;

/*verifica si se recibio un id por GET, si es asi, busca el jugador en la base de datos y guarda sus datos en la variable $jugador */
if (isset($_GET["id"])) {
    /*esta variable guarda el id del jugador que se quiere editar*/
    $id = $_GET["id"];
    /*busca el jugador en la base de datos y guarda sus datos en la variable $jugador*/
    $resultado = mysqli_query($conn, "SELECT * FROM jugadores WHERE id = $id");
    /*guarda los datos del jugador en la variable $jugador*/
    $jugador = mysqli_fetch_assoc($resultado);
}
/*verifica si se recibio un formulario por POST, si es asi, actualiza los datos del jugador en la base de datos*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*se obtiene los datos enviados desde el formulario*/
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $cedula = $_POST["cedula"];
    $fechaNacimiento = $_POST["fecha_nacimiento"];
    $masa = $_POST["masa"];
    $altura = $_POST["altura"];
    $gravedad = 9.8;
    $peso = $masa * $gravedad;
    /*actualiza los datos del jugador en la base de datos*/
    mysqli_query($conn, "UPDATE jugadores SET nombre = '$nombre', apellido = '$apellido', cedula = '$cedula', fecha_nacimiento = '$fechaNacimiento', masa = '$masa', altura = '$altura', peso = '$peso' WHERE id = $id");
    /*redirige a la pagina de gestion de jugadores*/
    header("Location: gestionarJugadores.php");
    /*para de ejecutar el codigo*/
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<body>

<?php if ($jugador): ?>
        <!-- Formulario para editar los datos del jugador -->
    <form action="editarJugador.php" method="post">
        <!-- Campo oculto que guarda el ID del jugador -->
        <input type="hidden" name="id" value="<?= $jugador['id'] ?>">
        <!-- Campo para editar el nombre -->
        <input type="text" name="nombre" value="<?= $jugador['nombre'] ?>">
        <!-- Campo para editar el apellido -->
        <input type="text" name="apellido" value="<?= $jugador['apellido'] ?>">
        <!-- Campo para editar la cédula -->
        <input type="text" name="cedula" value="<?= $jugador['cedula'] ?>">
        <!-- Campo para editar la fecha de nacimiento -->
        <input type="date" name="fecha_nacimiento" value="<?= $jugador['fecha_nacimiento'] ?>">
        <!-- Botón para guardar los cambios -->
        <input type="submit" value="Guardar">
    </form>
<?php endif; ?>

</body>
</html>