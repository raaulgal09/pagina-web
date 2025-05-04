<?php include 'includes/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
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
        <h2>Agregar Nuevo Producto</h2>
        <a href="dashboard.php" class="btn volver-btn">⬅ Volver al Dashboard</a>

        <form class="formulario-admin" action="agregarProducto.php" method="POST" enctype="multipart/form-data">
            <label>Nombre del producto:</label>
            <input type="text" name="nombre" required>

            <label>Descripción del producto:</label>
            <textarea name="descripcion" rows="4" required></textarea>

            <label>Precio:</label>
            <input type="number" name="precio" step="0.01" required>

            <label>Stock:</label>
            <input type="number" name="stock" required>

            <label>Categorías:</label>
            <div class="categorias-group">
                <!-- Siempre se envía -->
                <input type="hidden" name="categorias[]" value="catalogo">
                <label><input type="checkbox" value="catalogo" checked disabled> Catálogo (siempre)</label>
                <label><input type="checkbox" name="categorias[]" value="novedades"> Novedades</label>
                <label><input type="checkbox" name="categorias[]" value="descuentos"> Descuentos</label>
            </div>


            <label>Edición:</label>
            <input type="text" name="edicion" required>

            <label>Disponibilidad:</label>
            <select name="disponibilidad" required>
                <option value="En stock">En stock</option>
                <option value="Preventa">Preventa</option>
                <option value="Agotado">Agotado</option>
            </select>

            <label>Imágenes del producto:</label>
            <input type="file" name="imagenes[]" multiple required>

            <button class="btn" type="submit" name="agregar_producto">Agregar Producto</button>
        </form>

<?php
if (isset($_POST['agregar_producto'])) {
    include 'includes/conexion.php';

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $edicion = $_POST['edicion'];
    $disponibilidad = $_POST['disponibilidad'];


    // Procesar categorías
    $categoriasSeleccionadas = $_POST['categorias'] ?? [];
    if (!in_array('catalogo', $categoriasSeleccionadas)) {
        $categoriasSeleccionadas[] = 'catalogo';
    }
    $categoriasStr = implode(',', $categoriasSeleccionadas);

    // Insertar producto
    $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria, edicion, disponibilidad) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssisss", $nombre, $descripcion, $precio, $stock, $categoriasStr, $edicion, $disponibilidad);

    if ($stmt->execute()) {
        $productoId = $stmt->insert_id;

        // Crear carpeta si no existe
        $directorio = 'uploads/';
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Subir imágenes
        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            $nombreArchivo = basename($_FILES['imagenes']['name'][$key]);
            $rutaArchivo = $directorio . $nombreArchivo;

            $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
            if (in_array($tipoArchivo, ['jpg', 'jpeg', 'png', 'webp'])) {
                if (move_uploaded_file($tmp_name, $rutaArchivo)) {
                    $sqlImg = "INSERT INTO imagenes_producto (producto_id, nombre_imagen) VALUES (?, ?)";
                    $stmtImg = $conexion->prepare($sqlImg);
                    $stmtImg->bind_param("is", $productoId, $nombreArchivo);
                    $stmtImg->execute();
                    $stmtImg->close();
                } else {
                    echo "❌ Error al subir la imagen: $nombreArchivo <br>";
                }
            } else {
                echo "❌ Formato no permitido: $nombreArchivo <br>";
            }
        }

        echo "<p class='success'>✅ Producto agregado correctamente.</p>";
    } else {
        echo "<p class='error'>❌ Error al agregar el producto: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conexion->close();
}
?>
</main>
</body>
</html>
 