<?php
require_once '../share/head.php';
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
        <?php
        require_once '../share/nav.php';
        ?>
        <div class="content">
            <?php
            require_once '../share/nav_profile.php';
            ?>
            <div class="card-header text-white">
                <h3 class="mb-0">Directorio de Proveedores</h3>
            </div>
            <div id="tableExample3" data-list='{"valueNames":["nombre","direccion","sitweb","rfc","tel","email"],"page":10,"pagination":true}'>
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
                <div class="d-flex align-items-center justify-content-end my-3">

                </div>
                <div class="table-responsive scrollbar">
                    <table class="table table-bordered table-striped fs-10 mb-0">
                        <thead class="bg-300">
                            <tr>
                                <th class="text-900 sort">Logo</th>
                                <th class="text-900 sort" data-sort="nombre">Nombre</th>
                                <th class="text-900 sort" data-sort="direccion">Dirección</th>
                                <th class="text-900 sort" data-sort="sitweb">Sitio web</th>
                                <th class="text-900 sort" data-sort="rfc">RFC</th>
                                <th class="text-900 sort" data-sort="tel">Teléfono</th>
                                <th class="text-900 sort" data-sort="email">Email</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            <?php
                            require_once '../controller/consultas.php';
                            $proveedores = obtenerProveedor();

                            if (!empty($proveedores)) {
                                foreach ($proveedores as $proveedor) {
                            ?>
                                    <tr>
                                        <td class="align-middle white-space-nowrap"><?php echo htmlspecialchars($proveedor['logo']); ?></td>
                                        <td class="align-middle white-space-nowrap nombre">
    <a href="infoprovee.php?idProveedor=<?php echo htmlspecialchars($proveedor['idProveedor']); ?>">
        <?php echo htmlspecialchars($proveedor['nombreEmpresa']); ?>
    </a>
</td>

                                        <td class="align-middle white-space-nowrap direccion"><?php echo htmlspecialchars($proveedor['direccionProveedor']); ?></td>
                                        <td class="sitweb"><?php echo htmlspecialchars($proveedor['sitioWeb']); ?></td>
                                        <td class="rfc"><?php echo htmlspecialchars($proveedor['rfc']); ?></td>
                                        <td class="tel"><?php echo htmlspecialchars($proveedor['telefono']); ?></td>
                                        <td class="email"><?php echo htmlspecialchars($proveedor['email']); ?></td>
                                        
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No se encontraron registros.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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
            <?php
            require_once '../share/footer.php';
            ?>
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
                        <label class="form-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms</a> and <a class="white-space-nowrap" href="#!">privacy policy</a></label>
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

<?php
require_once '../share/btn-config.php';
?>
