<?php
session_start();
include '../includes/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo "No autorizado";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$titular = $_POST['titular'] ?? '';
$numero = $_POST['numero'] ?? '';
$expiracion = $_POST['expiracion'] ?? '';
$cvv = $_POST['cvv'] ?? '';

// Verifica si ya tiene medio registrado
$check = $conn->prepare("SELECT id FROM medios_pago WHERE usuario_id = ?");
$check->bind_param("i", $id_usuario);
$check->execute();
$checkResult = $check->get_result();

if ($checkResult->num_rows > 0) {
    // Update
    $stmt = $conn->prepare("UPDATE medios_pago SET titular = ?, numero = ?, expiracion = ?, cvv = ? WHERE usuario_id = ?");
    $stmt->bind_param("ssssi", $titular, $numero, $expiracion, $cvv, $id_usuario);
} else {
    // Insert
    $stmt = $conn->prepare("INSERT INTO medios_pago (titular, numero, expiracion, cvv, usuario_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $titular, $numero, $expiracion, $cvv, $id_usuario);
}

if ($stmt->execute()) {
    echo "Medio de pago guardado correctamente.";
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
