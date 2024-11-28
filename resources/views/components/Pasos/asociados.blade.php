{{-- configuicaiones de Migraciones Asociados --}}
{{-- Paso 1: Clientes --}}
{{-- Paso 1 --}}
<div class="step-panel" id="step-1" style="display: block;">
    <h2 class="fs-4 fw-semibold">Importar Clientes (Asociados)</h2>
    <p>Seleccione el archivo para cargar datos de clientes. Asegúrese de seguir el formato correcto.</p>
    <button class="btn btn-info mt-3">Columnas para Clientes</button>
    <h2 class="fs-4 fw-semibold"><i class="fas fa-folder-open me-2"></i>Configuración de Carpeta o Servidor</h2>
    <div class="form-check">
        <input class="form-check-input config-radio" type="radio" name="config_step1" id="local_step1" value="local" checked>
        <label class="form-check-label" for="local_step1"><i class="fas fa-folder"></i> Carpeta Local</label>
    </div>
    <div class="form-check">
        <input class="form-check-input config-radio" type="radio" name="config_step1" id="aws_step1" value="aws">
        <label class="form-check-label" for="aws_step1"><i class="fab fa-aws"></i> Bucket AWS</label>
    </div>
    <div class="local-config mt-3" id="local-config-step1">
        <label for="folder_step1" class="form-label"><i class="fas fa-upload"></i> Seleccionar Archivos</label>
        <input type="file" class="form-control folder-input" id="folder_step1" accept=".xlsx,.xls,.csv" multiple>
    </div>
    <div class="aws-config mt-3" id="aws-config-step1" style="display: none;">
        <label for="bucket-path-step1" class="form-label"><i class="fas fa-link"></i> Ruta del Bucket</label>
        <input type="text" class="form-control bucket-path" id="bucket-path-step1" placeholder="s3://my-bucket/path">
        <label for="access-key-step1" class="form-label mt-2"><i class="fas fa-key"></i> Llave de Acceso</label>
        <input type="text" class="form-control access-key" id="access-key-step1">
        <label for="secret-key-step1" class="form-label mt-2"><i class="fas fa-lock"></i> Llave Secreta</label>
        <input type="password" class="form-control secret-key" id="secret-key-step1">
    </div>
    <button class="btn btn-success mt-3 save-config" data-step="1"><i class="fas fa-save"></i> Guardar Configuración</button>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar cambios entre "Carpeta Local" y "Bucket AWS" en el paso 1
        $('input[name="config_step1"]').change(function() {
            if ($(this).val() === 'local') {
                $('#local-config-step1').show(); // Mostrar configuración de carpeta local
                $('#aws-config-step1').hide(); // Ocultar configuración de bucket AWS
            } else if ($(this).val() === 'aws') {
                $('#local-config-step1').hide(); // Ocultar configuración de carpeta local
                $('#aws-config-step1').show(); // Mostrar configuración de bucket AWS
            }
        });

        // Validar archivos seleccionados y mostrar sus nombres para el paso 1
        $('#folder_step1').change(function() {
            const allowedExtensions = ['xlsx', 'xls', 'csv'];
            let fileNames = '';
            let isValid = true;

            // Validar extensión de archivos seleccionados
            Array.from($(this)[0].files).forEach(file => {
                const extension = file.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(extension)) {
                    isValid = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Archivo no válido',
                        text: `El archivo ${file.name} no es un archivo de Excel válido.`,
                    });
                } else {
                    fileNames += file.name + '\n'; // Agregar el nombre del archivo
                }
            });

            if (isValid) {
                // Mostrar nombres de los archivos seleccionados
                alert('Archivos seleccionados: \n' + fileNames.trim());
            } else {
                // Limpiar el input si hay errores
                $('#folder_step1').val('');
            }
        });

        // Guardar configuración del paso 1
        $('#save-config-step1').click(function() {
            const configType = $('input[name="config_step1"]:checked')
        .val(); // Tipo de configuración seleccionado
            let message = '';
            let isValid = true;

            if (configType === 'local') {
                // Validar si hay archivos seleccionados para la carpeta local
                const filesSelected = $('#folder_step1').val();
                if (!filesSelected) {
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
                // Validar los campos necesarios para el bucket AWS
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

            // Mostrar mensaje de éxito si la validación pasa
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
