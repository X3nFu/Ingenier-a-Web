<?php
include("conexion.php");

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
