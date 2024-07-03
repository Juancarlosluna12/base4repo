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
