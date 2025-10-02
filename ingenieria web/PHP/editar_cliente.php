<?php
include("conexion.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$celular = $_POST['celular'];

$sql = "UPDATE clientes SET nombre='$nombre', apellido='$apellido', correo='$correo', celular='$celular' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: ../HTML/clientes.php?updated=1");
    exit();
} else {
    header("Location: ../HTML/clientes.php?updated=0");
    exit();
}
?>
