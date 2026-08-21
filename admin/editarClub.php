<?php

$conn = mysqli_connect("localhost", "root", "", "liga");

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $sql = "SELECT * FROM club WHERE id = $id";

    $resultado = mysqli_query($conn, $sql);

    $club = mysqli_fetch_assoc($resultado);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $nombreClub = $_POST["nombreClub"];

    $sql = "UPDATE club SET clubes='$nombreClub' WHERE id=$id";

    mysqli_query($conn, $sql);

    header("Location: gestionClubes.php");
    exit();
}

?>
