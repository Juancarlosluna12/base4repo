document.addEventListener('DOMContentLoaded', () => {
    cargarDatosClientes();

    document.getElementById('search-client-input').addEventListener('keyup', event => {
        if (event.key === 'Enter') {
            cargarDatosClientes();
        }
    });

    document.getElementById('filter-client-cuenta').addEventListener('change', () => {
        cargarDatosClientes();
    });

    // Evento para mostrar todos los clientes
    document.getElementById('show-all-button').addEventListener('click', () => {
        document.getElementById('search-client-input').value = '';
        document.getElementById('filter-client-cuenta').value = ''; // Corregido el ID del filtro
        cargarDatosClientes();
    });
});

function cargarDatosClientes() {
    const query = document.getElementById('search-client-input').value;
    const estadoCuenta = document.getElementById('filter-client-cuenta').value;

    fetch(`../php/consultas.php?q_cliente=${query}&estado_cuenta=${estadoCuenta}`)
        .then(response => response.json())
        .then(data => {
            const clientesBody = document.getElementById('clientesBody');
            clientesBody.innerHTML = '';

            if (data.clientes.length === 0) {
                clientesBody.innerHTML = '<tr><td colspan="4" class="text-center">No se encontraron clientes.</td></tr>';
            } else {
                data.clientes.forEach(cliente => {
                    const fotoUrl = `../imagenes/${cliente.foto}`;
                    const row = `
                        <tr>
                            <td>
                                <img src="${fotoUrl}" alt="Foto de ${cliente.nombreCliente}" class="cliente-foto">
                            </td>
                            <td>${cliente.nombreCliente} ${cliente.apellidoPaterno}</td>
                            <td>${cliente.idCliente}</td>
                            <td>${cliente.telefono}</td>
                            <td>${cliente.email}</td>
                            

                        </tr>`;
                    clientesBody.innerHTML += row;
                });
            }

            const filterClientCuenta = document.getElementById('filter-client-cuenta');
            filterClientCuenta.innerHTML = '<option value="">Filtrar por estado de cuenta</option>';

            data.estados_cuenta.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado;
                option.textContent = estado;
                filterClientCuenta.appendChild(option);
            });
        })
        .catch(error => console.error('Error al cargar los clientes:', error));
}
