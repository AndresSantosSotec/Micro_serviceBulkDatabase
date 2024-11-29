@extends('layouts.app')


@section('content')
    <style>
        @media (max-width: 768px) {
            #personalization-container {
                margin-top: 20px;
            }

            #dynamic-personalization {
                overflow-x: auto;
                /* Permitir desplazamiento horizontal si el contenido es demasiado ancho */
            }
        }

        #dynamic-personalization p {
            word-wrap: break-word;
            /* Ajustar texto largo para evitar desbordes */
        }
    </style>
    <div class="min-vh-100 bg-light">
        {{-- Header --}}
        <header class="bg-primary text-white py-4">
            <div class="container d-flex align-items-center">
                <i class="fas fa-database me-2" style="font-size: 32px;"></i>
                <h1 class="fs-3 fw-bold">Gestión de Bulk de Datos - Microservicio</h1>
            </div>
        </header>

        <main class="container py-4">

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
                        <table class="table table-hover table-striped align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Nombre del Archivo</th>
                                    <th scope="col">Metadatos</th>
                                    <th scope="col">Ruta del Archivo</th>
                                    <th scope="col">Fecha y Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Las filas serán cargadas dinámicamente aquí -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-4 text-center">
                        <button class="btn btn-primary mx-2 step-btn" data-step="1">Paso 1</button>
                        <button class="btn btn-secondary mx-2 step-btn" data-step="2">Paso 2</button>
                        <button class="btn btn-secondary mx-2 step-btn" data-step="3">Paso 3</button>
                    </div>
                    <div id="step-content">
                        {{-- Paso 1: Clientes --}}
                        <div class="step-panel" id="step-1" style="display: block;">
                            @include('components.pasos.asociados')
                        </div>

                        {{-- Paso 2: Captaciones --}}
                        <div class="step-panel" id="step-2" style="display: none;">
                            @include('components.pasos.captaciones')
                        </div>

                        {{-- Paso 3: Colocaciones --}}
                        <div class="step-panel" id="step-3" style="display: none;">
                            @include('components.pasos.colocaciones')
                        </div>
                    </div>

                </div>

                {{-- Right Column --}}
                <div class="col-md-6">
                    <div id="personalization-container" class="accordion">
                        {{-- Contenedor Responsivo --}}
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Personalización Dinámica</h5>
                            </div>
                            <div class="card-body">
                                <div id="dynamic-personalization">
                                    @if (View::exists('components.Personalizacion.PerAso'))
                                        @include('components.Personalizacion.PerAso')
                                    @else
                                        <p class="text-danger">Error: La vista Personalizacion.PerAso no existe.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
    </div>

    {{-- SweetAlert Script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- JavaScript para manejar funcionalidad --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stepButtons = document.querySelectorAll('.step-btn'); // Botones para cambiar de paso
            const dynamicContainer = document.getElementById('dynamic-personalization'); // Contenedor dinámico
            const tableBody = document.querySelector('.table tbody'); // Cuerpo de la tabla para historial
    
            // --- Función para manejar vistas dinámicas ---
            function loadDynamicView(step) {
                let componentName;
                // Asignar el componente basado en el paso seleccionado
                switch (step) {
                    case '1':
                        componentName = 'PerAso'; // Personalización Asociados
                        break;
                    case '2':
                        componentName = 'PerCap'; // Personalización Captaciones
                        break;
                    case '3':
                        componentName = 'PerColo'; // Personalización Colocaciones
                        break;
                    default:
                        console.error('Paso no válido seleccionado');
                        return;
                }
    
                // Cargar la vista dinámica del servidor
                fetch(`/loadPersonalization/${componentName}`)
                    .then((response) => {
                        if (!response.ok) throw new Error('Error al cargar el componente.');
                        return response.text();
                    })
                    .then((html) => {
                        dynamicContainer.innerHTML = html; // Insertar contenido dinámico en el contenedor
                        initializePersonalization(componentName); // Inicializar personalización después de cargar la vista
                    })
                    .catch((error) => {
                        console.error('Error al cargar la personalización:', error);
                        dynamicContainer.innerHTML = '<p>Error al cargar el contenido dinámico.</p>';
                    });
            }
    
            // --- Función para cargar los datos de las tablas ---
            function loadCargas(step) {
                // Realizar solicitud para obtener los datos del historial basado en el paso
                fetch(`/cargas/${step}`)
                    .then((response) => {
                        if (!response.ok) throw new Error('Error al recuperar los datos');
                        return response.json();
                    })
                    .then((data) => {
                        tableBody.innerHTML = ''; // Limpiar la tabla
                        if (data.length > 0) {
                            // Poblar la tabla con los datos recibidos
                            data.forEach((carga) => {
                                const row = `
                                    <tr>
                                        <td>${carga.nombre_archivo}</td>
                                        <td>${carga.metadatos || '<em>Sin metadatos</em>'}</td>
                                        <td><span class="text-truncate d-inline-block" style="max-width: 250px;">${carga.ruta_archivo}</span></td>
                                        <td>${new Date(carga.created_at).toLocaleString()}</td>
                                    </tr>
                                `;
                                tableBody.innerHTML += row;
                            });
                        } else {
                            Swal.fire({
                                icon: 'info',
                                title: 'Sin datos',
                                text: 'No se encontraron archivos cargados para este paso.',
                            });
                        }
                    })
                    .catch((error) => {
                        console.error('Error al cargar los datos:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al recuperar los datos.',
                        });
                    });
            }
    
            // --- Función para inicializar la configuración de personalización ---
            function initializePersonalization(tipo) {
                const saveButton = document.querySelector(`#timer-${tipo.toLowerCase()}`); // Botón de guardado
                if (!saveButton) return; // Salir si no hay botón
    
                // Cargar configuración inicial desde el servidor
                fetch(`/personalization/${tipo}`)
                    .then((response) => {
                        if (!response.ok) throw new Error('No se encontró configuración');
                        return response.json();
                    })
                    .then((data) => {
                        // Configurar los valores iniciales en el formulario
                        document.getElementById(`interval-${tipo.toLowerCase()}`).value = data.intervalo_horas;
                        document.getElementById(`email-notifications-${tipo.toLowerCase()}`).checked = data.notificaciones_email;
                        saveButton.innerText = 'Editar Personalización'; // Cambiar el texto del botón
                    })
                    .catch((error) => {
                        console.warn(error.message);
                        saveButton.innerText = 'Guardar Personalización'; // Texto predeterminado si no hay datos
                    });
    
                // Manejar el evento de clic para guardar la personalización
                saveButton.addEventListener('click', function () {
                    const intervalo = document.getElementById(`interval-${tipo.toLowerCase()}`).value; // Obtener el intervalo
                    const emailNotifications = document.getElementById(`email-notifications-${tipo.toLowerCase()}`).checked; // Obtener el estado del checkbox
    
                    // Enviar los datos al servidor
                    fetch(`/personalization/${tipo}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // Agregar CSRF token
                        },
                        body: JSON.stringify({
                            intervalo_horas: intervalo,
                            notificaciones_email: emailNotifications ? 1 : 0,
                        }),
                    })
                        .then((response) => {
                            if (!response.ok) throw new Error('Error al guardar configuración');
                            return response.json();
                        })
                        .then((data) => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: data.message,
                            });
                            saveButton.innerText = 'Editar Personalización'; // Cambiar texto del botón después del guardado
                        })
                        .catch((error) => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error.message,
                            });
                        });
                });
            }
    
            // --- Inicializar botones de pasos ---
            stepButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    const step = this.getAttribute('data-step'); // Obtener el paso seleccionado
    
                    // Cambiar vista dinámica
                    loadDynamicView(step);
    
                    // Cargar datos de la tabla
                    loadCargas(step);
    
                    // Actualizar visualización de botones
                    stepButtons.forEach((btn) => {
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-secondary');
                    });
                    this.classList.add('btn-primary'); // Marcar el botón seleccionado
                });
            });
    
            // --- Validación de archivos ---
            document.querySelectorAll('input[type="file"]').forEach((input) => {
                input.addEventListener('change', function () {
                    const allowedExtensions = ['xlsx', 'xls', 'csv']; // Extensiones permitidas
                    let isValid = true;
    
                    // Validar cada archivo seleccionado
                    Array.from(this.files).forEach((file) => {
                        const extension = file.name.split('.').pop().toLowerCase();
                        if (!allowedExtensions.includes(extension)) {
                            isValid = false;
                            Swal.fire({
                                icon: 'error',
                                title: 'Archivo no válido',
                                text: `El archivo ${file.name} no es un archivo válido.`,
                            });
                        }
                    });
    
                    if (!isValid) {
                        this.value = ''; // Limpiar el input si hay errores
                    }
                });
            });
    
            // --- Carga inicial ---
            loadDynamicView('1'); // Cargar vista inicial
            loadCargas(1); // Cargar datos de tabla inicial
        });
    </script>
    
@endsection
