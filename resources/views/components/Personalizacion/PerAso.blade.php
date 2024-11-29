<div class="accordion" id="personalizationAccordion">
    {{-- Encabezado del acordeón --}}
    <div class="accordion-item">
        <h2 class="accordion-header" id="personalizationHeading">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#personalizationCollapse" aria-expanded="true"
                aria-controls="personalizationCollapse">
                <i class="fas fa-cogs me-2"></i> Personalización Asociados
            </button>
        </h2>
        {{-- Contenido del acordeón --}}
        <div id="personalizationCollapse" class="accordion-collapse collapse show"
            aria-labelledby="personalizationHeading" data-bs-parent="#personalizationAccordion">
            <div class="accordion-body">
                <div class="mb-3">
                    <label for="interval-aso" class="form-label">
                        <i class="fas fa-clock"></i> Intervalo de Ejecución (horas)
                    </label>
                    <input type="number" class="form-control" id="interval-aso" value="12" />
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" id="email-notifications-aso" />
                    <label class="form-check-label" for="email-notifications-aso">
                        <i class="fas fa-envelope"></i> Notificaciones por Email
                    </label>
                </div>
                <button class="btn btn-primary" id="save-personalization">
                    <i class="fas fa-save"></i> Guardar Personalización
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Obtener referencias a los elementos del DOM
        const saveButton = document.getElementById('save-personalization');
        const intervalInput = document.getElementById('interval-aso');
        const emailNotificationsInput = document.getElementById('email-notifications-aso');

        // Manejar el clic en el botón de guardar
        saveButton.addEventListener('click', function () {
            // Obtener los valores ingresados
            const intervaloHoras = intervalInput.value;
            const notificacionesEmail = emailNotificationsInput.checked ? 1 : 0;

            // Validar los datos antes de enviarlos
            if (!intervaloHoras || intervaloHoras <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El intervalo debe ser un número mayor a 0.',
                });
                return;
            }

            // Enviar los datos al backend utilizando fetch
            fetch('/personalization/Asociados', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    intervalo_horas: intervaloHoras,
                    notificaciones_email: notificacionesEmail,
                }),
            })
                .then((response) => {
                    if (!response.ok) throw new Error('Error al guardar los datos');
                    return response.json();
                })
                .then((data) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: data.message,
                    });
                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al guardar la configuración.',
                    });
                    console.error(error);
                });
        });
    });
</script>
