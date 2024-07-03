<?php
// conexion.php

// Datos de conexión a la base de datos
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "base4"; 

try {
    // Establecer conexión PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    
    // Habilitar el manejo de errores de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Establecer el modo de recuperación predeterminado a array asociativo
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // En caso de error de conexión
    die("Conexión fallida: " . $e->getMessage());
}
?>
