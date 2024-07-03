document.addEventListener('DOMContentLoaded', () => {
    cargarDatosProveedores();

    document.getElementById('search-proveedores-input').addEventListener('keyup', event => {
        if (event.key === 'Enter') {
            cargarDatosProveedores();
        }
    });

    document.getElementById('filter-proveedores-cuenta').addEventListener('change', () => {
        cargarDatosProveedores();
    });

    // Evento para mostrar todos los proveedores
    document.getElementById('show-all-button').addEventListener('click', () => {
        document.getElementById('search-proveedores-input').value = '';
        document.getElementById('filter-proveedores-cuenta').value = ''; // Corregido el ID del filtro
        cargarDatosProveedores();
    });
});

function cargarDatosProveedores() {
    const query = document.getElementById('search-proveedores-input').value;
    const estadoCuenta = document.getElementById('filter-proveedores-cuenta').value;

    fetch(`../php/consultas.php?q_proveedor=${query}&estado_cuentap=${estadoCuenta}`)
        .then(response => response.json())
        .then(data => {
            const proveedoresBody = document.getElementById('proveedoresBody');
            proveedoresBody.innerHTML = '';

            if (data.proveedores.length === 0) {
                proveedoresBody.innerHTML = '<tr><td colspan="4" class="text-center">No se encontraron proveedores.</td></tr>';
            } else {
                data.proveedores.forEach(proveedor => {
                    const fotoUrl = `../imagenes/${proveedor.foto}`;
                    const row = `
                        <tr>
                            <td>
                                <img src="${fotoUrl}" alt="Foto de ${proveedor.nombreProveedor}" class="proveedor-foto">
                            </td>
                            <td>${proveedor.nombreProveedor} ${proveedor.apellidoPaterno}</td>
                            <td>${proveedor.idProveedor}</td>
                            <td>${proveedor.telefono}</td>
                            <td>${proveedor.email}</td>
                        </tr>`;
                    proveedoresBody.innerHTML += row;
                });
            }

            const filterProveedorCuenta = document.getElementById('filter-proveedores-cuenta');
            filterProveedorCuenta.innerHTML = '<option value="">Filtrar por estado de cuenta</option>';

            data.estados_cuentap.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado;
                option.textContent = estado;
                filterProveedorCuenta.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar los proveedores:', error));
}
