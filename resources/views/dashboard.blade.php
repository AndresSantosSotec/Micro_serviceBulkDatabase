@extends('layouts.app')

@section('content')
    <div class="min-vh-100 bg-light">
        {{-- Header --}}
        <header class="bg-primary text-white py-4">
            <div class="container d-flex align-items-center">
                <i class="fas fa-database me-2" style="font-size: 32px;"></i>
                <h1 class="fs-3 fw-bold">Gestión de Bulk de Datos - Microservicio</h1>
            </div>
        </header>

        <main class="container py-4">
            {{-- Progress Slider --}}
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold"><i class="fas fa-check-circle text-success"></i> Finalizado</span>
                </div>
                <div class="progress mt-2">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="row g-4">
                {{-- Left Column --}}
                <div class="col-md-6">
                    {{-- Upload History --}}
                    <div class="mb-4">
                        <h2 class="fs-4 fw-semibold"><i class="fas fa-history me-2"></i>Historial de Cargas</h2>
                        <table class="table table-hover table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>Fecha y Hora</th>
                                    <th>Ruta del Archivo</th>
                                    <th>Registros</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2023-06-01 14:30</td>
                                    <td>/data/bulk1.csv</td>
                                    <td>1000</td>
                                    <td class="text-success"><i class="fas fa-check-circle"></i> Exitoso</td>
                                </tr>
                                <tr>
                                    <td>2023-06-02 10:15</td>
                                    <td>/data/bulk2.csv</td>
                                    <td>1500</td>
                                    <td class="text-danger"><i class="fas fa-times-circle"></i> Con errores</td>
                                </tr>
                                <tr>
                                    <td>2023-06-03 09:00</td>
                                    <td>s3://mybucket/data.csv</td>
                                    <td>2000</td>
                                    <td class="text-success"><i class="fas fa-check-circle"></i> Exitoso</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Folder Config --}}
                    <div class="mb-4">
                        <h2 class="fs-4 fw-semibold"><i class="fas fa-folder-open me-2"></i>Configuración de Carpeta o
                            Servidor</h2>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="config" id="local" value="local"
                                checked>
                            <label class="form-check-label" for="local"><i class="fas fa-folder"></i> Carpeta
                                Local</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="config" id="aws" value="aws">
                            <label class="form-check-label" for="aws"><i class="fab fa-aws"></i> Bucket AWS</label>
                        </div>

                        {{-- Configuración para Carpeta Local --}}
                        <div id="local-config" class="mt-3">
                            <label for="folder" class="form-label"><i class="fas fa-upload"></i> Seleccionar
                                Archivos</label>
                            <input type="file" class="form-control" id="folder" accept=".xlsx,.xls,.csv" multiple>
                            <small class="text-muted mt-2 d-block">Archivos seleccionados:</small>
                            <textarea class="form-control mt-2" id="folder-path" rows="3" readonly></textarea>
                        </div>

                        {{-- Configuración para Bucket AWS --}}
                        <div id="aws-config" class="mt-3" style="display: none;">
                            <label for="bucket-path" class="form-label"><i class="fas fa-link"></i> Ruta del Bucket</label>
                            <input type="text" class="form-control" id="bucket-path" placeholder="s3://my-bucket/path">

                            <label for="access-key" class="form-label mt-2"><i class="fas fa-key"></i> Llave de
                                Acceso</label>
                            <input type="text" class="form-control" id="access-key">

                            <label for="secret-key" class="form-label mt-2"><i class="fas fa-lock"></i> Llave
                                Secreta</label>
                            <input type="password" class="form-control" id="secret-key">
                        </div>

                        <button class="btn btn-success mt-3" id="save-config" data-config-type="local">
                            <i class="fas fa-save"></i> Guardar Configuración
                        </button>

                    </div>
                </div>

                {{-- Right Column --}}
                <div class="col-md-6">
                    <div class="accordion" id="personalizationAccordion">
                        {{-- Encabezado del acordeón --}}
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="personalizationHeading">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#personalizationCollapse" aria-expanded="true"
                                    aria-controls="personalizationCollapse">
                                    <i class="fas fa-cogs me-2"></i> Personalización
                                </button>
                            </h2>

                            {{-- Contenido del acordeón --}}
                            <div id="personalizationCollapse" class="accordion-collapse collapse show"
                                aria-labelledby="personalizationHeading" data-bs-parent="#personalizationAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="interval" class="form-label"><i class="fas fa-clock"></i> Intervalo
                                            de Ejecución (horas)</label>
                                        <input type="number" class="form-control" id="interval" value="12">
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="email-notifications">
                                        <label class="form-check-label" for="email-notifications"><i
                                                class="fas fa-envelope"></i> Notificaciones por Email</label>
                                    </div>
                                    <button class="btn btn-primary" id='timer'><i class="fas fa-save"></i> Guardar
                                        Personalización</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--secion de designar las columnas--}}
                
        </main>
    </div>

    {{-- SweetAlert Script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- JavaScript para manejar funcionalidad --}}
    <script>
        $(document).ready(function() {
            $('#timer').click(function() {
                // Capturar el valor del intervalo
                const interval = $('#interval').val();

                // Validar que el intervalo no esté vacío o sea negativo
                if (!interval || interval <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en la Configuración',
                        text: 'Por favor, ingresa un intervalo válido (mayor a 0 horas).',
                    });
                    return;
                }

                // Mostrar SweetAlert de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Personalización Guardada',
                    text: `Se ha guardado el intervalo de ejecución de ${interval} horas correctamente.`,
                    confirmButtonText: 'Aceptar'
                });
            });
        });


        $(document).ready(function() {
            // Mostrar/Ocultar configuración según la selección
            $('input[name="config"]').change(function() {
                if ($(this).val() === 'local') {
                    $('#local-config').show();
                    $('#aws-config').hide();
                } else if ($(this).val() === 'aws') {
                    $('#local-config').hide();
                    $('#aws-config').show();
                }
            });

            // Validar archivos seleccionados y mostrar sus nombres
            $('#folder').change(function() {
                const allowedExtensions = ['xlsx', 'xls', 'csv'];
                let fileNames = '';
                let isValid = true;

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
                        const filePath = file.webkitRelativePath || file
                            .name; // Ruta completa o nombre del archivo
                        fileNames += filePath + '\n';
                    }
                });

                if (isValid) {
                    $('#folder-path').val(fileNames.trim()); // Mostrar rutas de archivos seleccionados
                } else {
                    $('#folder').val(''); // Resetear input si hay errores
                    $('#folder-path').val('');
                }
            });

            // Guardar Configuración con SweetAlert
            $('#save-config').click(function() {
                const configType = $('input[name="config"]:checked').val();
                let message = '';
                let isValid = true;

                if (configType === 'local') {
                    if ($('#folder-path').val().trim() === '') {
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
                    const bucketPath = $('#bucket-path').val().trim();
                    const accessKey = $('#access-key').val().trim();
                    const secretKey = $('#secret-key').val().trim();

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
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });
    </script>
@endsection
