<?php
include("conexion.php");

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id = (int)$_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = (float)$_POST['precio'];
    $stock = (int)$_POST['stock'];
    $imagen = $_POST['imagen'] ?? '';

    $stmt = $conn->prepare("UPDATE inventario SET nombre=?, precio=?, stock=?, imagen=? WHERE id=?");
    $stmt->bind_param("sdisi", $nombre, $precio, $stock, $imagen, $id);
    if ($stmt->execute()) {
        header("Location: ../HTML/inventario.php?updated=1");
    } else {
        header("Location: ../HTML/inventario.php?updated=0");
    }
    $stmt->close();
    exit();
}
?>
