<?php
include 'includes/conexion.php';

$id = intval($_GET['id']);

// Paso 1: Eliminar imágenes relacionadas
$sqlImg = "DELETE FROM imagenes_producto WHERE producto_id = ?";
$stmtImg = $conexion->prepare($sqlImg);
$stmtImg->bind_param("i", $id);
$stmtImg->execute();
$stmtImg->close();

// Paso 2: Eliminar producto
$sql = "DELETE FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "✅ Producto eliminado correctamente.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();

// Redireccionar
header("Location: listaProductos.php");
exit;
?>
