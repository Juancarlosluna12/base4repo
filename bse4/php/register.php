<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar entrada y proteger contra inyección SQL
    $fullname = $conn->real_escape_string($fullname);
    $email = $conn->real_escape_string($email);
    $username = $conn->real_escape_string($username);
    $password = password_hash($conn->real_escape_string($password), PASSWORD_DEFAULT);

    // Verificar si el usuario ya existe
    $checkUser = $conn->query("SELECT * FROM users WHERE email = '$email' OR username = '$username'");
    if ($checkUser->num_rows > 0) {
        echo "El usuario o correo electrónico ya está en uso.";
    } else {
        // Insertar datos en la base de datos
        $sql = "INSERT INTO users (fullname, email, username, password) VALUES ('$fullname', '$email', '$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
