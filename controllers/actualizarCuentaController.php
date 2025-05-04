<?php
session_start();
include '../includes/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo "No autorizado";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Captura de datos del formulario
$calle = $_POST['calle'] ?? '';
$colonia = $_POST['colonia'] ?? '';
$codigo_postal = $_POST['codigo-postal'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$estado = $_POST['estado'] ?? '';
$pais = $_POST['pais'] ?? '';

// Validación rápida
if (empty($calle) || empty($colonia) || empty($codigo_postal) || empty($ciudad) || empty($estado) || empty($pais)) {
    http_response_code(400);
    echo "Todos los campos son obligatorios.";
    exit;
}

// Revisar si ya existe una dirección para ese usuario
$sql_check = "SELECT id FROM direccion_envio WHERE id_usuario = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $id_usuario);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Ya existe: hacer UPDATE
    $sql_update = "UPDATE direccion_envio SET calle = ?, colonia = ?, codigo_postal = ?, ciudad = ?, estado = ?, pais = ? WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssssi", $calle, $colonia, $codigo_postal, $ciudad, $estado, $pais, $id_usuario);
} else {
    // No existe: hacer INSERT
    $sql_insert = "INSERT INTO direccion_envio (calle, colonia, codigo_postal, ciudad, estado, pais, id_usuario) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssssssi", $calle, $colonia, $codigo_postal, $ciudad, $estado, $pais, $id_usuario);
}

if ($stmt->execute()) {
    echo "Dirección guardada correctamente.";
} else {
    http_response_code(500);
    echo "Error al guardar dirección: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
