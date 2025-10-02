<?php
$host = "localhost";
$user = "root";   // usuario por defecto en XAMPP
$pass = "";       // contraseña vacía por defecto
$db   = "tallerautomotriz";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
