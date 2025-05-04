<?php
include 'includes/conexion.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

$categorias_actuales = explode(',', $producto['categoria']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../logo.png" alt="FigurArts">
        <h1>Panel de Administración</h1>
    </div>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="listaProductos.php">Lista de Productos</a></li>
            <li><a href="../logout.php">Volver a la tienda</a></li>
        </ul>
    </nav>
</header>

<main class="contenido-admin">
    <h2>Editar Producto</h2>
    <a href="dashboard.php" class="btn volver-btn">⬅ Volver al Dashboard</a>

<?php
if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $edicion = $_POST['edicion'];
    $disponibilidad = $_POST['disponibilidad'];

    // ✅ Categorías siempre con 'catalogo'
    $categorias_seleccionadas = $_POST['categorias'] ?? [];
    if (!in_array('catalogo', $categorias_seleccionadas)) {
        $categorias_seleccionadas[] = 'catalogo';
    }
    $categorias_str = implode(',', $categorias_seleccionadas);

    $sql = "UPDATE productos SET 
        nombre = ?, 
        descripcion = ?, 
        precio = ?, 
        stock = ?, 
        categoria = ?, 
        edicion = ?, 
        disponibilidad = ?
        WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "ssdisssi",
        $nombre,
        $descripcion,
        $precio,
        $stock,
        $categorias_str,
        $edicion,
        $disponibilidad,
        $id
    );

    if ($stmt->execute()) {
        // 🔁 Eliminar imágenes anteriores
        $sqlImgs = "SELECT nombre_imagen FROM imagenes_producto WHERE producto_id = ?";
        $stmtImgs = $conexion->prepare($sqlImgs);
        $stmtImgs->bind_param("i", $id);
        $stmtImgs->execute();
        $resImgs = $stmtImgs->get_result();
        while ($img = $resImgs->fetch_assoc()) {
            $file = 'uploads/' . $img['nombre_imagen'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
        $stmtImgs->close();

        $stmtDel = $conexion->prepare("DELETE FROM imagenes_producto WHERE producto_id = ?");
if ($stmtDel) {
    $stmtDel->bind_param("i", $id);
    $stmtDel->execute();
    $stmtDel->close();
} else {
    echo "<p class='error'>❌ Error al preparar la eliminación de imágenes: " . $conexion->error . "</p>";
}


        // ✅ Subir nuevas imágenes si hay
        if (!empty($_FILES['imagenes']['name'][0])) {
            $directorio = 'uploads/';
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                $nombreArchivo = basename($_FILES['imagenes']['name'][$key]);
                $rutaArchivo = $directorio . $nombreArchivo;

                $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
                if (in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'webp'])) {
                    if (move_uploaded_file($tmp_name, $rutaArchivo)) {
                        $sqlImg = "INSERT INTO imagenes_producto (producto_id, nombre_imagen) VALUES (?, ?)";
                        $stmtImg = $conexion->prepare($sqlImg);
                        $stmtImg->bind_param("is", $id, $nombreArchivo);
                        $stmtImg->execute();
                        $stmtImg->close();
                    } else {
                        echo "❌ Error al subir: $nombreArchivo<br>";
                    }
                } else {
                    echo "❌ Formato no permitido: $nombreArchivo<br>";
                }
            }
        }

        echo "<p class='success'>✅ Producto actualizado correctamente.</p>";
    } else {
        echo "<p class='error'>❌ Error al actualizar: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<form class="formulario-admin" action="" method="POST" enctype="multipart/form-data">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>

    <label>Descripción:</label>
    <textarea name="descripcion" rows="4"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>

    <label>Precio:</label>
    <input type="number" name="precio" step="0.01" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>

    <label>Stock:</label>
    <input type="number" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>

    <label>Edición:</label>
    <input type="text" name="edicion" value="<?php echo htmlspecialchars($producto['edicion']); ?>" required>

    <label>Categorías:</label>
    <div class="categorias-group">
        <input type="hidden" name="categorias[]" value="catalogo">
        <label><input type="checkbox" value="catalogo" checked disabled> Catálogo (siempre)</label>
        <label><input type="checkbox" name="categorias[]" value="novedades" <?php if (in_array('novedades', $categorias_actuales)) echo 'checked'; ?>> Novedades</label>
        <label><input type="checkbox" name="categorias[]" value="descuentos" <?php if (in_array('descuentos', $categorias_actuales)) echo 'checked'; ?>> Descuentos</label>
    </div>

    <label>Disponibilidad:</label>
    <select name="disponibilidad">
        <option value="En stock" <?php if ($producto['disponibilidad'] == 'En stock') echo 'selected'; ?>>En stock</option>
        <option value="Preventa" <?php if ($producto['disponibilidad'] == 'Preventa') echo 'selected'; ?>>Preventa</option>
        <option value="Agotado" <?php if ($producto['disponibilidad'] == 'Agotado') echo 'selected'; ?>>Agotado</option>
    </select>

    <label>Subir nuevas imágenes (se reemplazan):</label>
    <input type="file" name="imagenes[]" multiple accept="image/*">

    <button class="btn" type="submit" name="actualizar">Actualizar Producto</button>
</form>
</main>

<footer>
    <p>&copy; 2025 FigurArts - Panel de Administración</p>
</footer>
</body>
</html>
