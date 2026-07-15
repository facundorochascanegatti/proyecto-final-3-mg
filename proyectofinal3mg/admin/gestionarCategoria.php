<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/categoria.css" rel="stylesheet">
    <title>Gestionar Categorías</title>
</head>
<body>
    <h1 class="tituloCategoria">Gestionar Categorías</h1>
    <p class="parrafoCategoria">Aquí puedes gestionar las categorías de los jugadores.</p>
    <form action="gestionarCategorias.php" method="post">
        <label for="nombreCategoria">Nombre de la Categoría:</label>
        <input type="text" id="nombreCategoria" name="nombreCategoria" required><br><br>
        <input type="submit" value="Agregar Categoría">
    </form>




    
</body>
</html>