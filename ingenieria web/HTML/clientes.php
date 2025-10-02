<?php
include("../PHP/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];

    $sql = "INSERT INTO clientes (nombre, apellido, correo, celular) 
            VALUES ('$nombre', '$apellido', '$correo', '$celular')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../HTML/clientes.php?success=1");
        exit();
    } else {
        header("Location: ../HTML/clientes.php?error=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos_panelcontrol.css"> <!-- mismo CSS que usas en el panel -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="../js/clientes.js"></script>
    <link rel="icon" type="image/x-icon" href="../img/icon.ico">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <img src="../img/logo.png" alt="Logo Empresa">
    <a href="../HTML/panel de control.html"><i class="bi bi-box"></i>Panel de control</a>
    <a href="#"><i class="bi bi-box"></i> Inventario</a>
    <a href="#"><i class="bi bi-cart"></i> Compras</a>
    <a href="#"><i class="bi bi-bag"></i> Ventas</a>
    <a href="#"><i class="bi bi-cash-coin"></i> Balance</a>
    <a href="clientes.php" class="active"><i class="bi bi-people"></i> Clientes</a>
</div>

<div class="topbar">
    <h2><strong>Clientes</strong></h2>
    <a href="login.html" class="btn btn-outline-danger">Cerrar Sesión</a>
</div>

<!-- Contenido -->
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2></h2>
        <a href="login.html"></a>
    </div>

    <!-- Botón agregar -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregar">
        + Agregar Cliente
    </button>

    <!-- Card con tabla -->
    <div class="card shadow p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM clientes";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                              <td>".$row['id']."</td>
                              <td>".$row['nombre']."</td>
                              <td>".$row['apellido']."</td>
                              <td>".$row['correo']."</td>
                              <td>".$row['celular']."</td>
                              <td>
                                <button class='btn btn-warning btn-sm btnEditar' 
                                        data-id='".$row['id']."' 
                                        data-nombre='".$row['nombre']."' 
                                        data-apellido='".$row['apellido']."' 
                                        data-correo='".$row['correo']."' 
                                        data-celular='".$row['celular']."'>
                                    Editar
                                </button>
                                <a href='../PHP/eliminar_cliente.php?id=".$row['id']."' 
                                   class='btn btn-danger btn-sm btnEliminar'>
                                   Eliminar
                                </a>
                              </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No hay clientes registrados</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal agregar -->
<div class="modal fade" id="modalAgregar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../PHP/registrar_cliente.php" method="POST">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Registrar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>
                    <input type="text" name="apellido" class="form-control mb-2" placeholder="Apellido" required>
                    <input type="email" name="correo" class="form-control mb-2" placeholder="Correo" required>
                    <input type="text" name="celular" class="form-control mb-2" placeholder="Celular" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../PHP/editar_cliente.php" method="POST">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <input type="text" name="nombre" id="editNombre" class="form-control mb-2" required>
                    <input type="text" name="apellido" id="editApellido" class="form-control mb-2" required>
                    <input type="email" name="correo" id="editCorreo" class="form-control mb-2" required>
                    <input type="text" name="celular" id="editCelular" class="form-control mb-2" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
