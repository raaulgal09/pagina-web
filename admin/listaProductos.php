<?php include 'includes/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="admin.css">
    <style>
       .tabla-admin img {
        width: 80px;
        height: 80px;
        object-fit: contain; /* ⬅ Asegura que no se recorten */
        border-radius: 8px;
        background: #f4f4f4;
        box-shadow: 0 0 4px rgba(0,0,0,0.1);
        padding: 3px;
    }

    .td img {
    display: block;
    margin: 0 auto;
}

    </style>
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
            <li><a href="agregarProducto.php">Agregar Producto</a></li>
            <li><a href="../logout.php">Volver a la tienda</a></li>
        </ul>
    </nav>
</header>

<main class="contenido-admin">
    <h2>Productos Existentes</h2>

    <a href="dashboard.php" class="btn volver-btn">⬅ Volver al Dashboard</a>
    <a class="btn agregar-btn" href="agregarProducto.php">➕ Agregar Nuevo Producto</a>

    <div class="tabla-contenedor">
        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Disponibilidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Consulta con subconsulta para obtener la primera imagen del producto
            $query = "SELECT p.*, 
                        (SELECT nombre_imagen FROM imagenes_producto WHERE producto_id = p.id LIMIT 1) AS imagen
                      FROM productos p";
            $productos = mysqli_query($conexion, $query);

            while ($producto = mysqli_fetch_assoc($productos)) {
                $nombreImagen = $producto['imagen'];
                $rutaWeb = (!empty($nombreImagen)) ? "./uploads/" . $nombreImagen : "../admin/imagenes/no-imagen.png";

                echo "<tr>";
                echo "<td><img src='" . $rutaWeb . "' alt='Imagen de " . htmlspecialchars($producto['nombre']) . "'></td>";
                echo "<td>" . htmlspecialchars($producto['nombre']) . "</td>";
                echo "<td>$" . htmlspecialchars($producto['precio']) . "</td>";
                echo "<td>" . htmlspecialchars($producto['stock']) . "</td>";
                echo "<td>" . htmlspecialchars($producto['categoria']) . "</td>";
                echo "<td>" . htmlspecialchars($producto['disponibilidad']) . "</td>";
                echo "<td>
                        <a class='accion-link' href='editarProducto.php?id=" . $producto['id'] . "'>Editar</a> | 
                        <a class='accion-link eliminar' href='eliminarProducto.php?id=" . $producto['id'] . "' onclick=\"return confirm('¿Seguro que deseas eliminar este producto?');\">Eliminar</a>
                      </td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</main>

<footer>
    <p>&copy; 2025 FigurArts - Panel de Administración</p>
</footer>
</body>
</html>
