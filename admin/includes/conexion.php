<?php
$conexion = mysqli_connect("localhost", "root", "", "figurarts");

if (!$conexion) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>