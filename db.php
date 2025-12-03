<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "chialva_portfolio"; // Nombre de tu DB en phpMyAdmin

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>