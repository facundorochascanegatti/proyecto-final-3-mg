<?php
$db = new PDO('sqlite:' . __DIR__ . '/sanciones.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS sanciones (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    apellido TEXT NOT NULL,
    tipo_sancion TEXT NOT NULL,
    ci_jugador TEXT NOT NULL,
    motivo_sancion TEXT NOT NULL,
    plazo_sancion TEXT NOT NULL
)");

$columnas = $db->query("PRAGMA table_info(sanciones)")->fetchAll(PDO::FETCH_COLUMN, 1);
if (!in_array('nombre', $columnas, true)) {
    $db->exec("ALTER TABLE sanciones ADD COLUMN nombre TEXT NOT NULL DEFAULT ''");
}
if (!in_array('apellido', $columnas, true)) {
    $db->exec("ALTER TABLE sanciones ADD COLUMN apellido TEXT NOT NULL DEFAULT ''");
}
 
$editar = null;
$error = '';
 
// eliminar
if (isset($_GET['eliminar'])) {
    $db->prepare("DELETE FROM sanciones WHERE id = ?")->execute([(int)$_GET['eliminar']]);
    header("Location: gestionSanciones.php");
    exit;
}
 
// traer datos de una sanción para editarla
if (isset($_GET['editar'])) {
    $stmt = $db->prepare("SELECT * FROM sanciones WHERE id = ?");
    $stmt->execute([(int)$_GET['editar']]);
    $editar = $stmt->fetch(PDO::FETCH_ASSOC);
}
 
// guardar (nueva sanción o edición)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = $_POST['id'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $tipo   = trim($_POST['tipo_sancion']);
    $ci     = preg_replace('/[^0-9]/', '', $_POST['ci_jugador']);
    $motivo = trim($_POST['motivo_sancion']);
    $plazo  = trim($_POST['plazo_sancion']);
 
     if ($nombre !== '' && $apellido !== '' && $tipo !== '' && $ci !== '' && $motivo !== '' && $plazo !== '') {
        if ($id !== '') {
                $db->prepare("UPDATE sanciones SET nombre=?, apellido=?, tipo_sancion=?, ci_jugador=?, motivo_sancion=?, plazo_sancion=? WHERE id=?")
                    ->execute([$nombre, $apellido, $tipo, $ci, $motivo, $plazo, $id]);
        } else {
                $db->prepare("INSERT INTO sanciones (nombre, apellido, tipo_sancion, ci_jugador, motivo_sancion, plazo_sancion) VALUES (?, ?, ?, ?, ?, ?)")
                    ->execute([$nombre, $apellido, $tipo, $ci, $motivo, $plazo]);
        }
        header("Location: gestionSanciones.php");
        exit;
    }
    $error = 'Completá todos los campos, incluido el nombre y apellido del jugador.';
    $editar = ['id' => $id, 'nombre' => $nombre, 'apellido' => $apellido, 'tipo_sancion' => $tipo, 'ci_jugador' => $ci, 'motivo_sancion' => $motivo, 'plazo_sancion' => $plazo];
}
 
$sanciones = $db->query("SELECT * FROM sanciones ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sanciones</title>
<style>
* { box-sizing: border-box; }
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    color: #263238;
    margin: 0;
    padding: 30px;
}
.contenedor {
    max-width: 950px;
    margin: 0 auto;
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
}
h1 {
    color: #1c3f60;
    margin-top: 0;
}
.introduccion {
    color: #607d8b;
}
.aviso-error {
    color: #842029;
    background: #f8d7da;
    border: 1px solid #f5c2c7;
    padding: 10px;
    border-radius: 4px;
}
form {
    display: grid;
    gap: 12px;
    margin: 20px 0;
}
label {
    font-weight: bold;
}
input {
    display: block;
    width: 100%;
    padding: 9px;
    margin-top: 5px;
    border: 1px solid #c8d0d6;
    border-radius: 4px;
    font: inherit;
}
input:focus {
    outline: none;
    border-color: #1c3f60;
    box-shadow: 0 0 0 2px rgba(28, 63, 96, .12);
}
button {
    background: #1c3f60;
    color: white;
    border: 0;
    padding: 10px 16px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}
