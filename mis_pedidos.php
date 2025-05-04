<?php
session_start();
$nombreUsuario = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Conexión directa
$host = 'localhost';
$db = 'figurarts';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexión fallida: " . $conn->connect_error);

$id_usuario = $_SESSION['usuario_id'];

$sql = "SELECT 
            p.id AS pedido_id,
            p.fecha_pedido,
            p.total,
            p.estado,
            dp.id_producto,
            pr.nombre AS nombre_producto,
            pr.descripcion,
            (SELECT nombre_imagen FROM imagenes_producto WHERE producto_id = pr.id LIMIT 1) AS imagen,
            dp.cantidad,
            dp.subtotal
        FROM pedidos p
        JOIN detalle_pedido dp ON p.id = dp.id_pedido
        JOIN productos pr ON dp.id_producto = pr.id
        WHERE p.id_usuario = ?
        ORDER BY p.fecha_pedido DESC";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mis Pedidos</title>
    <link rel="stylesheet" href="cart.css" />
</head>
<body>
<header>
    <div class="logo">
        <img src="logo.png" alt="FigurArts" />
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="favoritos.php">Favoritos</a></li>
            <li><a href="catalogo.php">Catálogo</a></li>
            <li><a href="carrito.php"><img src="cart-icon.png" alt="" />Carrito</a></li>
            <?php if ($nombreUsuario): ?>
                <li><span style="color: white;">Bienvenido, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></span></li>
                <li><a href="inicio.php">Mi cuenta</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="login.php"><img src="" alt="" />Ingresar</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<a href="inicio.php" class="btn volver-btn">⬅ Volver a Perfil</a>

<section id="carrito">

    
    <h2>Mis Pedidos</h2>

    <?php
    if (empty($pedidos)) {
        echo "<p style='text-align:center;'>No tienes pedidos aún.</p>";
    } else {
        $pedido_actual = 0;
        $total_pedido = 0;

        foreach ($pedidos as $row) {
            if ($pedido_actual != $row['pedido_id']) {
                if ($pedido_actual != 0) {
                    echo "</tbody></table>";
                    echo "<p class='pedido-total'>Total del pedido: $" . number_format($total_pedido, 2) . "</p><br>";
                    $total_pedido = 0;
                }

                echo "<h3>Pedido #{$row['pedido_id']} | Fecha: {$row['fecha_pedido']} | Estado: {$row['estado']}</h3>";
                echo "<table><thead>
                        <tr><th>Producto</th><th>Cantidad</th><th>Subtotal</th></tr>
                      </thead><tbody>";

                $pedido_actual = $row['pedido_id'];
            }

            $nombreImagen = $row['imagen'];
            $rutaWeb = (!empty($nombreImagen)) ? "admin/uploads/" . $nombreImagen : "img/default.png";

            $descripcion = substr($row['descripcion'], 0, 100) . '...';
            $total_pedido += $row['subtotal'];

            echo "<tr>
                    <td>
                        <div class='producto-info'>
                            <img src='{$rutaWeb}' alt='{$row['nombre_producto']}' style='width: 50px; height: 75px; object-fit: contain; border-radius: 6px; background: #f4f4f4; padding: 3px; box-shadow: 0 0 3px rgba(0,0,0,0.1);'>

                            <div class='info'>
                                <strong>{$row['nombre_producto']}</strong><br>
                                <small>{$descripcion}</small>
                            </div>
                        </div>
                    </td>
                    <td>{$row['cantidad']}</td>
                    <td>$" . number_format($row['subtotal'], 2) . "</td>
                </tr>";

            

        }

        echo "</tbody></table>";
        echo "<p class='pedido-total'>Total del pedido: $" . number_format($total_pedido, 2) . "</p>";
    }
    ?>
</section>

<footer>
    <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
</footer>
</body>
</html>
