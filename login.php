<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="styles_login.css">
</head>
<body>
    <header>
        <h1>FigurArts</h1>
        <nav>
            <ul>
                <li><a href="index.html">Inicio</a></li>
                <li><a href="catalogo.html">Catálogo</a></li>
                <li><a href="carrito.html">Carrito</a></li>
                <li><a href="registro.html">Registrarse</a></li>
            </ul>
        </nav>
    </header>

    <section class="auth-container">
        <div class="auth-box">
            <h2>Iniciar Sesión</h2>
            <form action="#" method="POST">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Ingresar</button>

                <script>
                    document.querySelector("form").addEventListener("submit", function(event) {
                        event.preventDefault(); // Evita que el formulario se envíe automáticamente
                
                        let email = document.getElementById("email").value;
                        let password = document.getElementById("password").value;
                
                        // Simulación de validación (Aquí puedes conectar con el backend)
                        if (email === "raul@gmail.com" && password === "123") {
                            alert("Inicio de sesión exitoso.");
                            localStorage.setItem("userLoggedIn", "true"); // Guarda el estado de sesión
                            window.location.href = "inicio.html"; // Redirige al usuario a inicio
                        } else {
                            alert("Correo o contraseña incorrectos.");
                        }
                    });
                </script>
                
            </form>
            <p>¿No tienes cuenta? <a href="registro.html">Regístrate aquí</a></p>
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
    <title>Iniciar Sesión - FigurArts</title>
    <link rel="stylesheet" href="styles_login.css">
</head>
<body>
    <header>
        <h1>FigurArts</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="registro.php">Registrarse</a></li>
            </ul>
        </nav>
    </header>

    <section class="auth-container">
        <div class="auth-box">
            <h2>Iniciar Sesión</h2>
            <form id="login-form">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Ingresar</button>
            </form>

            <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
    </footer>

    <script>
    document.getElementById("login-form").addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('controllers/loginController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Esperamos JSON ahora
        .then(data => {
            if (data.status === "success") {
                alert("Inicio de sesión exitoso.");
                
                // Redirige según el rol
                if (data.rol === "admin") {
                    window.location.href = "admin/dashboard.php";
                } else {
                    window.location.href = "inicio.php";
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Error al procesar la solicitud.");
        });
    });
    </script>

</body>
</html>
