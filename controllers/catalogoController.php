<?php
session_start();
include '../includes/conexion.php';

header('Content-Type: application/json');

$tipo = $_GET['tipo'] ?? 'catalogo';
$id = $_GET['id'] ?? null;

try {
    // ✅ BLOQUE DE BÚSQUEDA POR NOMBRE
    if (isset($_GET['busqueda'])) {
        $busqueda = '%' . $_GET['busqueda'] . '%';

        $sql = "SELECT 
                    p.id, 
                    p.nombre, 
                    p.precio, 
                    GROUP_CONCAT(i.nombre_imagen) AS imagenes 
                FROM productos p
                LEFT JOIN imagenes_producto i ON p.id = i.producto_id
                WHERE p.nombre LIKE ?
                GROUP BY p.id";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $busqueda);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $row['imagenes'] = $row['imagenes'] ? explode(',', $row['imagenes']) : [];
            $productos[] = $row;
        }

        echo json_encode($productos);
        $conn->close();
        exit;
    }

    // ✅ CONSULTA POR ID
    if ($id) {
        $sql = "SELECT 
                    p.id, 
                    p.nombre, 
                    p.precio, 
                    p.descripcion,
                    p.categoria,
                    p.edicion,
                    p.disponibilidad,
                    p.stock,
                    GROUP_CONCAT(i.nombre_imagen) AS imagenes 
                FROM productos p
                LEFT JOIN imagenes_producto i ON p.id = i.producto_id
                WHERE p.id = ?
                GROUP BY p.id";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $producto = $result->fetch_assoc();
            $producto['imagenes'] = $producto['imagenes'] ? explode(',', $producto['imagenes']) : [];
            echo json_encode($producto);
        } else {
            echo json_encode(['error' => 'Producto no encontrado']);
        }
    } else {
        // ✅ CONSULTA POR CATEGORÍA (tipo)
        $sql = "SELECT 
                    p.id, 
                    p.nombre, 
                    p.precio, 
                    GROUP_CONCAT(i.nombre_imagen) AS imagenes 
                FROM productos p
                LEFT JOIN imagenes_producto i ON p.id = i.producto_id
                WHERE FIND_IN_SET(?, p.categoria)
                GROUP BY p.id";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $tipo);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $row['imagenes'] = $row['imagenes'] ? explode(',', $row['imagenes']) : [];
            $productos[] = $row;
        }

        echo json_encode($productos);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en el servidor: ' . $e->getMessage()]);
}

$conn->close();
?>