button:hover { background: #16324c; }
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
th, td {
    border: 1px solid #d5dce1;
    padding: 9px 10px;
    text-align: left;
}
th { background: #1c3f60; color: white; }
tr:nth-child(even) { background: #f8fafb; }
td a {
    color: #1c3f60;
    margin-right: 10px;
    text-decoration: none;
}
td a:hover { text-decoration: underline; }
.vacio {
    color: #607d8b;
    padding: 15px 0;
    text-align: center;
}
@media (max-width: 700px) {
    body { padding: 15px; }
    .contenedor { padding: 18px; }
    .tabla-contenedor { overflow-x: auto; }
    table { min-width: 650px; }
}
</style>
</head>
<body>
<div class="contenedor">
<h1>Gestión de sanciones</h1>
<p class="introduccion">Registrá y administrá las sanciones correspondientes a cada jugador.</p>

<?php if ($error): ?><p class="aviso-error"><?= htmlspecialchars($error) ?></p><?php endif; ?>

<form method="POST" action="gestionSanciones.php">
<?php if ($editar): ?><input type="hidden" name="id" value="<?= htmlspecialchars($editar['id']) ?>"><?php endif; ?>

<label>Nombre del jugador
    <input type="text" name="nombre" placeholder="Ej: Juan" value="<?= htmlspecialchars($editar['nombre'] ?? '') ?>">
</label>

<label>Apellido del jugador
    <input type="text" name="apellido" placeholder="Ej: Pérez" value="<?= htmlspecialchars($editar['apellido'] ?? '') ?>">
</label>

<label>Tipo de sanción
    <input type="text" name="tipo_sancion" placeholder="Ej: Suspensión" value="<?= htmlspecialchars($editar['tipo_sancion'] ?? '') ?>">
</label>

<label>Documento del jugador
    <input type="text" name="ci_jugador" placeholder="Ej: 4567890" value="<?= htmlspecialchars($editar['ci_jugador'] ?? '') ?>">
</label>

<label>Motivo de la sanción
    <input type="text" name="motivo_sancion" placeholder="Ej: Acumulación de tarjetas" value="<?= htmlspecialchars($editar['motivo_sancion'] ?? '') ?>">
</label>

<label>Duración de la sanción
    <input type="text" name="plazo_sancion" placeholder="Ej: 2 partidos" value="<?= htmlspecialchars($editar['plazo_sancion'] ?? '') ?>">
</label>

<p><button type="submit"><?= $editar ? 'Guardar modificación' : 'Registrar sanción' ?></button></p>
</form>

<div class="tabla-contenedor">
<table>
<tr>
<th>Jugador</th>
<th>Tipo de sanción</th>
<th>C.I de jugador</th>
<th>Motivo de sanción</th>
<th>Plazo de sanción</th>
<th></th>
</tr>
<?php if (empty($sanciones)): ?>
<tr><td colspan="6" class="vacio">Todavía no hay sanciones registradas.</td></tr>
<?php endif; ?>
<?php foreach ($sanciones as $s): ?>
<tr>
<td><?= htmlspecialchars(trim(($s['nombre'] ?? '') . ' ' . ($s['apellido'] ?? ''))) ?></td>
<td><?= htmlspecialchars($s['tipo_sancion']) ?></td>
<td><?= htmlspecialchars($s['ci_jugador']) ?></td>
<td><?= htmlspecialchars($s['motivo_sancion']) ?></td>
<td><?= htmlspecialchars($s['plazo_sancion']) ?></td>
<td>
<a href="?editar=<?= (int)$s['id'] ?>">Modificar</a>
<a href="?eliminar=<?= (int)$s['id'] ?>" onclick="return confirm('¿Seguro que querés eliminar esta sanción? Esta acción no se puede deshacer.')">Quitar</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</div>
</div>
</body>
</html> 