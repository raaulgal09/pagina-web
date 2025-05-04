<?php
session_start();
include '../includes/conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// 1. Obtener productos del carrito
$sql = "SELECT c.id_producto, c.cantidad, p.precio 
        FROM carrito c
        JOIN productos p ON c.id_producto = p.id
        WHERE c.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Tu carrito está vacío.']);
    exit;
}

// 2. Calcular total
$productos = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $subtotal = $row['precio'] * $row['cantidad'];
    $productos[] = [
        'id_producto' => $row['id_producto'],
        'cantidad' => $row['cantidad'],
        'subtotal' => $subtotal
    ];
    $total += $subtotal;
}

$costo_envio = $total > 800 ? 0 : 350;
$total_final = $total + $costo_envio;

// 3. Insertar pedido
$sql_pedido = "INSERT INTO pedidos (id_usuario, fecha_pedido, total, estado) VALUES (?, NOW(), ?, 'Pendiente')";
$stmt_pedido = $conn->prepare($sql_pedido);
$stmt_pedido->bind_param("id", $id_usuario, $total_final);
$stmt_pedido->execute();
$id_pedido = $stmt_pedido->insert_id;

// 4. Insertar detalles del pedido
$sql_detalle = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, subtotal) VALUES (?, ?, ?, ?)";
$stmt_detalle = $conn->prepare($sql_detalle);

foreach ($productos as $producto) {
    $stmt_detalle->bind_param("iiid", $id_pedido, $producto['id_producto'], $producto['cantidad'], $producto['subtotal']);
    $stmt_detalle->execute();
}

// 5. Vaciar el carrito
$sql_vaciar = "DELETE FROM carrito WHERE id_usuario = ?";
$stmt_vaciar = $conn->prepare($sql_vaciar);
$stmt_vaciar->bind_param("i", $id_usuario);
$stmt_vaciar->execute();

// 6. Respuesta final
echo json_encode([
    'success' => true,
    'mensaje' => 'Compra realizada con éxito',
    'id_pedido' => $id_pedido
]);
