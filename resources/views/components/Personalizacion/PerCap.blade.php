<div class="accordion" id="personalizationAccordionCap">
    {{-- Encabezado del acordeón --}}
    <div class="accordion-item">
        <h2 class="accordion-header" id="personalizationHeadingCap">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#personalizationCollapseCap" aria-expanded="true"
                aria-controls="personalizationCollapseCap">
                <i class="fas fa-cogs me-2"></i> Personalización Captaciones
            </button>
        </h2>

        {{-- Contenido del acordeón --}}
        <div id="personalizationCollapseCap" class="accordion-collapse collapse show"
            aria-labelledby="personalizationHeadingCap" data-bs-parent="#personalizationAccordionCap">
            <div class="accordion-body">
                <div class="mb-3">
                    <label for="interval-cap" class="form-label">
                        <i class="fas fa-clock"></i> Intervalo de Ejecución (horas)
                    </label>
                    <input type="number" class="form-control personalization-interval" 
                           id="interval-cap" value="12" data-tipo="Captaciones">
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input personalization-email" 
                           type="checkbox" id="email-notifications-cap" data-tipo="Captaciones">
                    <label class="form-check-label" for="email-notifications-cap">
                        <i class="fas fa-envelope"></i> Notificaciones por Email
                    </label>
                </div>
                <button class="btn btn-primary personalization-save" id="timer-cap" data-tipo="Captaciones">
                    <i class="fas fa-save"></i> Guardar Personalización
                </button>
            </div>
        </div>
    </div>
</div>


