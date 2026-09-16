<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

if (isset($_POST["año"]) && isset($_POST["genero"])) {

    $año = $_POST["año"];
    $genero = $_POST["genero"];

    $buscar = "SELECT * FROM categorias
    WHERE año = '$año' AND genero = '$genero'";

    $resultado = mysqli_query($conn, $buscar);

    if (mysqli_num_rows($resultado) > 0) {

        echo "Esa categoria ya esta registrada, intente con otra.";

    } else {

        $sql = "INSERT INTO categorias (año, genero)
                VALUES ('$año', '$genero')";

        mysqli_query($conn, $sql);

        echo "Categoría guardada correctamente";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../categoria/categoria.css" rel="stylesheet">
    <!-- ESTO DE ABAJO ES UNA LIBRERIA PARA LOS ICONOS DE LA PAGINA -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Gestionar Categorías</title>
</head>
<body>
        <header>

        <!-- ESTO DE ABAJO ES UNA BARRA DE NAVEGACIÓN PARA LA PÁGINA -->
        <nav>
            <a href="../admin/indexadmin.php" class="home">
                <i class="fa-solid fa-house"></i>
            </a>
            <a href="gestionSanciones.php">Sanciones</a>
            <a href="admin/gestionCarnets.php">Carnets</a>
            <a href="../admin/gestionarCategoria.php">Categorias</a>
            <a href="../clubes/gestionClubes.php">Clubes</a>
            <a href="../jugadores/gestionarJugadores.php">Jugadores</a>
        </nav>
    </header>
    <h1 class="tituloCategoria">Gestionar Categorías</h1>
    <p class="parrafoCategoria">
        Aquí puedes gestionar las categorías de los jugadores.
    </p>

    <form action="gestionarCategoria.php" method="post">

        <label for="año">Año de categoría:</label>
        <input type="text" id="año" name="año" required>
        <br><br>

        <label for="genero">Género:</label>
        <select name="genero" id="genero" required>
            <option value="">Seleccione un género</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
        </select>

        <br><br>

        <input type="submit" value="Agregar Categoría">

    </form>
</body>
</html>