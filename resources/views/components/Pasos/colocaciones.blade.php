{{-- Colocaciones config --}}
<div class="step-panel" id="step-3" style="display: none;">
    <h2 class="fs-4 fw-semibold">Importar Colocaciones (Créditos)</h2>
    <p>Seleccione el archivo para cargar datos de colocaciones. Asegúrese de seguir el formato correcto.</p>
    <button class="btn btn-info mt-3">Columnas para Colocaciones</button>

    <h2 class="fs-4 fw-semibold"><i class="fas fa-folder-open me-2"></i>Configuración de Carpeta o Servidor</h2>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="config_step3" id="local_step3" value="local" checked>
        <label class="form-check-label" for="local_step3"><i class="fas fa-folder"></i> Carpeta Local</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="config_step3" id="aws_step3" value="aws">
        <label class="form-check-label" for="aws_step3"><i class="fab fa-aws"></i> Bucket AWS</label>
    </div>

    {{-- Configuración para Carpeta Local --}}
    <div id="local-config-step3" class="mt-3">
        <label for="manual-path-step3" class="form-label"><i class="fas fa-folder"></i> Ruta Manual</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="manual-path-step3"
                placeholder="Ejemplo: C:/mis-datos/colocaciones/">
            <input type="file" class="d-none" id="folder-picker-step3" webkitdirectory>
            <button class="btn btn-primary" id="add-path-step3"><i class="fas fa-plus"></i> Agregar Ruta</button>
        </div>

        <label for="folder_step3" class="form-label mt-3"><i class="fas fa-upload"></i> Seleccionar Archivos</label>
        <input type="file" class="form-control" id="folder_step3" accept=".xlsx,.xls,.csv" multiple>

        <label class="form-label mt-3"><i class="fas fa-list"></i> Rutas Incluidas</label>
        <textarea class="form-control" id="file-paths-step3" rows="5" readonly></textarea>
    </div>

    {{-- Configuración para Bucket AWS --}}
    <div id="aws-config-step3" class="mt-3" style="display: none;">
        <label for="bucket-path-step3" class="form-label"><i class="fas fa-link"></i> Ruta del Bucket</label>
        <input type="text" class="form-control" id="bucket-path-step3" placeholder="s3://my-bucket/path">
        <label for="access-key-step3" class="form-label mt-2"><i class="fas fa-key"></i> Llave de Acceso</label>
        <input type="text" class="form-control" id="access-key-step3">
        <label for="secret-key-step3" class="form-label mt-2"><i class="fas fa-lock"></i> Llave Secreta</label>
        <input type="password" class="form-control" id="secret-key-step3">
    </div>

    <button class="btn btn-success mt-3 save-config" data-step="3"><i class="fas fa-save"></i> Guardar
        Configuración</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cambiar entre local y AWS en Colocaciones
        $('input[name="config_step3"]').change(function() {
            if ($(this).val() === 'local') {
                $('#local-config-step3').show();
                $('#aws-config-step3').hide();
            } else if ($(this).val() === 'aws') {
                $('#local-config-step3').hide();
                $('#aws-config-step3').show();
            }
        });

        // Agregar ruta manual al área de texto en Colocaciones
        $('#add-path-step3').click(function() {
            const manualPath = $('#manual-path-step3').val().trim();
            if (!manualPath) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ruta no especificada',
                    text: 'Por favor, ingresa una ruta válida.',
                });
                return;
            }
            const currentPaths = $('#file-paths-step3').val();
            const newPaths = currentPaths ? `${currentPaths}\n${manualPath}` : manualPath;
            $('#file-paths-step3').val(newPaths.trim());
            $('#manual-path-step3').val('');
        });

        // Validar archivos seleccionados y combinar rutas en Colocaciones
        $('#folder_step3').change(function() {
            const allowedExtensions = ['xlsx', 'xls', 'csv'];
            let filePaths = '';
            let isValid = true;

            Array.from(this.files).forEach(file => {
                const extension = file.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(extension)) {
                    isValid = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Archivo no válido',
                        text: `El archivo ${file.name} no es un archivo válido.`,
                    });
                } else {
                    filePaths += `${file.name}\n`;
                }
            });

            if (isValid) {
                const currentPaths = $('#file-paths-step3').val();
                const newPaths = currentPaths ? `${currentPaths}\n${filePaths.trim()}` : filePaths
                .trim();
                $('#file-paths-step3').val(newPaths);
            } else {
                $('#folder_step3').val('');
            }
        });

        // Guardar configuración en Colocaciones
        $('.save-config[data-step="3"]').click(function() {
            const configType = $('input[name="config_step3"]:checked').val();
            let message = '';
            let isValid = true;

            if (configType === 'local') {
                const filePaths = $('#file-paths-step3').val().trim();
                if (!filePaths) {
                    isValid = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sin Archivos o Rutas',
                        text: 'No has incluido ninguna ruta ni archivo.',
                    });
                } else {
                    message = 'Se ha guardado la configuración de la carpeta local correctamente.';
                }
            } else if (configType === 'aws') {
                const bucketPath = $('#bucket-path-step3').val().trim();
                const accessKey = $('#access-key-step3').val().trim();
                const secretKey = $('#secret-key-step3').val().trim();

                if (!bucketPath || !accessKey || !secretKey) {
                    isValid = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos incompletos',
                        text: 'Por favor, completa todos los campos del Bucket AWS antes de guardar.',
                    });
                } else {
                    message = 'Se ha guardado la configuración del bucket AWS correctamente.';
                }
            }

            if (isValid) {
                Swal.fire({
                    icon: 'success',
                    title: 'Configuración Guardada',
                    text: message,
                    confirmButtonText: 'Aceptar',
                });
            }
        });
    });
</script>
