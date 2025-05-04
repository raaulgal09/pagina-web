<?php
session_start();
$nombreUsuario = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="FigurArts">
        </div>
        <nav>
            <ul>
                <li><a href="inicio.html">Inicio</a></li>
                <li><a href="catalogo.html">Catálogo</a></li>
                <li><a href="configuracion.html">Mi Cuenta</a></li>
                <li><a href="index.html">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    
    <section id="carrito">
        <h2>Mi Carrito</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Figura Coleccionable 1</td>
                    <td>$50.00</td>
                    <td><input type="number" value="1" min="1"></td>
                    <td>$50.00</td>
                    <td><button class="btn-remove">Eliminar</button></td>
                </tr>
            </tbody>
        </table>
        
        <div class="cart-summary">
            <p>Subtotal: <span>$50.00</span></p>
            <p>Costo de Envío: <span>$5.00</span></p>
            <p>Total: <span>$55.00</span></p>
            <button class="btn-checkout">Finalizar Compra</button>
            <button class="btn-clear">Vaciar Carrito</button>
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
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="FigurArts">
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

    <section id="carrito">
        <h2>Mi Carrito</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="carrito-body">
                <!-- Se llena dinámicamente -->
            </tbody>
        </table>

        <div class="usuario-info" id="info-usuario">
        <h3>Dirección de Envío</h3>
        <p id="direccion">Cargando dirección...</p>

        <h3>Medio de Pago</h3>
        <p id="medio-pago">Cargando medio de pago...</p>
        </div>

        <div class="cart-summary">
            <p>Subtotal: <span id="subtotal">$0.00</span></p>
            <p>Costo de Envío: <span id="envio">$350.00</span></p>
            <p>Total: <span id="total">$0.00</span></p>
            <button class="btn-checkout" onclick="finalizarCompra()">Finalizar Compra</button>
            <button class="btn-clear" onclick="vaciarCarrito()">Vaciar Carrito</button>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
    </footer>

    <script>
let subtotal = 0;

