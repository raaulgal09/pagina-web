<?php
session_start();
include '../includes/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "No autorizado";
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql_carrito = "SELECT c.*, p.precio FROM carrito c JOIN productos p ON c.id_producto = p.id WHERE c.id_usuario = $id_usuario";
    $result = $conn->query($sql_carrito);

    $total = 0;
    $productos = [];

    while ($row = $result->fetch_assoc()) {
        $subtotal = $row['precio'] * $row['cantidad'];
        $total += $subtotal;
        $productos[] = [
            'id_producto' => $row['id_producto'],
            'cantidad' => $row['cantidad'],
            'subtotal' => $subtotal
        ];
    }

    // Crear pedido
    $sql_pedido = "INSERT INTO pedidos (id_usuario, total) VALUES ($id_usuario, $total)";
    if ($conn->query($sql_pedido)) {
        $id_pedido = $conn->insert_id;

        foreach ($productos as $prod) {
            $sql_detalle = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, subtotal)
                            VALUES ($id_pedido, {$prod['id_producto']}, {$prod['cantidad']}, {$prod['subtotal']})";
            $conn->query($sql_detalle);
        }

        $conn->query("DELETE FROM carrito WHERE id_usuario = $id_usuario");

        echo "Pedido realizado con éxito. Número de pedido: #$id_pedido";
    } else {
        echo "Error al generar el pedido";
    }
}

$conn->close();
?>