<?php
require_once '../share/head.php';
?>
<main class="main" id="top">
    <div class="container">
        <?php
        require_once '../share/nav.php';
        ?>
        <div class="content">
            <?php
            require_once '../share/nav_profile.php';
            require_once '../controller/consultas.php';

            // Handle file upload
            $upload_status = '';
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
                $upload_status = subirArchivo($_FILES['file']);
            }

            // Handle file deletion
            $delete_status = '';
            if (isset($_POST['delete_id'])) {
                $delete_status = eliminarArchivo($_POST['delete_id']);
            }

            // Get file list
            $archivos = obtenerArchivos();
            ?>

            <div class="container">
                <h2 id="file-manager-title">Gestor de Archivos</h2>
                <form id="file-upload-form" enctype="multipart/form-data" method="POST" action="">
                    <div class="mb-3">
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Subir Archivo</button>
                    <p id="upload-status"><?php echo $upload_status; ?></p>
                </form>

                <?php if (!empty($delete_status)): ?>
                    <div class="alert alert-info"><?php echo $delete_status; ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table id="file-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Fecha de Subida</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="file-table-body">
                            <?php foreach ($archivos as $archivo) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($archivo['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($archivo['tipo']); ?></td>
                                    <td><?php echo htmlspecialchars($archivo['fecha_subida']); ?></td>
                                    <td class="file-action-buttons">
                                        <form action="archivos.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="download" value="<?php echo htmlspecialchars($archivo['ruta']); ?>">
                                            <button type="submit" class="btn btn-sm btn-secondary">Descargar</button>
                                        </form>
                                        <form action="archivos.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="print" value="<?php echo htmlspecialchars($archivo['ruta']); ?>">
                                            <button type="submit" class="btn btn-sm btn-secondary">Imprimir</button>
                                        </form>
                                        <form action="archivos.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($archivo['id']); ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            // Handle file download
            if (isset($_POST['download'])) {
                $filePath = $_POST['download'];
                if (file_exists($filePath)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($filePath));
                    readfile($filePath);
                    exit;
                }
            }

            // Handle file printing
            if (isset($_POST['print'])) {
                $filePath = $_POST['print'];
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                if ($extension === 'pdf') {
                    echo "<iframe src='$filePath' style='display:none;' onload='this.contentWindow.print();'></iframe>";
                } else {
                    echo "<script>
                    var printWindow = window.open('$filePath', '_blank');
                    printWindow.onload = function() {
                        printWindow.print();
                    };
                    </script>";
                }
            }
            ?>

            <?php
            require_once '../share/footer.php';
            ?>
        </div>
    </div>
</main>

<?php
require_once '../share/btn-config.php';
?>
