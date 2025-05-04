<?php
session_start();
$nombreUsuario = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>FigurArts - Inicio</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="FigurArts" />
        </div>
        <nav>
        <form class="search-bar" id="searchForm" onsubmit="buscarProducto(event)">
        <input type="text" id="searchInput" placeholder="Buscar" />
        <button type="submit">
            <img src="lupa.png" alt="Buscar" />
        </button>
        </form>


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

    <section id="home">
        <div class="banner">
            <h2>Bienvenido a FigurArts</h2>
            <p>Explora nuestra colección de figuras exclusivas</p>
            <a href="#catalogo" class="btn">Ver Catálogo</a>
            <a href="#novedades" class="btn">Ver Novedades</a>
            <a href="#descuentos" class="btn">Ver Descuentos</a>
        </div>
    </section>

    <section id="catalogo">
        <h2>Catálogo de Figuras</h2>
        <div class="grid" id="catalogo-grid"></div>
    </section>

    <section id="novedades">
        <h2>Novedades</h2>
        <div class="grid" id="novedades-grid"></div>
    </section>

    <section id="descuentos">
        <h2>Descuentos</h2>
        <div class="grid" id="descuentos-grid"></div>
    </section>

    <footer>
        <p>&copy; 2025 FigurArts - Todos los derechos reservados.</p>
    </footer>

    <!-- Scripts -->
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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
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

    
    cargarSeccion('catalogo', 'catalogo-grid');
    cargarSeccion('novedades', 'novedades-grid');
    cargarSeccion('descuentos', 'descuentos-grid');

    function buscarProducto(event) {
    event.preventDefault();
    const input = document.getElementById('searchInput');
    const termino = input.value.trim();

    if (termino === '' || termino.toLowerCase() === 'buscar') {
        // Si el campo está vacío o solo dice "Buscar", recargamos todo el catálogo
        cargarSeccion('catalogo', 'catalogo-grid');
        return;
    }

    fetch('controllers/catalogoController.php?busqueda=' + encodeURIComponent(termino))
        .then(response => response.json())
        .then(data => {
            const grid = document.getElementById('catalogo-grid');
            grid.innerHTML = '';

            if (!Array.isArray(data) || data.length === 0) return;

            data.forEach((producto, index) => {
                const div = document.createElement('div');
                div.classList.add('producto');

                let carrusel = '';
                if (producto.imagenes && producto.imagenes.length > 0) {
                    carrusel = `
                        <div class="carrusel" id="carrusel-busqueda-${index}">
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
                        <button onclick="abrirModal(${producto.id}, 'catalogo')" style="background-color: black; color: white; font-size: 18px;">🔍</button>
                    </div>
                `;

                grid.appendChild(div);
            });
        })
        .catch(error => console.error('Error al buscar producto:', error));
    
}

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

