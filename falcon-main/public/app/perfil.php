<?php require_once '../share/head.php'; ?>

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

        <?php require_once '../share/nav.php'; ?>

        <div class="content">
            <?php require_once '../share/nav_profile.php'; ?>

            <?php
            require_once '../controller/consultas.php';

            $noEmpleado = isset($_GET['noEmpleado']) ? $_GET['noEmpleado'] : '';

            if ($noEmpleado) {
                $empleado = obtenerEmpleadoPorNumero($noEmpleado);
            } else {
                header('Location: error.php');
                exit();
            }
            ?>

            <div class="container mt-5">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="mb-0">Detalles del <?php echo htmlspecialchars($empleado['nombrerol']); ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <div style="width: 150px; height: 150px; overflow: hidden; border-radius: 50%; border: 4px solid #ccc; margin: 0 auto;">
                                    <img class="rounded-circle" src="<?php echo htmlspecialchars('../img/' . $empleado['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($empleado['nombreEmpleado']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <h5 class="mt-3"><?php echo htmlspecialchars($empleado['nombreEmpleado']); ?></h5>
                                <p class="text-muted"><?php echo htmlspecialchars($empleado['tipoEmpleado']); ?></p>
                            </div>
                            <div class="col-md-9">
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <p><strong>ID Empleado:</strong> <?php echo htmlspecialchars($empleado['idEmpleado']); ?></p>
                                        <p><strong>Email:</strong> <?php echo htmlspecialchars($empleado['emailEmpleado']); ?></p>
                                        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($empleado['telefono']); ?></p>
                                        <p><strong>Fecha de Nacimiento:</strong> <?php echo date('d M Y', strtotime($empleado['fechaNacimiento'])); ?></p>

                                        <p><strong>Género:</strong> <?php echo htmlspecialchars($empleado['genero']); ?></p>
                                        <p><strong>Estado:</strong> <?php echo htmlspecialchars($empleado['estado']); ?></p>
                                        <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($empleado['ciudad']); ?></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Fecha de Contratación:</strong> <?php echo date('d M Y', strtotime($empleado['fechaContratacion'])); ?></p>

                                        <p><strong>Salario:</strong> $ <?php echo number_format($empleado['salario'], 2, '.', ','); ?></p>

                                        <p><strong>No. Empleado:</strong> <?php echo htmlspecialchars($empleado['noEmpleado']); ?></p>
                                        <p><strong>RFC:</strong> <?php echo htmlspecialchars($empleado['rfc']); ?></p>
                                        <p><strong>Número de Seguro Social:</strong> <?php echo htmlspecialchars($empleado['numeroSeguroSocial']); ?></p>
                                        <p><strong>Departamento:</strong> <?php echo htmlspecialchars($empleado['nombre'] ?? 'N/A'); ?></p>
                                        <p><strong>Rol:</strong> <?php echo htmlspecialchars($empleado['nombrerol'] ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($empleado['direccion']); ?></p>
                                        <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($empleado['codigoPostal']); ?></p>
                                        <p><strong>País:</strong> <?php echo htmlspecialchars($empleado['pais']); ?></p>
                                    </div>
                                    <div class="col">
                                        <p><strong>Estado Empleado:</strong> <?php echo htmlspecialchars($empleado['estadoEmpleado']); ?></p>
                                        <p><strong>Tipo Snage:</strong> <?php echo htmlspecialchars($empleado['tipoSnage']); ?></p>
                                        <p><strong>Fecha Última Actividad:</strong> <?php echo htmlspecialchars($empleado['fechaUltimaActividad']); ?></p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <p><strong>Notas:</strong> <?php echo htmlspecialchars($empleado['notas']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php require_once '../share/footer.php'; ?>
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
                    <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                    <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../share/btn-config.php'; ?>