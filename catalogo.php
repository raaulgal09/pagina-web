<?php
session_start();
$nombreUsuario = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
?>
<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Figuras</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="FigurArts">
        </div>
        <nav>
            <ul>
                <li><a href="inicio.html">Inicio</a></li>
                <li><a href="carrito.html">Carrito</a></li>
                <li><a href="configuracion.html">Mi Cuenta</a></li>
                <li><a href="index.html">Cerrar Sesión</a></li>
            </ul>
        </nav>
    </header>
    
    <section id="catalogo">
        <h2>Catálogo de Figuras</h2>
        <div class="grid">
            <div class="producto">
                <img src="pop.webp" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="marin3.webp" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="marin2.webp" alt="Figura 3">
                <h3>Figura Coleccionable 3</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="Nyaruko.webp" alt="Figura 4">
                <h3>Figura Coleccionable 4</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="liliel.webp" alt="Figura 5">
                <h3>Figura Coleccionable 5</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="Misaki.webp" alt="Figura 6">
                <h3>Figura Coleccionable 6</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="rezero.webp" alt="Figura 7">
                <h3>Figura Coleccionable 7</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="azuna.webp" alt="Figura 8 ">
                <h3>Figura Coleccionable 8</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="kurumi.webp" alt="Figura 9">
                <h3>Figura Coleccionable 9</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="hisako.webp" alt="Figura 10">
                <h3>Figura Coleccionable 10</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="alpha.webp" alt="Figura 11">
                <h3>Figura Coleccionable 11</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="beta.webp" alt="Figura 12">
                <h3>Figura Coleccionable 12</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen1.jpg" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen2.jpg" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen1.jpg" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen2.jpg" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen1.jpg" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen2.jpg" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen1.jpg" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen2.jpg" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen1.jpg" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen2.jpg" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen1.jpg" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen2.jpg" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen1.jpg" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen2.jpg" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen1.jpg" alt="Figura 1">
                <h3>Figura Coleccionable 1</h3>
                <p>$50.00</p>
                <button>Añadir al Carrito</button>
            </div>
            <div class="producto">
                <img src="imagen2.jpg" alt="Figura 2">
                <h3>Figura Coleccionable 2</h3>
                <p>$60.00</p>
                <button>Añadir al Carrito</button>
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
    <title>Catálogo de Figuras</title>
    <link rel="stylesheet" href="styles.css">
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
    
    <section id="catalogo">
        <h2>Catálogo de Figuras</h2>
        <div class="grid" id="catalogo-grid"></div>
    </section>
    
    <footer>
        <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
    </footer>

    <script>
    function cargarSeccion(seccion, destino) {
        fetch('controllers/catalogoController.php?tipo=' + seccion)
            .then(response => response.json())
            .then(data => {
                const grid = document.getElementById(destino);
                grid.innerHTML = '';

                data.forEach((producto, index) => {
                    const div = document.createElement('div');
                    div.classList.add('producto');

                    let carrusel = '';
                    if (producto.imagenes && producto.imagenes.length > 0) {
                        carrusel = `
                            <div class="carrusel" id="carrusel-${destino}-${index}">
                                <div class="carrusel-imagenes" style="display: flex; overflow-x: auto; scroll-behavior: smooth;">
                                    ${producto.imagenes.map(imagen => `<img src="admin/uploads/${imagen}" alt="${producto.nombre}">`).join('')}
                                </div>
                            </div>
                        `;
                    } else {
                        carrusel = `<img src="assets/img/default.jpg" alt="Sin imagen">`;
                    }

                    const esFavorito = favoritosUsuario.includes(producto.id);
                    const iconoFavorito = esFavorito ? '❤️' : '🤍';

                    div.innerHTML = `
                        ${carrusel}
                        <h3>${producto.nombre}</h3>
                        <p>$${producto.precio}</p>
                        <div class="botones-container">
                             <button onclick="toggleFavorito(${producto.id})" id="fav-${producto.id}" class="btn-favorito" style="background-color: crimson; color: white; font-size: 18px;">${iconoFavorito}</button>
                            <button onclick="agregarAlCarrito(${producto.id}, 1)" style="background-color: rgb(11, 11, 11); color: white; font-size: 18px;">🛒</button>
                            <button onclick="abrirModal(${producto.id}, '${seccion}')" style="background-color: black; color: white; font-size: 18px;">🔍</button>

                        </div>
                    `;

                    grid.appendChild(div);
                });
            })
            .catch(error => console.error('Error al cargar ' + seccion + ':', error));
    }

    function agregarAlCarrito(idProducto, cantidad) {
        const formData = new FormData();
        formData.append('id_producto', idProducto);
        formData.append('cantidad', cantidad);

        fetch('controllers/carritoController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => alert(data))
        .catch(error => console.error('Error:', error));
    }

    function abrirModal(id, tipo) {
    const modal = document.getElementById('productoModal');
    modal.style.display = 'block';
    
    // Limpiar contenido previo
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
        document.body.style.overflow = ''; // Reactiva el scroll de fondo
    }

    document.addEventListener('click', function(event) {
        const modal = document.getElementById('productoModal');
        if (event.target.classList.contains('close-modal') || event.target === modal) {
            cerrarModal();
        }
    });

    cargarSeccion('catalogo', 'catalogo-grid');
    cargarSeccion('novedades', 'novedades-grid');
    cargarSeccion('descuentos', 'descuentos-grid');
    let favoritosUsuario = [];

function cargarFavoritosUsuario() {
    fetch('controllers/favoritosController.php')
        .then(res => res.json())
        .then(data => {
            favoritosUsuario = data;
        });
}


function toggleFavorito(idProducto) {
    const esFavorito = favoritosUsuario.includes(idProducto);
    const accion = esFavorito ? 'eliminar' : 'agregar';

    const formData = new FormData();
    formData.append('producto_id', idProducto);
    formData.append('accion', accion);

    fetch('controllers/favoritosController.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (accion === 'agregar') {
            favoritosUsuario.push(idProducto);
            document.getElementById(`fav-${idProducto}`).textContent = '❤️';
        } else {
            favoritosUsuario = favoritosUsuario.filter(id => id !== idProducto);
            document.getElementById(`fav-${idProducto}`).textContent = '🤍';
        }
    })
    .catch(err => console.error('Error favoritos:', err));
}
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
