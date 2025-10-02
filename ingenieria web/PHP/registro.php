<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tallerautomotriz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Verificar si el correo ya existe
$checkEmail = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($checkEmail);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesando Registro</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
if ($result->num_rows > 0) {
    echo "
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Correo duplicado',
            text: 'El correo ya está registrado. Intenta con otro.',
            confirmButtonColor: '#3085d6'
        }).then(() => {
            window.location.href = '../HTML/registro.html';
        });
    </script>";
} else {
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Registro exitoso!',
                text: 'Ahora puedes iniciar sesión en la plataforma',
                confirmButtonColor: '#00205b'
            }).then(() => {
                window.location.href = '../HTML/login.html';
            });
        </script>";
    } else {
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema con el registro: " . addslashes($conn->error) . "',
                confirmButtonColor: '#c0392b'
            }).then(() => {
                window.location.href = '../HTML/registro.html';
            });
        </script>";
    }
}
$conn->close();
?>
</body>
</html>
