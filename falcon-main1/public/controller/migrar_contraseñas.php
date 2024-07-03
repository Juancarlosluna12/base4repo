<?php
require_once('../controller/conexion.php');

// Código de migración de contraseñas
try {
    // Consulta para seleccionar todos los registros de empleados con contraseñas existentes
    $sql = "SELECT idEmpleado, password FROM empleado";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($empleados as $empleado) {
        $idEmpleado = $empleado['idEmpleado'];
        $passwordActual = $empleado['password'];

        // Aplicar password_hash() a la contraseña actual
        $hashed_password = password_hash($passwordActual, PASSWORD_DEFAULT);

        // Actualizar el registro con el nuevo hash de contraseña
        $update_sql = "UPDATE empleado SET hashed_password = :hashed_password WHERE idEmpleado = :idEmpleado";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([
            'hashed_password' => $hashed_password,
            'idEmpleado' => $idEmpleado
        ]);

        echo "Contraseña actualizada para el empleado ID $idEmpleado.<br>";
    }

    echo "¡Proceso de migración completado!";
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    error_log('Error en la migración de contraseñas: ' . $e->getMessage());
    die("Error en la migración de contraseñas: " . $e->getMessage());
}
