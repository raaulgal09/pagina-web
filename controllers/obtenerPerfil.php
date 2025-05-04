<?php
session_start();
include '../includes/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// OPCIONAL para debug (puedes eliminar después)
file_put_contents('debug_id.txt', "ID: " . $id_usuario);

$sql = "SELECT nombre, apellidos, correo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $datos = $result->fetch_assoc();
    echo json_encode($datos, JSON_UNESCAPED_UNICODE); // ✅ muestra acentos correctamente
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Usuario no encontrado']);
}

$stmt->close();
$conn->close();
?>
