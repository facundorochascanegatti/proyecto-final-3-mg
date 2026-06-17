<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

$año = $_POST["año"];

$sql = "INSERT INTO categorias (año)
        VALUES ('$año')";

mysqli_query($conn, $sql);

echo "Categoría guardada correctamente";
?>