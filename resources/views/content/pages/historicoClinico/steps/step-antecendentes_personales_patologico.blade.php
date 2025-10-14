{{-- Paso para registrar Antecedentes heredofamiliares --}}
<div id="step-antecendentes_personales_patologico" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Antecedentes personales patológicos</h6>
    <small>Los datos marcados con<i class="text-danger">*</i> son obligatorios</small>
  </div>

  <div class="row mb-4">
    <div class="col-md-6">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_patologicos-cronico_degenerativas" name="historico_clinico_personales_patologicos[cronico_degenerativas]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['cronico_degenerativas'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['cronico_degenerativas'] : '' }}</textarea>
        <label for="">Crónico-degenerativas:</label>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_patologicos-traumaticos" name="historico_clinico_personales_patologicos[traumaticos]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['traumaticos'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['traumaticos'] : '' }}</textarea>
        <label for="">Traumáticos:</label>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-6">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_patologicos-quirurgicos" name="historico_clinico_personales_patologicos[quirurgicos]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['quirurgicos'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['quirurgicos'] : '' }}</textarea>
        <label for="">Quirúrgicos:</label>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_patologicos-transfusionales" name="historico_clinico_personales_patologicos[transfusionales]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['transfusionales'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['transfusionales'] : '' }}</textarea>
        <label for="">Transfusionales:</label>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-6">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_patologicos-alergicos" name="historico_clinico_personales_patologicos[alergicos]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['alergicos'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['alergicos'] : '' }}</textarea>
        <label for="">Alérgicos:</label>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_patologicos-hospitalizaciones" name="historico_clinico_personales_patologicos[hospitalizaciones]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['hospitalizaciones'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['hospitalizaciones'] : '' }}</textarea>
        <label for="">Hospitalizaciones:</label>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_personales_patologicos-otros" name="historico_clinico_personales_patologicos[otros]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['otros'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_personales_patologicos'][0]['otros'] : '' }}</textarea>
        <label for="">Otros:</label>
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
