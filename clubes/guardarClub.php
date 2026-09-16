<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombreClub = $_POST["nombreClub"];

    if (!empty($_POST["id"])) {
        $id = $_POST["id"];
        $sql = "UPDATE club SET nombre = '$nombreClub' WHERE id = $id";
        mysqli_query($conn, $sql);
    } else {
        $sql = "INSERT INTO club (nombre) VALUES ('$nombreClub')";
        mysqli_query($conn, $sql);
    }

    header("Location: gestionClubes.php");
    exit();
}