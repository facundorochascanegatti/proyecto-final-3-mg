<?php
// Revisa los datos de un jugador antes de guardarlo. Lo usan agregarJugador.php y editarJugador.php,
// así las reglas son las mismas al agregar y al editar.
// Devuelve "" si está todo bien, o el mensaje del error.
// $idJugador es 0 cuando se agrega uno nuevo (sirve para que al editar no choque con su propia cédula).

function validarJugador($conn, $nombre, $apellido, $cedula, $fechaNacimiento, $idCategoria, $idClub, $masa, $altura, $idJugador) {

    // nombre y apellido: empiezan con letra y solo tienen letras (con tildes y ñ), espacios, apóstrofe o guion, entre 2 y 45
    // la "u" al final hace que funcione con tildes y ñ
    $soloLetras = "/^\p{L}[\p{L}' -]{1,44}$/u";
    if (!preg_match($soloLetras, $nombre) || !preg_match($soloLetras, $apellido)) {
        return "El nombre y el apellido solo pueden tener letras.";
    }

    // la cédula tiene que tener 8 dígitos
    if (!preg_match("/^[0-9]{8}$/", $cedula)) {
        return "La cédula debe tener 8 dígitos.";
    }

    // la cédula no puede ser de otro jugador
    $resultado = mysqli_query($conn, "SELECT id FROM jugadores WHERE cedula = '$cedula' AND id != $idJugador");
    if (mysqli_num_rows($resultado) > 0) {
        return "Esa cédula ya pertenece a otro jugador.";
    }

    // la fecha tiene que ser real (checkdate revisa mes, día y año)
    $partes = explode("-", $fechaNacimiento);
    if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $fechaNacimiento) || !checkdate($partes[1], $partes[2], $partes[0])) {
        return "La fecha de nacimiento no es válida.";
    }
    $añoNacimiento = (int) $partes[0];

    // el año de nacimiento tiene que estar entre la categoría más vieja y la más nueva (así no entra uno de 1600)
    $años = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MIN(año) AS minimo, MAX(año) AS maximo FROM categorias WHERE año != 'Femenino'"));
    if ($añoNacimiento < $años["minimo"] || $añoNacimiento > $años["maximo"]) {
        return "El jugador tiene que haber nacido entre " . $años["minimo"] . " y " . $años["maximo"] . ".";
    }

    // la categoría tiene que existir y ser la de su año (o Femenino)
    $categoria = mysqli_fetch_assoc(mysqli_query($conn, "SELECT año FROM categorias WHERE id = $idCategoria"));
    if (!$categoria) {
        return "Seleccione una categoría.";
    }
    if ($categoria["año"] != "Femenino" && $categoria["año"] != $añoNacimiento) {
        return "El jugador nació en $añoNacimiento, tiene que ir en la categoría $añoNacimiento o en Femenino.";
    }

    // el club tiene que existir
    $club = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM club WHERE id = $idClub"));
    if (!$club) {
        return "Seleccione un club.";
    }

    // masa en kg y altura en metros, que no sean negativas ni números imposibles
    if (!is_numeric($masa) || $masa <= 0 || $masa > 150) {
        return "La masa tiene que estar entre 0 y 150 kg.";
    }
    if (!is_numeric($altura) || $altura <= 0 || $altura > 2.5) {
        return "La altura va en metros (por ejemplo 1.45).";
    }

    return "";
}
