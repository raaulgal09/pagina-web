<?php
session_start();
$nombreUsuario = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
?>
<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Cuenta</title>
    <link rel="stylesheet" href="settings.css">
</head>
<body>
    <header>
        <h1>FigurArts</h1>
        <nav>
            <ul>
                <li><a href="inicio.html">Inicio</a></li>
                <li><a href="catalogo.html">Catálogo</a></li>
                <li><a href="carrito.html">Carrito</a></li>
                <li><a href="index.html">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>

    <section class="settings-container">
        <div class="settings-box">
            <h2>Configuración de Cuenta</h2>
            <form action="#" method="POST">
                <h3>Datos Personales</h3>
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
                
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" required>
                
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" disabled>
                
                <label for="password">Nueva Contraseña</label>
                <input type="password" id="password" name="password">
                
                <label for="confirm-password">Confirmar Contraseña</label>
                <input type="password" id="confirm-password" name="confirm-password">
                
                <h3>Dirección de Envío</h3>
                <label for="calle">Calle y Número</label>
                <input type="text" id="calle" name="calle" required>
                
                <label for="colonia">Colonia</label>
                <input type="text" id="colonia" name="colonia" required>
                
                <label for="codigo-postal">Código Postal</label>
                <input type="text" id="codigo-postal" name="codigo-postal" required>
                
                <label for="ciudad">Ciudad</label>
                <input type="text" id="ciudad" name="ciudad" required>
                
                <label for="estado">Estado/Provincia/Región</label>
                <input type="text" id="estado" name="estado" required>
                
                <label for="pais">País</label>
                <input type="text" id="pais" name="pais" required>
                
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
    </footer>
</body>
</html> -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Cuenta</title>
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
                    <li><a href="login.php"><img src="" alt="" />Ingresar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <a href="inicio.php" class="btn volver-btn">⬅ Volver a Perfil</a>

    <section class="settings-container">
        
        
        <div class="settings-box">
            <h2>Configuración de Cuenta</h2>
            <form id="configuracion-form">
                <h3>Datos Personales</h3>

                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
                
                <label for="apellidos">Apellidos</label>
                <input type="text" id="apellidos" name="apellidos" required>
                
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="correo" readonly>
                
                <label for="password">Nueva Contraseña</label>
                <input type="password" id="password" name="password" >
                
                <label for="confirm-password">Confirmar Contraseña</label>
                <input type="password" id="confirm-password" name="confirm-password">
                
                
                
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
    </footer>

    <script>
        // Función para cargar los datos del usuario (cuando tengas tu API / controlador)
        function cargarDatosUsuario() {
            fetch('controllers/obtenerPerfil.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apellidos').value = data.apellidos;
                    document.getElementById('email').value = data.correo;
                    
                })
                .catch(error => console.error('Error al cargar datos:', error));
        }

        // Llama la función cuando se carga la página
        document.addEventListener('DOMContentLoaded', cargarDatosUsuario);

        // Guardar cambios
        document.getElementById('configuracion-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            if (password !== confirmPassword) {
                alert('Las contraseñas no coinciden.');
                return;
            }

            const formData = new FormData(this);

            fetch('controllers/actualizarPerfilController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Opcional: Recarga la página para actualizar los datos
            })
            .catch(error => console.error('Error al guardar cambios:', error));
        });
    </script>
</body>
</html>
