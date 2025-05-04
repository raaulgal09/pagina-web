<?php include 'includes/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pedidos</title>
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
                <li><a href="listaProductos.php">Productos</a></li>
                <li><a href="../logout.php">Volver a la tienda</a></li>
            </ul>
        </nav>
    </header>

    <main class="contenido-admin">
        <h2>Pedidos Realizados</h2>
        <a href="dashboard.php" class="btn volver-btn">⬅ Volver al Dashboard</a>

        <div class="tabla-contenedor">
            <table class="tabla-admin">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente (ID)</th>
                        <th>Estado</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pedidos = mysqli_query($conexion, "SELECT * FROM pedidos");
                    while ($pedido = mysqli_fetch_assoc($pedidos)) {
                        echo "<tr>";
                        echo "<td>" . $pedido['id'] . "</td>";
                        echo "<td>" . $pedido['id_usuario'] . "</td>";
                        echo "<td>" . $pedido['estado'] . "</td>";
                        echo "<td>$" . $pedido['total'] . "</td>";
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
