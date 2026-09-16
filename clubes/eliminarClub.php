<?php
$conn = mysqli_connect("localhost", "root", "", "liga");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "DELETE FROM club WHERE id = $id";
    mysqli_query($conn, $sql);
}

header("Location: gestionClubes.php");
exit();
