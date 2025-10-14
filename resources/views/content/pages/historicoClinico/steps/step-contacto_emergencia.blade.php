{{-- Paso para registrar contacto de emergencia --}}
<div id="step-contacto_emergencia" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Contacto de emergencia</h6>
    <small>Los datos marcados con<i class="text-danger">*</i> son obligatorios</small>
  </div>

  <div class="divider text-start divider-primary">
    <div class="divider-text">Contacto de emergencia 1</div>
  </div>

  <div class="row mb-4">

    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_contacto_emergencia-1-nombre" name="historico_clinico_contacto_emergencia[1][nombre]" placeholder="Ingresa el nombre completo"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][0]['nombre'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][0]['nombre'] : '' }}" />
        <label for="">Nombre <i class="text-danger">*</i></label>
      </div>
    </div>

  </div>

  <div class="row mb-4">

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_contacto_emergencia-1-parentesco" name="historico_clinico_contacto_emergencia[1][parentesco]" placeholder="Ingresa el parentesco"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][0]['parentesco'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][0]['parentesco'] : '' }}" />
        <label for="">Parentesco <i class="text-danger">*</i></label>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input class="form-control campo_visualizar" id="historico_clinico_contacto_emergencia-1-celular" name="historico_clinico_contacto_emergencia[1][celular]" type="tel" placeholder="Ingresa un número celular"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][0]['celular'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][0]['celular'] : '' }}" />
        <label for="paciente-celular">Número Celular</label>
      </div>
    </div>

  </div>


  <div class="divider text-start divider-primary">
    <div class="divider-text mt-4">Contacto de emergencia 2 (opcional)</div>
  </div>

  <div class="row mb-4">

    <div class="col-md-12">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_contacto_emergencia-2-nombre" name="historico_clinico_contacto_emergencia[2][nombre]" placeholder="Ingresa el nombre completo"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][1]['nombre'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][1]['nombre'] : '' }}" />
        <label for="">Nombre</label>
      </div>
    </div>

  </div>

  <div class="row mb-4">

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_contacto_emergencia-2-parentesco" name="historico_clinico_contacto_emergencia[2][parentesco]" placeholder="Ingresa el parentesco"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][1]['parentesco'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][1]['parentesco'] : '' }}" />
        <label for="">Parentesco</label>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input class="form-control campo_visualizar" id="historico_clinico_contacto_emergencia-2-celular" name="historico_clinico_contacto_emergencia[2][celular]" type="tel" placeholder="Ingresa un número celular"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][1]['celular'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_contacto_emergencia'][1]['celular'] : '' }}" />
        <label for="paciente-celular">Número Celular</label>
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
