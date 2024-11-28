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
                                    <th>as</th>
                                    <th>as</th>
                                    <th>as</th>
                                    <th>as</th>
                                </tr>
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
                        {{-- Personalización Dinámica --}}
                        <div id="dynamic-personalization">
                            @if (View::exists('components.Personalizacion.PerAso'))
                                @include('components.Personalizacion.PerAso')
                            @else
                                <p>Error: La vista Personalizacion.PerAso no existe.</p>
                            @endif
                        </div>
                    </div>
                </div>
        </main>
    </div>

    {{-- SweetAlert Script --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- JavaScript para manejar funcionalidad --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stepButtons = document.querySelectorAll('.step-btn');
            const dynamicContainer = document.getElementById('dynamic-personalization');

            // Función para manejar el cambio dinámico de la vista
            stepButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const step = this.getAttribute('data-step'); // Obtener el paso seleccionado
                    let componentName;

                    // Determinar el nombre del componente basado en el paso
                    switch (step) {
                        case '1':
                            componentName = 'PerAso';
                            break;
                        case '2':
                            componentName = 'PerCap';
                            break;
                        case '3':
                            componentName = 'PerColo';
                            break;
                        default:
                            console.error('Paso no válido seleccionado');
                            return;
                    }

                    // Realizar una petición al servidor para cargar la vista dinámica
                    fetch(`/loadPersonalization/${componentName}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Error al cargar el componente.');
                            return response.text();
                        })
                        .then(html => {
                            dynamicContainer.innerHTML =
                            html; // Actualizar el contenido dinámico
                        })
                        .catch(error => {
                            console.error('Error al cargar la personalización:', error);
                            dynamicContainer.innerHTML =
                                '<p>Error al cargar el contenido dinámico.</p>';
                        });

                    // Actualizar visualmente los botones
                    stepButtons.forEach(btn => {
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-secondary');
                    });
                    this.classList.add('btn-primary');
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const stepButtons = document.querySelectorAll('.step-btn');
            const stepPanels = document.querySelectorAll('.step-panel');

            // Alternar visibilidad de los pasos
            stepButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const step = this.getAttribute('data-step');

                    // Actualizar botones
                    stepButtons.forEach(btn => {
                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-secondary');
                    });
                    this.classList.add('btn-primary');

                    // Mostrar el panel correspondiente
                    stepPanels.forEach(panel => {
                        panel.style.display = panel.id === `step-${step}` ? 'block' :
                            'none';
                    });
                });
            });

            // Validar archivos seleccionados
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function() {
                    const allowedExtensions = ['xlsx', 'xls', 'csv'];
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
                        }
                    });

                    if (!isValid) {
                        this.value = ''; // Limpiar el input si hay errores
                    }
                });
            });
        });
    </script>
@endsection
