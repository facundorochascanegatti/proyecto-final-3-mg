<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link href="../css/sanciones.css" rel="stylesheet">
</head>
<body>
    <form>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required><br><br>
        <label for="sancion">Sanción:</label>
        <select name="sancion" id="sancion" required>
            <option value="">Seleccione una sanción</option>
            <option value="Amarilla">Amarilla</option>
            <option value="Roja">Roja</option>
        </select><br><br>
        <button type="submit">Registrar Sanción</button>
    </form>

</body>
</html>