function cargarCarrito() {
    fetch('controllers/carritoController.php', {
        method: 'GET'
    })
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('carrito-body');
        tbody.innerHTML = '';
        subtotal = 0;

        console.log("✅ Productos en carrito:", data); // para depuración

        if (!data || data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5">Tu carrito está vacío.</td></tr>';
            document.getElementById('subtotal').textContent = '$0.00';
            document.getElementById('total').textContent = '$0.00';
            return;
        }

        data.forEach(item => {
            // Sumar el subtotal del producto a la variable total
            subtotal += parseFloat(item.subtotal);

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="producto-info">
                    <img src="admin/uploads/${item.imagen}" alt="${item.nombre}">
                    <span>${item.nombre}</span>
                </td>
                <td>$${parseFloat(item.precio).toFixed(2)}</td>
                <td>
                <div class="contador">
                    <button onclick="cambiarCantidad(${item.id_producto}, -1)">➖</button>
                    <span id="cantidad-${item.id_producto}" data-cantidad="${item.cantidad}">${item.cantidad}</span>
                    <button onclick="cambiarCantidad(${item.id_producto}, 1)">➕</button>
                </div>
                </td>
                <td>$${parseFloat(item.subtotal).toFixed(2)}</td>
                <td><button class="btn-remove" onclick="eliminarProducto(${item.id_producto})">🗑️</button></td>
            `;
            tbody.appendChild(tr);
        });

        let envio = 350;
        if (subtotal > 800) {
            envio = 0;
        }

        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('envio').textContent = envio === 0 ? 'Gratis' : `$${envio.toFixed(2)}`;
        document.getElementById('total').textContent = `$${(subtotal + envio).toFixed(2)}`;

    })
    .catch(error => {
        console.error("❌ Error al obtener carrito:", error);
    });
}


function eliminarProducto(id) {
    fetch('controllers/carritoController.php', {
        method: 'DELETE',
        body: new URLSearchParams({ id_producto: id })
    })
    .then(res => res.json())
    .then(() => {
        cargarCarrito();
    });
}

function actualizarCantidad(id, cantidad) {
    const formData = new FormData();
    formData.append('accion', 'actualizar');
    formData.append('id_producto', id);
    formData.append('cantidad', cantidad);

    fetch('controllers/carritoController.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            cargarCarrito(); // refresca tabla
        } else {
            alert(data.error || 'Error al actualizar cantidad');
        }
    })
    .catch(error => {
        console.error('❌ Error al actualizar cantidad:', error);
    });
}

function cambiarCantidad(id, delta) {
    const cantidadSpan = document.getElementById(`cantidad-${id}`);
    if (!cantidadSpan) return;

    let cantidadActual = parseInt(cantidadSpan.getAttribute('data-cantidad')) || 1;
    let nuevaCantidad = cantidadActual + delta;

    if (nuevaCantidad < 1) return;

    const formData = new FormData();
    formData.append('accion', 'actualizar');
    formData.append('id_producto', id);
    formData.append('cantidad', nuevaCantidad);

    fetch('controllers/carritoController.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // actualiza visualmente sin esperar el reload completo
            cantidadSpan.setAttribute('data-cantidad', nuevaCantidad);
            cantidadSpan.textContent = nuevaCantidad;

            // recalcular precios sin recargar todo si quieres (opcional)
            cargarCarrito();
        } else {
            alert(data.error || 'Error al actualizar cantidad');
        }
    })
    .catch(error => {
        console.error('❌ Error al actualizar cantidad:', error);
    });
}

function cargarDatosUsuario() {
    fetch('controllers/verificarUsuarioCompra.php') 
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                document.getElementById('direccion').textContent = 'No autorizado';
                document.getElementById('medio-pago').textContent = 'No autorizado';
                return;
            }

            if (data.direccion) {
                const d = data.direccion;
                document.getElementById('direccion').textContent =
                    `${d.calle}, ${d.colonia}, ${d.codigo_postal}, ${d.ciudad}, ${d.estado}, ${d.pais}`;
            } else {
                document.getElementById('direccion').textContent =
                    '❌ No has agregado una dirección de envío.';
            }

            if (data.pago) {
                const p = data.pago;
                document.getElementById('medio-pago').textContent =
                    `•••• •••• •••• ${p.numero.slice(-4)}, Vence ${p.expiracion}`;
            } else {
                document.getElementById('medio-pago').textContent =
                    '❌ No tienes un método de pago registrado.';
            }
        })
        .catch(error => {
            console.error('❌ Error al cargar dirección o pago:', error);
        });
}


function finalizarCompra() {
    fetch('controllers/verificarUsuarioCompra.php')
        .then(res => res.json())
        .then(data => {
            if (!data.direccion) {
                alert("Debes registrar una dirección de envío antes de comprar.");
                return;
            }
            if (!data.pago) {
                alert("Debes registrar un medio de pago antes de comprar.");
                return;
            }

            // Si pasa validación, realiza la compra
            fetch('controllers/validarCompra.php')
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    alert("Compra realizada correctamente. ¡Gracias!");
                    window.location.href = 'mis_pedidos.php'; // o 'index.php'
                })
                .catch(err => console.error("❌ Error en validarCompra:", err));
        })
        .catch(err => console.error("❌ Error en verificarUsuarioCompra:", err));
}


function vaciarCarrito() {
    if (confirm("¿Estás seguro que deseas vaciar el carrito?")) {
        const formData = new FormData();
        formData.append('accion', 'vaciar');

        fetch('controllers/carritoController.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert(data.success || 'Carrito vaciado');
            cargarCarrito(); // recargar la vista
        })
        .catch(error => {
            console.error('❌ Error al vaciar carrito:', error);
        });
    }
}


cargarCarrito();
cargarDatosUsuario();

</script>

</body>
</html>
