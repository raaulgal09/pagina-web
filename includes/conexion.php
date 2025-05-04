<?php
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "figurarts";

$conn = new mysqli($host, $usuario, $password, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
