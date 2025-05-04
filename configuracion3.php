<?php
session_start();
$nombreUsuario = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medio de Pago</title>
    <link rel="stylesheet" href="settings.css">
</head>
<body>
    <header>
        <h1>FigurArts</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="favoritos.php">Favoritos</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <?php if ($nombreUsuario): ?>
                    <li><span style="color: white;">Bienvenido, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></span></li>
                    <li><a href="inicio.php">Mi cuenta</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php">Ingresar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <a href="inicio.php" class="btn volver-btn">⬅ Volver a Perfil</a>

    <section class="settings-container">
        <div class="settings-box">
            <h2>Configuración de Medio de Pago</h2>
            <form id="medio-pago-form">
                <label for="titular">Titular de la Tarjeta</label>
                <input type="text" id="titular" name="titular" required>

                <label for="numero">Número de Tarjeta</label>
                <input type="text" id="numero" name="numero" maxlength="16" required>

                <label for="expiracion">Fecha de Expiración (MM/AA)</label>
                <input type="text" id="expiracion" name="expiracion" maxlength="5" required>

                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" maxlength="4" required>

                <button type="submit">Guardar Medio de Pago</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
    </footer>

    <script>
        function cargarMedioPago() {
            fetch('controllers/obtenerPagoController.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('titular').value = data.titular || '';
                    document.getElementById('numero').value = data.numero || '';
                    document.getElementById('expiracion').value = data.expiracion || '';
                    document.getElementById('cvv').value = data.cvv || '';
                })
                .catch(error => console.error('Error al cargar datos de pago:', error));
        }

        document.addEventListener('DOMContentLoaded', cargarMedioPago);

        document.getElementById('medio-pago-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('controllers/guardarPagoController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Error al guardar medio de pago:', error));
        });
    </script>
</body>
</html>
