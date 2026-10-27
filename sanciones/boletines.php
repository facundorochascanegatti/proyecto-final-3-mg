<?php require_once __DIR__ . "/../auth.php"; requerirAdmin(); ?>
<?php
// Conexión a la base de datos "liga"
require_once __DIR__ . "/../conexion.php";

// Mensaje por si algo sale mal al subir el PDF
$errorBoletin = "";

// Si se subió un boletín, se guarda el PDF en la carpeta "boletines" y su nombre en la base
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdf"])) {

    $titulo = trim($_POST["titulo"]);
    $extension = strtolower(pathinfo($_FILES["pdf"]["name"], PATHINFO_EXTENSION));

    // Solo se aceptan archivos PDF
    if ($extension != "pdf") {
        $errorBoletin = "Solo se pueden subir archivos PDF.";
    } else {
        // Nombre único para que no se pise con otro boletín
        $nombreArchivo = "boletin_" . time() . ".pdf";

        // si el archivo no se pudo guardar en la carpeta, no se anota en la base
        if (!move_uploaded_file($_FILES["pdf"]["tmp_name"], __DIR__ . "/boletines/" . $nombreArchivo)) {
            $errorBoletin = "No se pudo subir el PDF.";
        } else {
            $fecha = date("Y-m-d");
            $stmt = mysqli_prepare($conn, "INSERT INTO boletines (titulo, archivo, fecha) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $titulo, $nombreArchivo, $fecha);
            mysqli_stmt_execute($stmt);

            header("Location: boletines.php");
            exit();
        }
    }
}

// Lista de boletines ya subidos, del más nuevo al más viejo
$resultadoBoletines = mysqli_query($conn, "SELECT * FROM boletines ORDER BY fecha DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boletines de Sanciones</title>
    <link href="sanciones.css" rel="stylesheet">
</head>
<body>
    <header>
        <!-- BARRA DE NAVEGACIÓN -->
        <?php include '../nav/nav.php'; ?>
    </header>
<!-- Botón para volver a las tarjetas -->
<div class="botonera">
    <a href="gestionarSanciones.php" class="boton"><i class="fa-solid fa-arrow-left"></i> Volver a tarjetas</a>
</div>


<!-- Formulario para subir un boletín de sanciones en PDF -->
<form action="boletines.php" method="post" enctype="multipart/form-data">

    <h1>Subir Boletín (PDF)</h1>

    <?php if ($errorBoletin): ?>
        <p class="aviso"><?= $errorBoletin ?></p>
    <?php endif; ?>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" placeholder="Ej: Boletín fecha 5" required><br>

    <label for="pdf">Archivo:</label>
    <input type="file" id="pdf" name="pdf" accept="application/pdf" required><br>

    <input type="submit" value="Subir Boletín">

</form>

<!-- Tabla de boletines publicados -->
<div class="Tabla">
<table class="tablaClubes">
    <tr>
        <th>Fecha</th>
        <th>Boletín</th>
        <th><i class="fa-solid fa-file-pdf"></i></th>
    </tr>
    <?php
    while ($fila = mysqli_fetch_assoc($resultadoBoletines)) {
        echo "<tr>";
        echo "<td>" . date("d/m/Y", strtotime($fila["fecha"])) . "</td>";
        echo "<td>" . htmlspecialchars($fila["titulo"]) . "</td>";
        echo "<td><a href='boletines/" . htmlspecialchars($fila["archivo"]) . "' target='_blank'>Ver PDF</a></td>";
        echo "</tr>";
    }
    if (mysqli_num_rows($resultadoBoletines) == 0) {
        echo "<tr><td colspan='3' class='vacio'>Todavía no se subió ningún boletín.</td></tr>";
    }
    ?>
</table>
</div>
</body>
</html>
