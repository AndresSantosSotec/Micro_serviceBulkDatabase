
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
