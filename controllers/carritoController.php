<?php
session_start();
include '../includes/conexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

$id_usuario = $_SESSION['usuario_id'];

// ✅ 1. Obtener productos del carrito
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $sql = "SELECT 
                    c.id_producto, 
                    c.cantidad, 
                    p.nombre, 
                    p.precio, 
                    (SELECT nombre_imagen FROM imagenes_producto WHERE producto_id = p.id LIMIT 1) AS imagen
                FROM carrito c
                JOIN productos p ON c.id_producto = p.id
                WHERE c.id_usuario = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        $carrito = [];
        while ($row = $result->fetch_assoc()) {
            $row['subtotal'] = $row['precio'] * $row['cantidad'];
            $carrito[] = $row;
        }

        echo json_encode($carrito);
        exit;

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener el carrito', 'detalle' => $e->getMessage()]);
        exit;
    }
}

// ✅ 2. Acciones por POST: vaciar, actualizar, agregar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    // 🧹 Vaciar carrito
    if ($accion === 'vaciar') {
        try {
            $sql = "DELETE FROM carrito WHERE id_usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();

            echo json_encode(['success' => 'Carrito vaciado']);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al vaciar carrito', 'detalle' => $e->getMessage()]);
            exit;
        }
    }

    // 🔁 Actualizar cantidad
    if ($accion === 'actualizar') {
        $id_producto = $_POST['id_producto'] ?? null;
        $cantidad = $_POST['cantidad'] ?? 1;

        if (!$id_producto || $cantidad < 1) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos inválidos']);
            exit;
        }

        try {
            $sql_update = "UPDATE carrito SET cantidad = ? WHERE id_usuario = ? AND id_producto = ?";
            $stmt = $conn->prepare($sql_update);
            $stmt->bind_param("iii", $cantidad, $id_usuario, $id_producto);
            $stmt->execute();

            echo json_encode(['success' => 'Cantidad actualizada']);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar cantidad', 'detalle' => $e->getMessage()]);
            exit;
        }
    }

    // ➕ Agregar producto
    $id_producto = $_POST['id_producto'] ?? null;
    $cantidad = $_POST['cantidad'] ?? 1;

    if (!$id_producto) {
        http_response_code(400);
        echo json_encode(['error' => 'Producto no especificado']);
        exit;
    }

    try {
        $sql_check = "SELECT * FROM carrito WHERE id_usuario = ? AND id_producto = ?";
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param("ii", $id_usuario, $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sql_update = "UPDATE carrito SET cantidad = cantidad + ? WHERE id_usuario = ? AND id_producto = ?";
            $stmt = $conn->prepare($sql_update);
            $stmt->bind_param("iii", $cantidad, $id_usuario, $id_producto);
        } else {
            $sql_insert = "INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("iii", $id_usuario, $id_producto, $cantidad);
        }

        $stmt->execute();
        echo json_encode(['success' => 'Producto añadido al carrito']);
        exit;

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al añadir producto', 'detalle' => $e->getMessage()]);
        exit;
    }
}

// ❌ 3. Eliminar producto individual
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $id_producto = $_DELETE['id_producto'] ?? null;

    if (!$id_producto) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de producto requerido']);
        exit;
    }

    try {
        $sql_delete = "DELETE FROM carrito WHERE id_usuario = ? AND id_producto = ?";
        $stmt = $conn->prepare($sql_delete);
        $stmt->bind_param("ii", $id_usuario, $id_producto);
        $stmt->execute();

        echo json_encode(['success' => 'Producto eliminado del carrito']);
        exit;

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar producto', 'detalle' => $e->getMessage()]);
        exit;
    }
}

$conn->close();
