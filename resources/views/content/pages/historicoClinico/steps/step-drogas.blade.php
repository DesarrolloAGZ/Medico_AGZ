{{-- Paso para registrar exploracion fisica --}}
<div id="step-drogas" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Drogas</h6>
    <small>Los datos marcados con <i class="text-danger">*</i> son obligatorios</small>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <label class="me-2">Antidoping</label>
      <label class="switch switch-primary ms-2" style="justify-content: center;">
        <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_drogas-antidoping" name="historico_clinico_drogas[antidoping]" onchange="pintaCamposAntidoping();"
          {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_drogas'][0]['antidoping'] == 1) ? 'checked': '' }} />
        <span class="switch-label" style="display: contents; color: #28a745;">Negativo</span>
        <span class="switch-toggle-slider">
          <span class="switch-on">
            <i class="icon-base ri ri-check-line"></i>
          </span>
          <span class="switch-off">
            <i class="icon-base ri ri-close-line"></i>
          </span>
        </span>
        <span class="switch-label" style="color: #ff4d49;">Positivo</span>
      </label>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_drogas-tipo_droga" name="historico_clinico_drogas[tipo_droga]" placeholder="Escribe el tipo de droga...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_drogas'][0]['tipo_droga'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_drogas'][0]['tipo_droga'] : '' }}</textarea>
        <label for="">Tipo de droga:</label>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_drogas-idx" name="historico_clinico_drogas[idx]" placeholder="Escribe el IDX...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_drogas'][0]['idx'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_drogas'][0]['idx'] : '' }}</textarea>
        <label for="">IDX:</label>
      </div>
    </div>
  </div>

  <div class="divider text-start divider-dark mt-4">
    <div class="divider-text">Calificado como: <i class="text-danger">*</i></div>
  </div>

  <div class="row">
    <div class="col-md mb-md-0 mb-2">
      <div class="form-check custom-option custom-option-icon">
        <label class="form-check-label custom-option-content" for="historico_clinico_drogas-calificacion_apto">
          <span class="custom-option-body">
            <span class="custom-option-title mb-2">Apto <i class="mdi mdi-check-decagram" style="color: #28a745;"></i></span>
          </span>
          <input id="historico_clinico_drogas-calificacion_apto" name="historico_clinico_drogas[calificacion]" class="form-check-input campo_visualizar" type="radio" value="Apto"
            {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_drogas'][0]['calificacion'] == 'Apto') ? 'checked' : '' }} />
        </label>
      </div>
    </div>
    <div class="col-md mb-md-0 mb-2">
      <div class="form-check custom-option custom-option-icon">
        <label class="form-check-label custom-option-content" for="historico_clinico_drogas-calificacion_no_apto">
          <span class="custom-option-body">
            <span class="custom-option-title mb-2">No apto <i class="mdi mdi-cancel" style="color: #dc3545;"></i></span>
          </span>
          <input id="historico_clinico_drogas-calificacion_no_apto" name="historico_clinico_drogas[calificacion]" class="form-check-input campo_visualizar" type="radio" value="No apto"
            {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_drogas'][0]['calificacion'] == 'No apto') ? 'checked' : '' }} />
        </label>
      </div>
    </div>
    <div class="col-md">
      <div class="form-check custom-option custom-option-icon">
        <label class="form-check-label custom-option-content" for="historico_clinico_drogas-calificacion_condicionante">
          <span class="custom-option-body">
            <span class="custom-option-title mb-2">Apto con condicionante <i class="mdi mdi-alert-circle-outline" style="color: #ffc107;"></i></span>
          </span>
          <input id="historico_clinico_drogas-calificacion_condicionante" name="historico_clinico_drogas[calificacion]" class="form-check-input campo_visualizar" type="radio" value="Apto con condicionante"
            {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_drogas'][0]['calificacion'] == 'Apto con condicionante') ? 'checked' : '' }} />
        </label>
      </div>
    </div>
  </div>

  <div class="divider divider-dark mt-4">
    <div class="divider-text">Elaborado por</div>
  </div>

  <div class="row mb-4 {{ (isset($datos_vista['usuario_creador_historico_clinico']) && $datos_vista['usuario_creador_historico_clinico'][0]) ? 'd-none' : '' }}">
    <div class="col-md-12 text-center">
      <p><strong>Dr. {{ Auth::user()->nombre.' '.Auth::user()->apellido_paterno.' '.Auth::user()->apellido_materno }}</strong></p>
      <p><strong>REG.SSA.</strong> {{ Auth::user()->registro_ssa }}</p>
      <p><strong>C.P.</strong> {{ Auth::user()->cedula_profesional }}</p>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12 text-center {{ (isset($datos_vista['usuario_creador_historico_clinico']) && $datos_vista['usuario_creador_historico_clinico'][0]) ? '' : 'd-none' }}">
      <p><strong>Dr. {{ (isset($datos_vista['usuario_creador_historico_clinico']) && $datos_vista['usuario_creador_historico_clinico'][0]['usuario_nombre_completo'] != '') ? $datos_vista['usuario_creador_historico_clinico'][0]['usuario_nombre_completo'] : '' }}</strong></p>
      <p><strong>REG.SSA.</strong> {{ (isset($datos_vista['usuario_creador_historico_clinico']) && $datos_vista['usuario_creador_historico_clinico'][0]['usuario_registro_ssa'] != '') ? $datos_vista['usuario_creador_historico_clinico'][0]['usuario_registro_ssa'] : '' }}</p>
      <p><strong>C.P.</strong> {{ (isset($datos_vista['usuario_creador_historico_clinico']) && $datos_vista['usuario_creador_historico_clinico'][0]['usuario_cedula_profesional'] != '') ? $datos_vista['usuario_creador_historico_clinico'][0]['usuario_cedula_profesional'] : '' }}</p>
    </div>
  </div>

  <div class="col-12 d-flex justify-content-between">
    <button class="btn btn-outline-secondary btn-prev"> <i class="icon-base ri ri-arrow-left-line icon-sm scaleX-n1-rtl me-sm-1 me-0"></i>
      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
    </button>
    <button id="boton-guardar_historico" class="btn btn-primary btn-submit campo_visualizar">Guardar</button>
  </div>

</div>
