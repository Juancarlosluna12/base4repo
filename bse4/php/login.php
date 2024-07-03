<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validar entrada y proteger contra inyección SQL
    $email = $conn->real_escape_string($email);

    // Buscar el usuario en la base de datos
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            echo "success";
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No existe una cuenta con este correo electrónico.";
    }

    $conn->close();
}
?>
