{{-- Configuraciones de Migraciones Asociados --}}
<div class="step-panel" id="step-1" style="display: block;">
    <h2 class="fs-4 fw-semibold">Importar Clientes (Asociados)</h2>
    <p>Seleccione el archivo para cargar datos de clientes. Asegúrese de seguir el formato correcto.</p>
    <button class="btn btn-info mt-3">Columnas para Clientes</button>

    <h2 class="fs-4 fw-semibold"><i class="fas fa-folder-open me-2"></i>Configuración de Carpeta o Servidor</h2>
    <div class="form-check">
        <input class="form-check-input config-radio" type="radio" name="config_step1" id="local_step1" value="local"
            checked>
        <label class="form-check-label" for="local_step1"><i class="fas fa-folder"></i> Carpeta Local</label>
    </div>
    <div class="form-check">
        <input class="form-check-input config-radio" type="radio" name="config_step1" id="aws_step1" value="aws">
        <label class="form-check-label" for="aws_step1"><i class="fab fa-aws"></i> Bucket AWS</label>
    </div>

    {{-- Configuración para Carpeta Local --}}
    <div class="local-config mt-3" id="local-config-step1">
        <label for="manual-path-step1" class="form-label"><i class="fas fa-folder"></i> Ruta de la Carpeta</label>
        <div class="input-group mb-3">
            <input type="text" class="form-control" id="manual-path-step1" placeholder="Ejemplo: C:/mis-datos/clientes/">
            
            <input type="file" class="d-none" id="folder-picker-step1" webkitdirectory>
            <button class="btn btn-primary" id="add-path"><i class="fas fa-plus"></i> Agregar Ruta</button>
        </div>
    
        <label for="folder_step1" class="form-label mt-3"><i class="fas fa-upload"></i> Seleccionar Archivos</label>
        <input type="file" class="form-control folder-input" id="folder_step1" accept=".xlsx,.xls,.csv" multiple>
    
        {{-- Área de texto para mostrar rutas --}}
        <label class="form-label mt-3"><i class="fas fa-list"></i> Rutas Incluidas</label>
        <textarea class="form-control" id="file-paths-step1" rows="5" readonly></textarea>
    </div>
    

    {{-- Configuración para Bucket AWS --}}
    <div class="aws-config mt-3" id="aws-config-step1" style="display: none;">
        <label for="bucket-path-step1" class="form-label"><i class="fas fa-link"></i> Ruta del Bucket</label>
        <input type="text" class="form-control bucket-path" id="bucket-path-step1" placeholder="s3://my-bucket/path">
        <label for="access-key-step1" class="form-label mt-2"><i class="fas fa-key"></i> Llave de Acceso</label>
        <input type="text" class="form-control access-key" id="access-key-step1">
        <label for="secret-key-step1" class="form-label mt-2"><i class="fas fa-lock"></i> Llave Secreta</label>
        <input type="password" class="form-control secret-key" id="secret-key-step1">
    </div>

    <button class="btn btn-success mt-3 save-config" data-step="1"><i class="fas fa-save"></i> Guardar
        Configuración</button>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar cambios entre "Carpeta Local" y "Bucket AWS" en el paso 1
        $('input[name="config_step1"]').change(function() {
            if ($(this).val() === 'local') {
                $('#local-config-step1').show();
                $('#aws-config-step1').hide();
            } else if ($(this).val() === 'aws') {
                $('#local-config-step1').hide();
                $('#aws-config-step1').show();
            }
        });

        // Función para agregar ruta manual al área de texto
        $('#add-path').click(function() {
            const manualPath = $('#manual-path-step1').val().trim(); // Obtener la ruta manual
            if (!manualPath) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ruta no especificada',
                    text: 'Por favor, ingresa una ruta válida.',
                });
                return;
            }

            // Agregar la ruta al área de texto
            const currentPaths = $('#file-paths-step1').val();
            const newPaths = currentPaths ? `${currentPaths}\n${manualPath}` : manualPath;
            $('#file-paths-step1').val(newPaths.trim());
            $('#manual-path-step1').val(''); // Limpiar el input
        });

        // Validar archivos seleccionados y combinar con rutas para el paso 1
        $('#folder_step1').change(function() {
            const allowedExtensions = ['xlsx', 'xls', 'csv'];
            const manualPath = $('#manual-path-step1').val().trim();
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
                        text: `El archivo ${file.name} no es un archivo válido.`,
                    });
                } else {
                    const fullPath = manualPath.endsWith('/') ? `${manualPath}${file.name}` : `${manualPath}/${file.name}`;
                    filePaths += `${fullPath}\n`;
                }
            });

            if (isValid) {
                // Mostrar rutas completas de los archivos seleccionados en el área de texto
                const currentPaths = $('#file-paths-step1').val();
                const newPaths = currentPaths ? `${currentPaths}\n${filePaths.trim()}` : filePaths.trim();
                $('#file-paths-step1').val(newPaths);
            } else {
                // Limpiar el input si hay errores
                $('#folder_step1').val('');
            }
        });

        // Guardar configuración del paso 1
        $('.save-config[data-step="1"]').click(function() {
            const configType = $('input[name="config_step1"]:checked').val();
            let message = '';
            let isValid = true;

            if (configType === 'local') {
                const filePaths = $('#file-paths-step1').val().trim();
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
                const bucketPath = $('#bucket-path-step1').val().trim();
                const accessKey = $('#access-key-step1').val().trim();
                const secretKey = $('#secret-key-step1').val().trim();

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