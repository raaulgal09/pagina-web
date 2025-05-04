<?php
session_start();
include '../includes/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'No autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = intval($_POST['producto_id']);
    $accion = $_POST['accion'];

    if ($accion === 'agregar') {
        $stmt = $conn->prepare("INSERT IGNORE INTO favoritos (usuario_id, producto_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $usuario_id, $producto_id);
        $stmt->execute();
        echo json_encode(['success' => 'Agregado a favoritos']);
    } elseif ($accion === 'eliminar') {
        $stmt = $conn->prepare("DELETE FROM favoritos WHERE usuario_id = ? AND producto_id = ?");
        $stmt->bind_param("ii", $usuario_id, $producto_id);
        $stmt->execute();
        echo json_encode(['success' => 'Eliminado de favoritos']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT producto_id FROM favoritos WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $favoritos = [];
    while ($row = $result->fetch_assoc()) {
        $favoritos[] = $row['producto_id'];
    }

    echo json_encode($favoritos);
}
?>
