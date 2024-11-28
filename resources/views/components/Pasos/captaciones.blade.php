{{-- Configuración para las migraciones de las captaciones --}}
<div class="step-panel" id="step-2" style="display: none;">
    <h2 class="fs-4 fw-semibold">Importar Captaciones (Ahorro)</h2>
    <p>Seleccione el archivo para cargar datos de captaciones. Asegúrese de seguir el formato correcto.</p>
    <button class="btn btn-info mt-3">Columnas para Captaciones</button>

    {{-- Configuración de Carpeta o Servidor --}}
    <h2 class="fs-4 fw-semibold"><i class="fas fa-folder-open me-2"></i>Configuración de Carpeta o Servidor</h2>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="config_step2" id="local_step2" value="local" checked>
        <label class="form-check-label" for="local_step2"><i class="fas fa-folder"></i> Carpeta Local</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="config_step2" id="aws_step2" value="aws">
        <label class="form-check-label" for="aws_step2"><i class="fab fa-aws"></i> Bucket AWS</label>
    </div>

    {{-- Configuración para Carpeta Local --}}
    <div id="local-config-step2" class="mt-3">
        <label for="manual-path-step2" class="form-label"><i class="fas fa-folder"></i> Ruta Manual (Opcional)</label>
        <input type="text" class="form-control" id="manual-path-step2" placeholder="Ejemplo: C:/mis-datos/captaciones/">
        
        <label for="folder_step2" class="form-label mt-3"><i class="fas fa-upload"></i> Seleccionar Archivos</label>
        <input type="file" class="form-control" id="folder_step2" accept=".xlsx,.xls,.csv" multiple>
        <textarea id="file-paths-step2" class="form-control mt-3" rows="4" readonly></textarea>
    </div>

    {{-- Configuración para Bucket AWS --}}
    <div id="aws-config-step2" class="mt-3" style="display: none;">
        <label for="bucket-path-step2" class="form-label"><i class="fas fa-link"></i> Ruta del Bucket</label>
        <input type="text" class="form-control" id="bucket-path-step2" placeholder="s3://my-bucket/path">
        <label for="access-key-step2" class="form-label mt-2"><i class="fas fa-key"></i> Llave de Acceso</label>
        <input type="text" class="form-control" id="access-key-step2">
        <label for="secret-key-step2" class="form-label mt-2"><i class="fas fa-lock"></i> Llave Secreta</label>
        <input type="password" class="form-control" id="secret-key-step2">
    </div>

    <button class="btn btn-success mt-3 save-config" data-step="2">
        <i class="fas fa-save"></i> Guardar Configuración
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Manejar cambios entre "Carpeta Local" y "Bucket AWS" en el paso 2
        $('input[name="config_step2"]').change(function () {
            if ($(this).val() === 'local') {
                $('#local-config-step2').show();
                $('#aws-config-step2').hide();
            } else if ($(this).val() === 'aws') {
                $('#local-config-step2').hide();
                $('#aws-config-step2').show();
            }
        });

        // Validar archivos seleccionados y mostrar rutas completas
        $('#folder_step2').change(function () {
            const allowedExtensions = ['xlsx', 'xls', 'csv'];
            const manualPath = $('#manual-path-step2').val().trim(); // Obtener la ruta manual si existe
            let filePaths = '';
            let isValid = true;

            // Procesar archivos seleccionados
            Array.from(this.files).forEach(file => {
                const extension = file.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(extension)) {
                    isValid = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Archivo no válido',
                        text: `El archivo ${file.name} no es un archivo de Excel válido.`,
                    });
                } else {
                    const fileName = file.name;
                    const fullPath = manualPath ? `${manualPath}/${fileName}` : fileName;
                    filePaths += `${fullPath}\n`; // Agregar ruta completa o solo nombre del archivo
                }
            });

            if (isValid) {
                // Mostrar las rutas completas en el textarea
                $('#file-paths-step2').val(filePaths.trim());
            } else {
                // Limpiar input y textarea si hay errores
                $('#folder_step2').val('');
                $('#file-paths-step2').val('');
            }
        });

        // Guardar configuración del paso 2
        $('.save-config[data-step="2"]').click(function () {
            const configType = $('input[name="config_step2"]:checked').val(); // Tipo de configuración seleccionado
            let message = '';
            let isValid = true;

            if (configType === 'local') {
                const filePaths = $('#file-paths-step2').val().trim();
                if (!filePaths) {
                    isValid = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Sin Archivos',
                        text: 'No has seleccionado ningún archivo para la carpeta local.',
                    });
                } else {
                    message = 'Se ha guardado la configuración de la carpeta local correctamente.';
                }
            } else if (configType === 'aws') {
                const bucketPath = $('#bucket-path-step2').val().trim();
                const accessKey = $('#access-key-step2').val().trim();
                const secretKey = $('#secret-key-step2').val().trim();

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
