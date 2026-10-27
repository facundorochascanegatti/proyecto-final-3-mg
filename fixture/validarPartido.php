<?php
// Revisa los datos de un partido antes de guardarlo. Lo usan agregarPartido.php y editarPartido.php.
// Devuelve "" si está todo bien, o el mensaje del error.

function validarPartido($local, $visitante, $fecha, $estado, $golesLocal, $golesVisitante) {

    if ($local == $visitante) {
        return "Los dos clubes no pueden ser el mismo.";
    }

    // el estado tiene que ser uno de estos
    if (!in_array($estado, ["sin_fecha", "programado", "jugado", "pendiente", "suspendido"])) {
        return "El estado no es válido.";
    }

    // si se puso fecha, que sea una fecha real (checkdate revisa mes, día y año)
    if ($fecha != "") {
        $partes = explode("-", $fecha);
        if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $fecha) || !checkdate($partes[1], $partes[2], $partes[0])) {
            return "La fecha no es válida.";
        }
    }

    if ($estado == "programado" && $fecha == "") {
        return "Un partido programado tiene que tener fecha.";
    }

    if ($estado == "sin_fecha" && $fecha != "") {
        return "Si el partido tiene fecha, el estado no puede ser sin_fecha.";
    }

    // los goles van los dos o ninguno, y tienen que ser números enteros de 0 para arriba
    if (($golesLocal == "") != ($golesVisitante == "")) {
        return "Cargá los goles de los dos clubes (o de ninguno).";
    }
    $hayGoles = $golesLocal != "";
    if ($hayGoles && (!ctype_digit($golesLocal) || !ctype_digit($golesVisitante))) {
        return "Los goles tienen que ser números enteros.";
    }

    // solo un partido jugado tiene resultado, y no puede haberse jugado en el futuro
    if ($estado == "jugado") {
        if (!$hayGoles) {
            return "Para marcarlo como jugado cargá los goles.";
        }
        if ($fecha == "" || $fecha > date("Y-m-d")) {
            return "Un partido jugado tiene que tener fecha, y no puede ser una fecha futura.";
        }
    } elseif ($hayGoles) {
        return "Los goles solo se cargan si el partido está jugado.";
    }

    return "";
}
