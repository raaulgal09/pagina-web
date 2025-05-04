<?php
session_start();
$nombreUsuario = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
?>
<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FigurArts - Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="FigurArts">
        </div>
        <nav>
            <form class="search-bar">
                <input type="text" placeholder="Buscar">
                <button type="submit">
                    <img src="search-icon.png" alt="Buscar">
                </button>
            </form>
            <ul>
                <li><a href="inicio.html">Inicio</a></li>
                <li><a href="catalogo.html">Catálogo</a></li>
                <li><a href="carrito.html"><img src="cart-icon.png" alt="">Carrito</a></li>
                <li><a href="configuracion.html"><img src="user-icon.png" alt="">Mi Cuenta</a></li>
                <li><a href="index.html">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    
    <section id="dashboard">
        <div class="banner">
            <h2>Bienvenido a tu cuenta, Usuario</h2>
            <p>Gestiona tus pedidos, datos personales y preferencias.</p>
        </div>
    </section>
    
    <section id="opciones">
        <h2>Opciones de Cuenta</h2>
        <div class="grid">
            <div class="opcion">
                <img src="pedidos-icon.png" alt="Pedidos">
                <h3>Mis Pedidos</h3>
                <p>Revisa el estado de tus compras y pedidos anteriores.</p>
                <a href="pedidos.html" class="btn">Ver Pedidos</a>
            </div>
            <div class="opcion">
                <img src="perfil-icon.png" alt="Perfil">
                <h3>Editar Perfil</h3>
                <p>Actualiza tu información personal y de contacto.</p>
                <a href="settings.html" class="btn">Configurar Perfil</a>
            </div>
            <div class="opcion">
                <img src="direccion-icon.png" alt="Dirección">
                <h3>Dirección de Envío</h3>
                <p>Administra tus direcciones de envío preferidas.</p>
                <a href="direccion.html" class="btn">Editar Dirección</a>
            </div>
            <div class="opcion">
                <img src="seguridad-icon.png" alt="Seguridad">
                <h3>Seguridad</h3>
                <p>Cambia tu contraseña y configura la autenticación.</p>
                <a href="seguridad.html" class="btn">Seguridad</a>
            </div>
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
    <title>FigurArts - Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="FigurArts">
        </div>
        <nav>
            <form class="search-bar">
                <input type="text" placeholder="Buscar">
                <button type="submit">
                    <img src="lupa.png" alt="Buscar">
                </button>
            </form>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="favoritos.php">Favoritos</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="carrito.php"><img src="cart-icon.png" alt="">Carrito</a></li>
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
    
    <section id="dashboard">
        <div class="banner">
            <h2>Bienvenido a tu cuenta, <?php echo htmlspecialchars($nombreUsuario); ?></h2>
            <p>Gestiona tus pedidos, datos personales y preferencias.</p>
        </div>
    </section>
    
    <section id="opciones">
        <h2>Opciones de Cuenta</h2>
        <div class="grid">
            <div class="opcion">
                <img src="pedidos.png" alt="Pedidos">
                <h3>Mis Pedidos</h3>
                <p>Revisa el estado de tus compras y pedidos anteriores.</p>
                <a href="mis_pedidos.php" class="btn">Ver Pedidos</a>
            </div>
            <div class="opcion">
                <img src="perfil.png" alt="Perfil">
                <h3>Editar Perfil</h3>
                <p>Actualiza tu información personal y contraseña.</p>
                <a href="configuracion.php" class="btn">Configurar Perfil</a>
            </div>
            <div class="opcion">
                <img src="ubicacion.png" alt="Dirección">
                <h3>Dirección de Envío</h3>
                <p>Administra tus direcciones de envío preferidas.</p>
                <a href="configuracion2.php#direccion" class="btn">Editar Dirección</a>
            </div>
            <div class="opcion">
                <img src="pago.png" alt="Medio de Pago">
                <h3>Medio de pago</h3>
                <p>Cambia tu medio de pago.</p>
                <a href="configuracion3.php#pagos" class="btn">Medio de pago</a>
            </div>
        </div>
    </section>
    
    <footer>
        <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
    </footer>
</body>
</html>
