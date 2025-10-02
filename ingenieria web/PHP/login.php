<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar usuario en la BD
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario['nombre'];
            header("Location: ../HTML/panel de control.html"); // solo aquí sí redirige
            exit();
        } else {
            // Contraseña incorrecta
            echo "
            <!DOCTYPE html>
            <html>
            <head>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Contraseña incorrecta',
                        text: 'La contraseña ingresada no es válida.'
                    }).then(() => {
                        window.location.href = '../HTML/login.html'; 
                    });
                </script>
            </body>
            </html>";
        }
    } else {
        // Usuario no encontrado
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Usuario no encontrado',
                    text: 'No existe ninguna cuenta con ese correo.'
                }).then(() => {
                    window.location.href = '../HTML/login.html'; 
                });
            </script>
        </body>
        </html>";
    }
}
?>
