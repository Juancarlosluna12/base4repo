<?php
require_once('../controller/conexion.php');

function obtenerEmpleados()
{
    global $pdo;

    $sql = "
    SELECT e.noEmpleado, e.nombreEmpleado, r.nombre AS nombreRol, d.nombre AS nombreDepartamento, e.telefono, e.foto, e.apellidoPaterno, e.emailEmpleado
    FROM  Empleado e
    INNER JOIN  Rol r ON e.idRol = r.idRol
    INNER JOIN Departamento d ON e.idDepartamento = d.idDepto";
    try {
        $stmt = $pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    } catch (PDOException $e) {
        echo 'Error en la consulta: ' . $e->getMessage();
        return [];
    }
}


function obtenerEmpleadoPorNumero($noEmpleado)
{
 
    global $pdo;

    $sql = "SELECT e.*, r.nombre as nombrerol, d.nombre
            FROM empleado e 
            INNER JOIN Rol r ON e.idRol = r.idRol 
            INNER JOIN Departamento d ON e.idDepartamento = d.idDepto 
            WHERE e.noEmpleado = :noEmpleado";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':noEmpleado', $noEmpleado, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerClientes()
{
    global $pdo;

    $sql = "select c.nombreCliente,c.apellidoPaterno,c.pais,c.estado,c.direccion,con.telefono,c.idCliente
    from client as c
    LEFT JOIN  contactocliente as con on c.idCliente=con.idCliente
    where  con.idTipoContato = 1 OR con.idTipoContato IS NULL";

    try {
        $stmt = $pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    } catch (PDOException $e) {
        echo 'Error en la consulta: ' . $e->getMessage();
        return [];
    }
}

function obtenerClientePorId($idCliente)
{
    global $pdo;

    try {
        $sql = "SELECT c.nombre, c.apellidoPaterno, c.telefono, c.email, t.tipoContacto,c.horaAtencionSemana,c.horaAtencionFinseman
                FROM contactocliente AS c
                LEFT JOIN tipocontactocliente AS t ON c.idTipoContato = t.idTipoContacto
                WHERE c.idCliente = :idCliente";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idCliente', $idCliente, PDO::PARAM_STR);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $resultados;
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        echo "Error al ejecutar la consulta: " . $e->getMessage();
        return []; // Devuelve un array vacío en caso de error
    }
}

function obtenerProveedor()
{
    global $pdo;

    $sql = "SELECT p.nombreEmpresa, p.direccionProveedor, p.logo, p.sitioWeb, p.rfc, c.telefono, c.email,p.idProveedor
    FROM proveedores AS p
    LEFT JOIN contactoproveedor AS c ON p.idProveedor = c.idProveedor
    WHERE c.idTipoContacto = 1 OR c.idTipoContacto IS NULL";

    try {
        $stmt = $pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $usuarios;
    } catch (PDOException $e) {
        echo 'Error en la consulta: ' . $e->getMessage();
        return [];
    }
}

function obtenerProveedorPorId($idProveedor)
{
    global $pdo;

    try {
        $sql = "SELECT c.nombreProveedor, c.apellidoPaterno, c.telefono, c.email, t.tipoContacto,c.horaAtencionSemana,c.horaAtencionFinsemana
                FROM contactoproveedor AS c
                LEFT JOIN tipocontacto AS t ON c.idTipoContacto = t.idTipoContacto
                WHERE c.idProveedor = :idProveedor";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idProveedor', $idProveedor, PDO::PARAM_STR);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $resultados;
    } catch (PDOException $e) {
        // Manejo de errores de PDO
        echo "Error al ejecutar la consulta: " . $e->getMessage();
        return []; // Devuelve un array vacío en caso de error
    }
}

function subirArchivo($file) {
    global $pdo;

    $nombreArchivo = $file['name'];
    $tipoArchivo = $file['type'];
    $rutaTemporal = $file['tmp_name'];
    $directorioDestino = "../controller/archivos/" . $nombreArchivo;

    if (move_uploaded_file($rutaTemporal, $directorioDestino)) {
        try {
            $sql = "INSERT INTO archivos (nombre, tipo, ruta, fecha_subida) VALUES (:nombre, :tipo, :ruta, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombreArchivo, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipoArchivo, PDO::PARAM_STR);
            $stmt->bindParam(':ruta', $directorioDestino, PDO::PARAM_STR);
            $stmt->execute();

            return "Archivo subido exitosamente";
        } catch (PDOException $e) {
            return "Error al subir el archivo: " . $e->getMessage();
        }
    } else {
        return "Error al mover el archivo";
    }
}


function eliminarArchivo($id) {
    global $pdo;

    try {
        $sql = "DELETE FROM archivos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return "Archivo eliminado exitosamente";
    } catch (PDOException $e) {
        return "Error al eliminar el archivo: " . $e->getMessage();
    }
}



function obtenerArchivos() {
    global $pdo;

    try {
        $sql = "SELECT * FROM archivos";
        $stmt = $pdo->query($sql);
        $archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $archivos;
    } catch (PDOException $e) {
        echo 'Error en la consulta: ' . $e->getMessage();
        return [];
    }
}

