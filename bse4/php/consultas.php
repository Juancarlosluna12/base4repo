<?php
// Incluir el archivo de conexión
include 'conexion.php'; // Asegúrate de que este archivo tenga la conexión $conn establecida

// Array para almacenar la respuesta final
$response = array();

//--------------------------------------------------Empleados------------------------------------------------------------------------------------//

// Parámetros de búsqueda
$query = isset($_GET['q']) ? $_GET['q'] : '';
$area = isset($_GET['area']) ? $_GET['area'] : '';

// Consulta base de empleados
$sql_empleados = "SELECT e.noEmpleado, e.nombreEmpleado, r.nombre AS nombreRol, d.nombre AS nombreDepartamento, e.telefono, e.foto, e.apellidoPaterno, e.emailEmpleado
                 FROM Empleado e
                 INNER JOIN Rol r ON e.idRol = r.idRol
                 INNER JOIN Departamento d ON e.idDepartamento = d.idDepto
                 WHERE (e.nombreEmpleado LIKE '%$query%' OR e.noEmpleado LIKE '%$query%')";

// Añadir filtro de área si está presente
if ($area !== '') {
    $sql_empleados .= " AND d.nombre = '$area'";
}

$result_empleados = $conn->query($sql_empleados);

// Array para almacenar los datos de empleados
$empleados = array();

if ($result_empleados->num_rows > 0) {
    // Salida de datos de cada fila
    while($row = $result_empleados->fetch_assoc()) {
        // Agregar cada fila como un objeto al array
        $empleados[] = $row;
    }
} else {
    $response['empleados'] = [];
}

// Agregar los datos de empleados a la respuesta
$response['empleados'] = $empleados;

// Consulta para obtener los nombres de departamento
$sql_departamentos = "SELECT nombre FROM Departamento";
$result_departamentos = $conn->query($sql_departamentos);

// Array para almacenar los nombres de departamento
$departamentos = array();

if ($result_departamentos->num_rows > 0) {
    // Salida de datos de cada fila
    while($row = $result_departamentos->fetch_assoc()) {
        // Agregar cada fila como un objeto al array
        $departamentos[] = $row['nombre']; // Solo agregamos el nombre
    }
} else {
    $response['departamentos'] = [];
}

// Agregar los datos de departamentos a la respuesta
$response['departamentos'] = $departamentos;
//----------------------------------------------------------FIN EMPLEADO--------------------------------------------------------------------------------//
//----------------------------------------------------------CLIENTE------------------------------------------------------------------------------------//

// Parámetros de búsqueda para clientes
$query_cliente = isset($_GET['q_cliente']) ? $_GET['q_cliente'] : '';
$estado_cuenta = isset($_GET['estado_cuenta']) ? $_GET['estado_cuenta'] : '';

// Consulta base de clientes
$sql_clientes = "SELECT c.nombreCliente, c.apellidoPaterno, c.foto, c.idCliente, con.telefono, con.email 

                 FROM client c
                 LEFT JOIN contactoCliente con ON c.idCliente = con.idCliente
                 WHERE con.idTipoContato = 1
                 AND (c.nombreCliente LIKE '%$query_cliente%' OR c.idCliente LIKE '%$query_cliente%')";

// Añadir filtro de estado de cuenta si está presente
if ($estado_cuenta !== '') {
    $sql_clientes .= " AND c.estadoCuenta = '$estado_cuenta'";
}

$result_clientes = $conn->query($sql_clientes);

// Array para almacenar los datos de clientes
$clientes = array();

if ($result_clientes->num_rows > 0) {
    // Salida de datos de cada fila
    while($row = $result_clientes->fetch_assoc()) {
        // Agregar cada fila como un objeto al array
        $clientes[] = $row;
    }
} else {
    $response['clientes'] = [];
}

// Agregar los datos de clientes a la respuesta
$response['clientes'] = $clientes;

// Consulta para obtener los estados de cuenta distintos
$sql_estados_cuenta = "SELECT DISTINCT estadoCuenta FROM client";
$result_estados_cuenta = $conn->query($sql_estados_cuenta);

// Array para almacenar los estados de cuenta
$estados_cuenta = array();

if ($result_estados_cuenta->num_rows > 0) {
    // Salida de datos de cada fila
    while($row = $result_estados_cuenta->fetch_assoc()) {
        // Agregar cada fila como un objeto al array
        $estados_cuenta[] = $row['estadoCuenta'];
    }
} else {
    $response['estados_cuenta'] = [];
}

// Agregar los datos de estados de cuenta a la respuesta
$response['estados_cuenta'] = $estados_cuenta;

//--------------------------------------------------Fin Cliente------------------------------------------------------------------------------------//
//-------------------------------------------------Proveedor---------------------------------------------------------------------------------------//

