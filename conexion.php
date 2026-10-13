<?php

$conn = mysqli_connect("localhost", "root", "", "liga");

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}