<?php
session_start();
include '../includes/conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// 1. Obtener dirección
$sqlDireccion = "SELECT calle, colonia, codigo_postal, ciudad, estado, pais FROM direccion_envio WHERE id_usuario = ?";
$stmtDireccion = $conn->prepare($sqlDireccion);
$stmtDireccion->bind_param("i", $id_usuario);
$stmtDireccion->execute();
$resultDireccion = $stmtDireccion->get_result();
$direccion = $resultDireccion->fetch_assoc();

// 2. Obtener medio de pago
$sqlPago = "SELECT titular, numero, expiracion, cvv FROM medios_pago WHERE usuario_id = ?";
$stmtPago = $conn->prepare($sqlPago);
$stmtPago->bind_param("i", $id_usuario);
$stmtPago->execute();
$resultPago = $stmtPago->get_result();
$pago = $resultPago->fetch_assoc();

// 3. Devolver respuesta combinada
echo json_encode([
    'direccion' => $direccion ?: null,
    'pago' => $pago ?: null
]);