// Parámetros de búsqueda para proveedores
$query_proveedor = isset($_GET['q_proveedor']) ? $_GET['q_proveedor'] : '';
$estado_cuentap = isset($_GET['estado_cuentap']) ? $_GET['estado_cuentap'] : '';

// Consulta base de proveedores
$sql_proveedores = "SELECT c.nombreProveedor, c.apellidoPaterno, c.foto, c.idProveedor, c.telefono, c.email, p.estadoProveedor
                 FROM contactoproveedor c
                 LEFT JOIN proveedores p ON c.idProveedor = p.idProveedor
                 WHERE c.idTipoContacto = 1
                 AND (c.nombreProveedor LIKE '%$query_proveedor%' OR c.idProveedor LIKE '%$query_proveedor%')";

// Añadir filtro de estado de cuenta si está presente
if ($estado_cuentap !== '') {
    $sql_proveedores .= " AND p.estadoProveedor = '$estado_cuentap'";
}                

$result_proveedores = $conn->query($sql_proveedores);

// Array para almacenar los datos de proveedores
$proveedores = array();

if ($result_proveedores->num_rows > 0) {
    // Salida de datos de cada fila
    while($row = $result_proveedores->fetch_assoc()) {
        // Agregar cada fila como un objeto al array
        $proveedores[] = $row;
    }
} else {
    $response['proveedores'] = [];
}

// Agregar los datos de clientes a la respuesta
$response['proveedores'] = $proveedores;

// Consulta para obtener los estados de cuenta distintos
$sql_estados_cuentap = "SELECT DISTINCT estadoProveedor FROM proveedores";
$result_estados_cuentap = $conn->query($sql_estados_cuentap);

// Array para almacenar los estados de cuenta
$estados_cuentap = array();

if ($result_estados_cuentap->num_rows > 0) {
    // Salida de datos de cada fila
    while($row = $result_estados_cuentap->fetch_assoc()) {
        // Agregar cada fila como un objeto al array
        $estados_cuentap[] = $row['estadoProveedor'];
    }
} else {
    $response['estados_cuentap'] = [];
}

// Agregar los datos de estados de cuenta a la respuesta
$response['estados_cuentap'] = $estados_cuentap;

//-------------------------------------------------FIN PROVEEDOR----------------------------------------------------------------------------------//

//-------------------------------------------------Gestor de Archivos----------------------------------------------------------------------------//

// Subir archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $filename = $_FILES['file']['name'];
    $filetype = $_FILES['file']['type'];
    $filetmp = $_FILES['file']['tmp_name'];
    $destination = '../uploads/' . $filename;

    if (move_uploaded_file($filetmp, $destination)) {
        $sql = "INSERT INTO archivos (nombre, tipo, ruta) VALUES ('$filename', '$filetype', '$destination')";
        if ($conn->query($sql) === TRUE) {
            $response['upload_status'] = "Archivo subido exitosamente.";
        } else {
            $response['upload_status'] = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $response['upload_status'] = "Error al subir el archivo.";
    }
}

// Listar archivos
$sql_archivos = "SELECT * FROM archivos";
$result_archivos = $conn->query($sql_archivos);

$archivos = array();

if ($result_archivos->num_rows > 0) {
    while($row = $result_archivos->fetch_assoc()) {
        $archivos[] = $row;
    }
} else {
    $response['archivos'] = [];
}

$response['archivos'] = $archivos;

// Eliminar archivo
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "SELECT ruta FROM archivos WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    unlink($row['ruta']);

    $sql = "DELETE FROM archivos WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $response['delete_status'] = "Archivo eliminado exitosamente.";
    } else {
        $response['delete_status'] = "Error: " . $conn->error;
    }
}

// Compartir archivo (esto podría ser un enlace de descarga simple)
if (isset($_GET['share_id'])) {
    $id = $_GET['share_id'];

    $sql = "SELECT ruta FROM archivos WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $response['share_link'] = $row['ruta'];
}

//-------------------------------------------------FIN Gestor de Archivos------------------------------------------------------------------------//

// Convertir el array de respuesta a formato JSON y enviarlo como respuesta
header('Content-Type: application/json');
echo json_encode($response);

// Liberar resultado y cerrar la conexión
if ($result_empleados) $result_empleados->free();
if ($result_departamentos) $result_departamentos->free();
if ($result_clientes) $result_clientes->free();
if ($result_estados_cuenta) $result_estados_cuenta->free();
if ($result_proveedores) $result_proveedores->free();
if ($result_estados_cuentap) $result_estados_cuentap->free();
if ($result_archivos) $result_archivos->free();
$conn->close();
?>
