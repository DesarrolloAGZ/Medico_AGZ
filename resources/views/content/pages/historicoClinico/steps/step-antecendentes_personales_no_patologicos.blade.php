{{-- Paso para registrar Antecedentes heredofamiliares --}}
<div id="step-antecendentes_personales_no_patologico" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Antecedentes personales no patológicos</h6>
    <small>Los datos marcados con<i class="text-danger">*</i> son obligatorios</small>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_no_patologicos-habitacion" name="historico_clinico_personales_no_patologicos[habitacion]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['habitacion'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['habitacion'] : '' }}</textarea>
        <label for="">Habitación:</label>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_no_patologicos-higiene_personal" name="historico_clinico_personales_no_patologicos[higiene_personal]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['higiene_personal'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['higiene_personal'] : '' }}</textarea>
        <label for="">Higiene personal:</label>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_no_patologicos-actividad_fisica" name="historico_clinico_personales_no_patologicos[actividad_fisica]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['actividad_fisica'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['actividad_fisica'] : '' }}</textarea>
        <label for="">Actividad física:</label>
      </div>
    </div>
  </div>

  <div class="divider text-start divider-primary">
    <div class="divider-text">Toxicomanías</div>
  </div>

  <div class="row mb-4">

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_personales_no_patologicos-alcohol" name="historico_clinico_personales_no_patologicos[alcohol]" placeholder="Ingresa con que frecuencia"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['alcohol'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['alcohol'] : '' }}" />
        <label for="">Alcohol <i class="text-danger">*</i></label>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_personales_no_patologicos-drogas" name="historico_clinico_personales_no_patologicos[drogas]" placeholder="Ingresa con que frecuencia"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['drogas'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['drogas'] : '' }}" />
        <label for="">Drogas <i class="text-danger">*</i></label>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_personales_no_patologicos-tabaco" name="historico_clinico_personales_no_patologicos[tabaco]" placeholder="Ingresa con que frecuencia"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['tabaco'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_no_patologicos'][0]['tabaco'] : '' }}" />
        <label for="">Tabaco <i class="text-danger">*</i></label>
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
