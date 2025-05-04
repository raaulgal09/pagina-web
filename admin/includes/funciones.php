<?php
function obtenerProductos($conexion) {
    $sql = "SELECT * FROM productos";
    return mysqli_query($conexion, $sql);
}

function obtenerPedidos($conexion) {
    $sql = "SELECT * FROM pedidos";
    return mysqli_query($conexion, $sql);
}

function obtenerUsuarios($conexion) {
    $sql = "SELECT * FROM usuarios";
    return mysqli_query($conexion, $sql);
}
?>
