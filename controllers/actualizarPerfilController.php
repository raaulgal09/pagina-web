<?php
session_start();
include '../includes/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo "No autorizado";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Recibir datos del formulario
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$correo = $_POST['correo'] ?? '';
$password = $_POST['password'] ?? '';

// Validar correo básico (opcionalmente puedes agregar más reglas)
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Correo inválido";
    exit;
}

// Construir consulta SQL dinámica
if (!empty($password)) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $apellidos, $correo, $passwordHash, $id_usuario);
} else {
    $sql = "UPDATE usuarios SET nombre = ?, apellidos = ?, correo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $apellidos, $correo, $id_usuario);
}

// Ejecutar y responder
if ($stmt->execute()) {
    echo "Datos actualizados correctamente.";
} else {
    echo "Error al actualizar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
