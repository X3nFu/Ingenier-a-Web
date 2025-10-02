<?php
include("conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM clientes WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../HTML/clientes.php?deleted=1");
} else {
    header("Location: ../HTML/clientes.php?deleted=0");
}
?>
