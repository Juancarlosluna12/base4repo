<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio de Empleados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/estilo.css"> <!-- Tu archivo de estilos personalizado -->
</head>
<body>
    <div class="container">
        <h1 class="my-4">Directorio de Empleados</h1>
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Buscar por nombre o #empleado">
            <button id="search-button" class="btn btn-primary"><i class="fas fa-search"></i></button>
            <div class="filter-container">
                <select id="filter-select">
                    <option value="">Filtrar por área</option>
                    <!-- Opciones de filtro se cargarán dinámicamente -->
                </select>
            </div>
            
        </div>
        <div id="empleadosBody" class="row">
            <!-- Aquí se insertarán las tarjetas de empleados mediante JavaScript -->
            <?php
            // Aquí se podría incluir código PHP para generar dinámicamente las tarjetas de empleados
            // Por ejemplo:
            /*
            foreach ($empleados as $empleado) {
                echo '<div class="col-md-6 col-lg-4">';
                echo '<div class="empleado-card">';
                echo '<img src="../imagenes/' . $empleado['foto'] . '" alt="Foto de ' . $empleado['nombreEmpleado'] . '" class="empleado-foto" width="60" height="60">';
                echo '<div class="empleado-info">';
                echo '<div class="empleado-nombre">' . $empleado['nombreEmpleado'] . ' ' . $empleado['apellidoPaterno'] . '</div>';
                echo '<div class="empleado-id"><i class="fas fa-id-badge"></i> #' . $empleado['noEmpleado'] . '</div>';
                echo '<div class="empleado-rol">' . $empleado['nombreRol'] . ' - ' . $empleado['nombreDepartamento'] . '</div>';
                echo '<div class="empleado-contacto"><i class="fas fa-phone"></i> ' . $empleado['telefono'] . '</div>';
                echo '<div class="empleado-correo"><i class="fas fa-envelope"></i> ' . $empleado['emailEmpleado'] . '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            */
            ?>
        </div>
        <button id="show-all-button" class="btn btn-secondary">Mostrar todos</button>
        <div id="error-message" class="alert alert-danger d-none" role="alert">
            Error al cargar los empleados.
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+pbYlTcr1ZdUZBhqz1PqKRdkY6OEU27xfoB" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search-input');
            const empleadosBody = document.getElementById('empleadosBody');
            const filterSelect = document.getElementById('filter-select');

            function cargarEmpleados(query = '', area = '') {
                fetch(`../php/consultas.php?q=${query}&area=${area}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        empleadosBody.innerHTML = ''; // Limpiamos el cuerpo antes de agregar nuevas tarjetas

                        // Actualizar el select de filtro
                        filterSelect.innerHTML = '<option value="">Filtrar por área</option>';
                        data.departamentos.forEach(departamento => {
                            const option = document.createElement('option');
                            option.value = departamento;
                            option.text = departamento;
                            filterSelect.appendChild(option);
                        });

                        // Mostrar empleados
                        if (data.empleados.length === 0) {
                            empleadosBody.innerHTML = '<div class="col-12"><p class="text-center">No se encontraron empleados.</p></div>';
                            return;
                        }

                        data.empleados.forEach(empleado => {
                            const fotoUrl = `../imagenes/${empleado.foto}`;
                            const card = `
                                <div class="col-md-6 col-lg-4">
                                    <div class="empleado-card">
                                        <img src="${fotoUrl}" alt="Foto de ${empleado.nombreEmpleado}" class="empleado-foto" width="60" height="60">
                                        <div class="empleado-info">
                                            <div class="empleado-nombre">${empleado.nombreEmpleado} ${empleado.apellidoPaterno}</div>
                                            <div class="empleado-id"><i class="fas fa-id-badge"></i> #${empleado.noEmpleado}</div>
                                            <div class="empleado-rol">${empleado.nombreRol} - ${empleado.nombreDepartamento}</div>
                                            <div class="empleado-contacto"><i class="fas fa-phone"></i> ${empleado.telefono}</div>
                                            <div class="empleado-correo"><i class="fas fa-envelope"></i> ${empleado.emailEmpleado}</div>
                                        </div>
                                    </div>
                                </div>`;
                            empleadosBody.innerHTML += card;
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar los empleados:', error);
                        document.getElementById('error-message').classList.remove('d-none');
                    });
            }

            // Evento de búsqueda en tiempo real
            searchInput.addEventListener('input', () => {
                const query = searchInput.value;
                cargarEmpleados(query);
            });

            // Evento de filtro
            filterSelect.addEventListener('change', (event) => {
                const area = event.target.value;
                cargarEmpleados('', area);
            });

            // Evento para mostrar todos los empleados
            document.getElementById('show-all-button').addEventListener('click', () => {
                searchInput.value = '';
                filterSelect.value = '';
                cargarEmpleados();
            });

            // Cargar empleados al iniciar
            cargarEmpleados();
        });
    </script>
</body>
</html>
