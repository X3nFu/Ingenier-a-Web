<?php
include("../PHP/conexion.php"); // Asegúrate que la ruta coincide
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos_panelcontrol.css"> <!-- tu CSS del panel -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../img/icon.ico">
    <style>
        /* ajustes puntuales para cards del inventario */
        .item-card { cursor: default; }
        .item-img { height:140px; object-fit:contain; }
        .chip { display:inline-block; padding:6px 10px; border-radius:20px; background:#eee; margin-right:6px; font-size:0.85rem; }
        .top-controls { gap:12px; }
    </style>
</head>
<body>

<!-- Sidebar (igual que en el panel) -->
<div class="sidebar">
    <img src="../img/logo.png" alt="Logo Empresa" style="width:140px;margin-bottom:20px;">
    <a href="panel%20de%20control.html"><i class="bi bi-house"></i> Panel</a>
    <a href="inventario.php" class="active"><i class="bi bi-box"></i> Inventario</a>
    <a href="compras.php"><i class="bi bi-cart"></i> Compras</a>
    <a href="ventas.php"><i class="bi bi-bag"></i> Ventas</a>
    <a href="balance.php"><i class="bi bi-cash-coin"></i> Balance</a>
    <a href="clientes.php"><i class="bi bi-people"></i> Clientes</a>
</div>

<div class="topbar">
    <h2><strong>Inventario</strong></h2>
    <a href="login.html" class="btn btn-outline-danger">Cerrar Sesión</a>
</div>

<!-- Contenido -->
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="login.html"></a>
    </div>

    <!-- Buscador + filtros + agregar -->
    <div class="d-flex align-items-center mb-3 top-controls">
        <div class="me-3" style="flex:1; max-width:450px;">
            <div class="input-group">
                <input id="searchInput" type="text" class="form-control" placeholder="Search">
                <button id="btnSearchClear" class="btn btn-outline-secondary" type="button">✕</button>
            </div>
        </div>

        <div class="me-2">
            <span class="chip" id="sort-stock-desc">-Cantidad</span>
            <span class="chip" id="sort-price-asc">+Precio</span>
            <span class="chip" id="sort-price-desc">-Precio</span>
            <span class="chip" id="sort-stock-asc">+Cantidad</span>
        </div>

        <div class="ms-auto">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">+ Agregar Producto</button>
        </div>
    </div>

    <!-- Grid de items -->
    <div id="gridContainer" class="row g-4">
        <?php
        // Query items
        $sql = "SELECT * FROM inventario ORDER BY nombre ASC";
        $res = $conn->query($sql);
        if ($res && $res->num_rows > 0) {
            while($r = $res->fetch_assoc()) {
                $id = (int)$r['id'];
                $nombre = htmlspecialchars($r['nombre']);
                $precio = number_format((float)$r['precio'],0,',','.');
                $stock = (int)$r['stock'];
                $img = !empty($r['imagen']) ? $r['imagen'] : 'https://via.placeholder.com/300x200?text=No+Image';
                // item card
                echo "<div class='col-md-4 col-lg-3'>
                      <div class='card item-card shadow-sm' data-name='".strtolower($nombre)."' data-price='".(float)$r['precio']."' data-stock='$stock'>
                        <div class='position-relative'>
                          <img src='$img' class='card-img-top item-img' alt='$nombre'>
                          <div class='position-absolute top-0 end-0 m-2'>
                            <button class='btn btn-sm btn-light btnEditar' 
                                    data-id='$id' data-nombre=\"".htmlspecialchars($r['nombre'])."\" data-precio='".(float)$r['precio']."' data-stock='$stock' data-imagen='".htmlspecialchars($r['imagen'])."'>
                              ✎
                            </button>
                            <a href='../PHP/eliminar_inventario.php?id=$id' class='btn btn-sm btn-danger btnEliminar'>🗑</a>
                          </div>
                        </div>
                        <div class='card-body'>
                          <h6 class='card-title'>$nombre</h6>
                          <p class='mb-1'><strong>\$$precio</strong></p>
                          <p class='text-muted small'>Stock: $stock</p>
                        </div>
                      </div>
                    </div>";
            }
        } else {
            echo "<div class='col-12'><div class='alert alert-info'>No hay productos en el inventario.</div></div>";
        }
        ?>
    </div>
</div>

<!-- Modal Agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../PHP/registrar_inventario.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input name="nombre" type="text" class="form-control mb-2" placeholder="Nombre" required>
                    <input name="precio" type="number" step="0.01" class="form-control mb-2" placeholder="Precio" required>
                    <input name="stock" type="number" class="form-control mb-2" placeholder="Stock" required>
                    <input name="imagen" type="text" class="form-control mb-2" placeholder="URL imagen (opcional)">
                    <!-- si quieres subir archivos, cambiar a input type=file y procesar en PHP -->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../PHP/editar_inventario.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <input name="nombre" id="edit_nombre" type="text" class="form-control mb-2" placeholder="Nombre" required>
                    <input name="precio" id="edit_precio" type="number" step="0.01" class="form-control mb-2" placeholder="Precio" required>
                    <input name="stock" id="edit_stock" type="number" class="form-control mb-2" placeholder="Stock" required>
                    <input name="imagen" id="edit_imagen" type="text" class="form-control mb-2" placeholder="URL imagen (opcional)">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" type="submit">Actualizar</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* ------------------ Client-side: búsqueda, orden y modals ------------------ */
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.getElementById('gridContainer');
        const cardsSelector = '.item-card';
        const searchInput = document.getElementById('searchInput');

        // Buscar por nombre (filtro)
        searchInput.addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            document.querySelectorAll(cardsSelector).forEach(card => {
                const name = card.getAttribute('data-name') || '';
                card.parentElement.style.display = name.includes(q) ? '' : 'none';
            });
        });
        document.getElementById('btnSearchClear').addEventListener('click', function(){ searchInput.value=''; searchInput.dispatchEvent(new Event('input')); });

        // Función para ordenar: attr = 'price' or 'stock', order = 'asc'/'desc'
        function sortGrid(attr, order) {
            const cols = Array.from(grid.querySelectorAll(':scope > div')); // columnas (col-*)
            cols.sort((a,b) => {
                const va = parseFloat(a.querySelector('.item-card').dataset[attr]) || 0;
                const vb = parseFloat(b.querySelector('.item-card').dataset[attr]) || 0;
                return (order === 'asc') ? va - vb : vb - va;
            });
            // Rearmar DOM
            cols.forEach(c => grid.appendChild(c));
        }

        // Hooks para chips
        document.getElementById('sort-price-asc').addEventListener('click', ()=> sortGrid('price','asc'));
        document.getElementById('sort-price-desc').addEventListener('click', ()=> sortGrid('price','desc'));
        document.getElementById('sort-stock-asc').addEventListener('click', ()=> sortGrid('stock','asc'));
        document.getElementById('sort-stock-desc').addEventListener('click', ()=> sortGrid('stock','desc'));

        // Edit buttons: llenar modal editar
        document.querySelectorAll('.btnEditar').forEach(btn=>{
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const nombre = this.dataset.nombre;
                const precio = this.dataset.precio;
                const stock = this.dataset.stock;
                const imagen = this.dataset.imagen || '';
                // rellenar formulario
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nombre').value = nombre;
                document.getElementById('edit_precio').value = precio;
                document.getElementById('edit_stock').value = stock;
                document.getElementById('edit_imagen').value = imagen;
                // descripcion no la llevé a data- attribute por brevedad; si la necesitas, agrégala en el echo PHP
                new bootstrap.Modal(document.getElementById('modalEditar')).show();
            });
        });

        // Eliminar con confirmación SweetAlert
        document.querySelectorAll('.btnEliminar').forEach(btn=>{
            btn.addEventListener('click', function(e){
                e.preventDefault();
                const href = this.getAttribute('href');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'El producto se eliminará permanentemente',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar'
                }).then(result=>{
                    if (result.isConfirmed) window.location.href = href;
                });
            });
        });

    });
</script>

</body>
</html>
