<?php include 'includes/conexion.php'; include 'includes/funciones.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Admin FigurArts</title>
    <link rel="stylesheet" href="admin.css"> <!-- asegúrate de tener este archivo -->
</head>
<body>

    <header>
        <div class="logo">
            <img src="../logo.png" alt="FigurArts">
            <h1>Panel de Administración</h1>
        </div>
        <nav>
            <ul>
                <li><a href="agregarProducto.php">Agregar Producto</a></li>
                <li><a href="listaProductos.php">Lista de Productos</a></li>
                <li><a href="listaPedidos.php">Lista de Pedidos</a></li>
                <li><a href="listaUsuarios.php">Lista de Usuarios</a></li>
                <li><a href="../logout.php">Volver a la tienda</a></li>
            </ul>
        </nav>
    </header>

    <main class="contenido-admin">
        <section class="bienvenida">
            <h2>Bienvenido, Administrador</h2>
            <p>Desde este panel puedes gestionar productos, pedidos y usuarios registrados.</p>
        </section>

        <section class="acciones-rapidas">
            <div class="botones-container">
                <a class="btn" href="agregarProducto.php">➕ Agregar Producto</a>
                <a class="btn" href="listaProductos.php">📦 Ver Productos</a>
                <a class="btn" href="listaPedidos.php">📋 Ver Pedidos</a>
                <a class="btn" href="listaUsuarios.php">👤 Ver Usuarios</a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 FigurArts - Panel de Administración</p>
    </footer>

</body>
</html>
