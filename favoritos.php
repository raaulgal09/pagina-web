<?php
session_start();
include 'includes/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nombreUsuario = $_SESSION['usuario_nombre'] ?? 'Usuario';

// Obtener productos favoritos
$sql = "SELECT 
            p.id, 
            p.nombre, 
            p.precio, 
            GROUP_CONCAT(i.nombre_imagen) AS imagenes
        FROM favoritos f
        JOIN productos p ON f.producto_id = p.id
        LEFT JOIN imagenes_producto i ON p.id = i.producto_id
        WHERE f.usuario_id = ?
        GROUP BY p.id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$favoritos = [];
while ($row = $result->fetch_assoc()) {
    $row['imagenes'] = $row['imagenes'] ? explode(',', $row['imagenes']) : [];
    $favoritos[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Favoritos - FigurArts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="logo.png" alt="FigurArts"></a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="favoritos.php">Favoritos</a></li>
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <li><a href="inicio.php">Mi cuenta</a></li>
                <li><a href="logout.php">Cerrar sesión</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Mis Productos Favoritos</h2>
            <?php if (empty($favoritos)): ?>
                <p>No tienes productos en favoritos.</p>
            <?php else: ?>
                <div class="grid">
                    <?php foreach ($favoritos as $producto): ?>
                        <div class="producto">
                            <?php if (!empty($producto['imagenes'])): ?>
                                <img src="admin/uploads/<?= htmlspecialchars($producto['imagenes'][0]) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                            <?php else: ?>
                                <img src="assets/img/default.jpg" alt="Sin imagen">
                            <?php endif; ?>
                            <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                            <p>$<?= number_format($producto['precio'], 2) ?></p>
                            <div class="botones-container">
                                <button onclick="eliminarFavorito(<?= $producto['id'] ?>)" style="background-color: crimson; color: white;">Quitar ❤️</button>
                                <button onclick="agregarAlCarrito(<?= $producto['id'] ?>, 1)" style="background-color: rgb(11, 11, 11); color: white; font-size: 18px;">🛒</button>
                                <button onclick="abrirModal(<?= $producto['id'] ?>, 'catalogo')" style="background-color: black; color: white; font-size: 18px;">🔍</button>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <script>
    function eliminarFavorito(idProducto) {
        const formData = new FormData();
        formData.append('producto_id', idProducto);
        formData.append('accion', 'eliminar');

        fetch('controllers/favoritosController.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Producto eliminado de favoritos");
                location.reload();
            } else {
                alert("No se pudo eliminar.");
            }
        })
        .catch(err => console.error('Error:', err));
    }

    function agregarAlCarrito(idProducto, cantidad) {
    const formData = new FormData();
    formData.append('id_producto', idProducto);
    formData.append('cantidad', cantidad);

    fetch('controllers/carritoController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Eliminar de favoritos si se agregó al carrito correctamente
            eliminarFavorito(idProducto);
            alert("✅ " + data.success);
        } else if (data.error) {
            alert("⚠️ " + data.error);
        } else {
            alert("⚠️ Algo salió mal.");
        }
    })
    .catch(error => console.error('Error:', error));
}



    function abrirModal(id, tipo) {
        const modal = document.getElementById('productoModal');
        modal.style.display = 'block';

        document.getElementById('modalNombre').textContent = 'Cargando...';
        document.getElementById('modalCarrusel').innerHTML = '';

        fetch(`controllers/catalogoController.php?tipo=${tipo}&id=${id}`)
            .then(response => response.json())
            .then(producto => {
                document.getElementById('modalNombre').textContent = producto.nombre;
                document.getElementById('modalPrecio').textContent = `$${producto.precio}`;
                document.getElementById('modalDescripcion').textContent = producto.descripcion || 'Sin descripción';
                document.getElementById('modalCategoria').textContent = `Categoría: ${producto.categoria}`;
                document.getElementById('modalEdicion').textContent = `Edición: ${producto.edicion || 'Estándar'}`;
                document.getElementById('modalDisponibilidad').textContent = `Disponibilidad: ${producto.disponibilidad}`;
                document.getElementById('modalStock').textContent = `Stock: ${producto.stock}`;

                const carrusel = document.getElementById('modalCarrusel');
                if (producto.imagenes && producto.imagenes.length > 0) {
                    producto.imagenes.forEach(imagen => {
                        const img = document.createElement('img');
                        img.src = `admin/uploads/${imagen}`;
                        img.alt = producto.nombre;
                        carrusel.appendChild(img);
                    });
                } else {
                    carrusel.innerHTML = '<p>No hay imágenes disponibles</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('modalNombre').textContent = 'Error al cargar el producto';
            });
    }

    function cerrarModal() {
        const modal = document.getElementById('productoModal');
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }

    document.addEventListener('click', function(event) {
        const modal = document.getElementById('productoModal');
        if (event.target.classList.contains('close-modal') || event.target === modal) {
            cerrarModal();
        }
    });
    </script>

    <!-- MODAL FUERA DEL FLUJO -->
    <div id="productoModal" class="modal">
  <div class="modal-content ml-style">
    <span class="close-modal">&times;</span>
    <div class="modal-grid">
      <!-- Columna Izquierda: Carrusel -->
      <div class="modal-images">
        <div class="thumbnails" id="modalThumbnails"></div>
        <div id="modalCarrusel" class="main-image"></div>
      </div>

      <!-- Columna Derecha: Información -->
      <div class="modal-info">
        <span class="nuevo">Nuevo | +10 vendidos</span>
        <h2 id="modalNombre">Nombre del producto</h2>
        <div class="stars">⭐ 4.7 (1929)</div>
        <div class="precio-anterior">$ <s>1,085.00</s></div>
        <div id="modalPrecio" class="precio-descuento">$ 477.71 <span class="oferta">55% OFF</span></div>
        <div class="meses">en 3 meses sin intereses de $159.24</div>
        <p class="iva">IVA incluido</p>

        <a href="#" class="ver-pagos">Ver los medios de pago</a>

        <div class="envio-gratis">✅ Llega gratis mañana domingo</div>
        <div class="retiro-gratis">📍 Retira gratis el lunes en punto de retiro</div>

        <p id="modalDescripcion"></p>
        <p id="modalCategoria"></p>
        <p id="modalEdicion"></p>
        <p id="modalDisponibilidad"></p>
        <p id="modalStock"></p>
      </div>
    </div>
  </div>
</div>

</body>
</html>
