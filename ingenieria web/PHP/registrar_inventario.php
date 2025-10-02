<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $nombre = $_POST['nombre'];
    $precio = (float)$_POST['precio'];
    $stock = (int)$_POST['stock'];
    $imagen = $_POST['imagen'] ?? '';

    $stmt = $conn->prepare("INSERT INTO inventario (nombre, precio, stock, imagen) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdis", $nombre, $precio, $stock, $imagen);
    if ($stmt->execute()) {
        header("Location: ../HTML/inventario.php?success=1");
    } else {
        header("Location: ../HTML/inventario.php?error=1");
    }
    $stmt->close();
    exit();
}
?>
