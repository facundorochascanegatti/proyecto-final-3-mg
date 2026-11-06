<?php

//esto basicamente es para que no tire error si no se puede conectar a la base de datos, y en ese caso muestre un mensaje de error
//el try catch es para manejar excepciones, aca en este caso si no se puede conectar a la base de datos,
// se lanza una excepcion y se muestr el msj de error
try {
    $conn = mysqli_connect("localhost", "root", "", "liga");

    // si no se puede conectar a la base de datos, tira la excepcion
} catch (mysqli_sql_exception $e) {
    // si no se puede conectar a la base de datos, muestra un mensaje de error y termina la ejecucion del script
    die("No se pudo conectar con la base de datos. Intente más tarde.");
}