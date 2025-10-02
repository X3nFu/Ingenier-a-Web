<?php
include("conexion.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("DELETE FROM inventario WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: ../HTML/inventario.php?deleted=1");
    } else {
        header("Location: ../HTML/inventario.php?deleted=0");
    }
    exit();
}
?>
