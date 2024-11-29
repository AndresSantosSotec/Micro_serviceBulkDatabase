<div class="accordion" id="personalizationAccordionCol">
    {{-- Encabezado del acordeón --}}
    <div class="accordion-item">
        <h2 class="accordion-header" id="personalizationHeadingCol">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#personalizationCollapseCol" aria-expanded="true"
                aria-controls="personalizationCollapseCol">
                <i class="fas fa-cogs me-2"></i> Personalización Colocaciones
            </button>
        </h2>

        {{-- Contenido del acordeón --}}
        <div id="personalizationCollapseCol" class="accordion-collapse collapse show"
            aria-labelledby="personalizationHeadingCol" data-bs-parent="#personalizationAccordionCol">
            <div class="accordion-body">
                <div class="mb-3">
                    <label for="interval-col" class="form-label">
                        <i class="fas fa-clock"></i> Intervalo de Ejecución (horas)
                    </label>
                    <input type="number" class="form-control personalization-interval" 
                           id="interval-col" value="12" data-tipo="Colocaciones">
                </div>
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input personalization-email" 
                           type="checkbox" id="email-notifications-col" data-tipo="Colocaciones">
                    <label class="form-check-label" for="email-notifications-col">
                        <i class="fas fa-envelope"></i> Notificaciones por Email
                    </label>
                </div>
                <button class="btn btn-primary personalization-save" id="timer-col" data-tipo="Colocaciones">
                    <i class="fas fa-save"></i> Guardar Personalización
                </button>
            </div>
        </div>
    </div>
</div>



