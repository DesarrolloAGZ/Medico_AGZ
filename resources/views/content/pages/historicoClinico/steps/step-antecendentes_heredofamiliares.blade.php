{{-- Paso para registrar Antecedentes heredofamiliares --}}
<div id="step-antecendentes_heredofamiliares" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Antecedentes heredofamiliares</h6>
    <small>Los datos marcados con<i class="text-danger">*</i> son obligatorios</small>
  </div>
  <div class="row mb-4">

    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_heredofamiliares-cronico_degenerativas" name="historico_clinico_heredofamiliares[cronico_degenerativas]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_heredofamiliares'][0]['cronico_degenerativas'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_heredofamiliares'][0]['cronico_degenerativas'] : '' }}</textarea>
        <label for="">Crónico-degenerativas:</label>
      </div>
    </div>

  </div>

  <div class="row mb-4">

    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_heredofamiliares-cancer" name="historico_clinico_heredofamiliares[cancer]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_heredofamiliares'][0]['cancer'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_heredofamiliares'][0]['cancer'] : '' }}</textarea>
        <label for="">Cáncer:</label>
      </div>
    </div>

  </div>

  <div class="row mb-4">

    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_heredofamiliares-cardiopatias" name="historico_clinico_heredofamiliares[cardiopatias]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_heredofamiliares'][0]['cardiopatias'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_heredofamiliares'][0]['cardiopatias'] : '' }}</textarea>
        <label for="">Cardiopatías:</label>
      </div>
    </div>

  </div>

  <div class="row mb-4">

    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_heredofamiliares-otras" name="historico_clinico_heredofamiliares[otras]" placeholder="Escribe el antecedente...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_heredofamiliares'][0]['otras'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_heredofamiliares'][0]['otras'] : '' }}</textarea>
        <label for="">Otras:</label>
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
