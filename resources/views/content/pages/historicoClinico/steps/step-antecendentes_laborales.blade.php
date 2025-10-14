{{-- Paso para registrar Antecedentes laborales --}}
<div id="step-antecendentes_laborales" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Antecedentes laborales</h6>
    <small>Los datos marcados con <i class="text-danger">*</i> son obligatorios</small>
  </div>

  <div id="contenedor-campos_antecedente_laboral">
    <!-- Los bloques se agregarán aquí dinámicamente -->
  </div>

  <!-- Botón para agregar nuevos bloques -->
  <div class="text-center mt-3 mb-4">
    <button id="btn-pintar_antecedentes_laborales" type="button" class="btn btn-primary" onclick="pintaCamposAntecedenteLaboral()">
      <i class="mdi mdi-plus me-1"></i> Agregar antecedente laboral
    </button>
  </div>

  <div class="row mb-4">
    <div class="col-md-5">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_empleo-ultimo_empleo" name="historico_clinico_empleo[ultimo_empleo]" placeholder="Ingresa el último empleo"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_empleo'][0]['ultimo_empleo'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_empleo'][0]['ultimo_empleo'] : '' }}" />
        <label for="">Último empleo <i class="text-danger">*</i></label>
      </div>
    </div>
    <div class="col-md-7">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_empleo-motivo_separacion" name="historico_clinico_empleo[motivo_separacion]" placeholder="Escribe el motivo...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_empleo'][0]['motivo_separacion'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_empleo'][0]['motivo_separacion'] : '' }}</textarea>
        <label for="">Motivo de separación:</label>
      </div>
    </div>
  </div>

  <div class="col-12 d-flex justify-content-between">
    <button class="btn btn-outline-secondary btn-prev"> <i class="icon-base ri ri-arrow-left-line icon-sm scaleX-n1-rtl me-sm-1 me-0"></i>
      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
    </button>
    <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span> <i class="icon-base ri ri-arrow-right-line icon-sm"></i></button>
  </div>
</div>
