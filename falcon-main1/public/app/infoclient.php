<?php
require_once '../controller/consultas.php';

// Obtener el idCliente de la URL
$idCliente = isset($_GET['idCliente']) ? $_GET['idCliente'] : '';

if ($idCliente) {
    // Obtener la información del cliente por idCliente
    $cliente = obtenerClientePorId($idCliente);

    // Verificar si hay resultados
    if (!$cliente) {
        // Mensaje de alerta si no hay contactos
        $mensaje = '<div class="alert alert-danger" role="alert">
                      <h4 class="alert-heading fw-semi-bold">Cliente sin contactos</h4>
                      <p>El cliente no tiene contactos registrados.</p>
                      <hr />
                      <p class="mb-0">Aún no se han registrado contactos para este cliente.</p>
                    </div>';
    }
} else {
    // Redirigir a error.php si no se proporciona idCliente
    header('Location: error.php');
    exit();
}

require_once '../share/head.php'; // Incluir el encabezado común de la página
?>

<main class="main" id="top">
    <div class="container" data-layout="container">
        <script>
            var isFluid = JSON.parse(localStorage.getItem('isFluid'));
            if (isFluid) {
                var container = document.querySelector('[data-layout]');
                container.classList.remove('container');
                container.classList.add('container-fluid');
            }
        </script>
        <?php require_once '../share/nav.php'; // Incluir la barra de navegación común ?>
        <div class="content">
            <?php require_once '../share/nav_profile.php'; // Incluir la navegación específica del perfil ?>

            <div class="card-header text-white">
                <h3 class="mb-0">Información Clientes</h3>
            </div>

            <div id="tableExample3" data-list='{"valueNames":["nombre","app","email","tel","tipoContacto"],"page":10,"pagination":true}'>
                <div class="row justify-content-end g-0">
                    <div class="col-auto col-sm-5 mb-3">
                        <form>
                            <div class="input-group">
                                <input class="form-control form-control-sm shadow-none search" type="search" placeholder="Buscar..." aria-label="search" />
                                <div class="input-group-text bg-transparent">
                                    <span class="fa fa-search fs-10 text-600"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-end my-3"></div>
                <div class="table-responsive scrollbar">
                    <?php if (isset($mensaje)): ?>
                        <?php echo $mensaje; ?>
                    <?php else: ?>
                        <table class="table table-bordered table-striped fs-10 mb-0">
                            <thead class="bg-300">
                                <tr>
                                    <th class="text-900 sort" data-sort="nombre">Nombre</th>
                                    <th class="text-900 sort" data-sort="email">Email</th>
                                    <th class="text-900 sort" data-sort="tel">Teléfono</th>
                                    <th class="text-900 sort" data-sort="tipoContacto">Tipo de Contacto</th>
                                    <th class="text-900 sort" data-sort="tipoContacto">HS ATT Semana</th>
                                    <th class="text-900 sort" data-sort="tipoContacto">HS ATT Finsemana</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php foreach ($cliente as $row): ?>
                                <tr>
                                    <td class="align-middle white-space-nowrap nombre">
                                        <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellidoPaterno']); ?>
                                    </td>
                                    <td class="align-middle white-space-nowrap email"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="tel"><?php echo htmlspecialchars($row['telefono']); ?></td>
                                    <td class="tipoContacto"><?php echo htmlspecialchars($row['tipoContacto']); ?></td>
                                    <td class="tipoContacto"><?php echo htmlspecialchars($row['horaAtencionSemana']); ?></td>
                                    <td class="tipoContacto"><?php echo htmlspecialchars($row['horaAtencionFinseman']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-sm btn-falcon-default me-1" type="button" title="Previous" data-list-pagination="prev">
                        <span class="fas fa-chevron-left"></span>
                    </button>
                    <ul class="pagination mb-0"></ul>
                    <button class="btn btn-sm btn-falcon-default ms-1" type="button" title="Next" data-list-pagination="next">
                        <span class="fas fa-chevron-right"></span>
                    </button>
                </div>
            </div>
            <?php require_once '../share/footer.php'; // Incluir el pie de página común ?>
        </div>
    </div>
</main>

<div class="modal fade" id="bulk-select-replace-element" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
    <div class="modal-dialog mt-6" role="document">
        <div class="modal-content border-0">
            <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                    <p class="fs-10 mb-0 text-white">Please create your free Falcon account</p>
                </div>
                <button class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4 px-5">
                <form>
                    <div class="mb-3">
                        <label class="form-label" for="modal-auth-name">Name</label>
                        <input class="form-control" type="text" autocomplete="on" id="modal-auth-name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="modal-auth-email">Email address</label>
                        <input class="form-control" type="email" autocomplete="on" id="modal-auth-email" />
                    </div>
                    <div class="row gx-2">
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="modal-auth-password">Password</label>
                            <input class="form-control" type="password" autocomplete="on" id="modal-auth-password" />
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label class="form-label" for="modal-auth-confirm-password">Confirm Password</label>
                            <input class="form-control" type="password" autocomplete="on" id="modal-auth-confirm-password" />
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox" />
                        <label class="form-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a class="white-space-nowrap" href="#!">privacy policy</a></label>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                    </div>
                </form>
                <div class="position-relative mt-5">
                    <hr />
                    <div class="divider-content-center">or register with</div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-sm-6">
                        <a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../share/btn-config.php'; // Incluir los botones de configuración comunes ?>
