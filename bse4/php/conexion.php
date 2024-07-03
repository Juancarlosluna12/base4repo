<?php
// Datos de conexión a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "base4"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8");
?>

