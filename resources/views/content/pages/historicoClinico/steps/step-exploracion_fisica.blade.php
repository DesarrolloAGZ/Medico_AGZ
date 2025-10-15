{{-- Paso para registrar exploracion fisica --}}
<div id="step-exploracion_fisica" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Exploración física</h6>
    <small>Los datos marcados con <i class="text-danger">*</i> son obligatorios</small>
  </div>

  <div class="row mb-4">

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-peso" name="historico_clinico_exploracion_fisica[peso]" placeholder="Ingresa el peso"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['peso'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['peso'] : '' }}" />
        <label for="">Peso <i class="text-danger">*</i></label>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-talla" name="historico_clinico_exploracion_fisica[talla]" placeholder="Ingresa la talla"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['talla'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['talla'] : '' }}" />
        <label for="">Talla <i class="text-danger">*</i></label>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-presion_arterial" name="historico_clinico_exploracion_fisica[presion_arterial]" placeholder="Ingresa la presion arterial"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['presion_arterial'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['presion_arterial'] : '' }}" />
        <label for="">Pres. arterial <i class="text-danger">*</i></label>
      </div>
    </div>

  </div>

  <div class="row mb-4">

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-frecuencia_cardiaca" name="historico_clinico_exploracion_fisica[frecuencia_cardiaca]" placeholder="Ingresa la frecuencia cardiaca"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['frecuencia_cardiaca'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['frecuencia_cardiaca'] : '' }}" />
        <label for="">Fec. cardiaca <i class="text-danger">*</i></label>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-frecuencia_respiratoria" name="historico_clinico_exploracion_fisica[frecuencia_respiratoria]" placeholder="Ingresa la frecuencia respiratoria"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['frecuencia_respiratoria'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['frecuencia_respiratoria'] : '' }}" />
        <label for="">Frec. respiratoria <i class="text-danger">*</i></label>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-temperatura" name="historico_clinico_exploracion_fisica[temperatura]" placeholder="Ingresa la temperatura"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['temperatura'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['temperatura'] : '' }}" />
        <label for="">Temperatura <i class="text-danger">*</i></label>
      </div>
    </div>

  </div>

  <div class="row mb-4">

    <div class="col-md-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-glucosa" name="historico_clinico_exploracion_fisica[glucosa]" placeholder="Ingresa la glucosa"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['glucosa'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['glucosa'] : '' }}" />
        <label for="">Glucosa</label>
      </div>
    </div>

  </div>

  <div class="row mb-4">

    <div class="col-md-12">
      <label class="me-2">Tatuajes</label>
      <label class="switch switch-primary ms-2" style="justify-content: center;">
        <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_exploracion_fisica-tatuajes" name="historico_clinico_exploracion_fisica[tatuajes]"
          {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['tatuajes'] == 1) ? 'checked': '' }} />
        <span class="switch-label" style="display: contents; color: #ff4d49;">No</span>
        <span class="switch-toggle-slider">
          <span class="switch-on">
            <i class="icon-base ri ri-check-line"></i>
          </span>
          <span class="switch-off">
            <i class="icon-base ri ri-close-line"></i>
          </span>
        </span>
        <span class="switch-label" style="color: #28a745;">Si</span>
      </label>
    </div>

  </div>

  <div class="accordion mb-4" id="accordionWithIcon">

    {{-- acordion de exploracion de fisica - cabeza --}}
    <div class="accordion-item">
      <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button collapsed" style="background-color: #f4f4f6;" data-bs-toggle="collapse" data-bs-target="#acordion_cabeza" aria-expanded="false">
          <span class="mdi mdi-head mdi-24px me-2"></span>Cabeza
        </button>
      </h2>
      <div id="acordion_cabeza" class="accordion-collapse collapse">
        <div class="accordion-body">
          <div class="row mb-3">
            <div class="col-md-12" style="justify-content: center;">
              <small class="fw-medium d-block me-4"><strong>Craneo: <i class="text-danger">*</i></strong></small>
              <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="radio" id="historico_clinico_exploracion_fisica-craneo_endos" name="historico_clinico_exploracion_fisica[craneo]" value="ENDOS"
                  {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['craneo'] == 'ENDOS') ? 'checked' : '' }}/>
                <label class="form-check-label" for="historico_clinico_exploracion_fisica-craneo_endos">ENDOS</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="radio" id="historico_clinico_exploracion_fisica-craneo_exos" name="historico_clinico_exploracion_fisica[craneo]" value="EXOS"
                  {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['craneo'] == 'EXOS') ? 'checked' : '' }}/>
                <label class="form-check-label" for="historico_clinico_exploracion_fisica-craneo_exos">EXOS</label>
              </div>
               <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="radio" id="historico_clinico_exploracion_fisica-craneo_nl" name="historico_clinico_exploracion_fisica[craneo]" value="NL"
                  {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['craneo'] == 'NL') ? 'checked' : '' }}/>
                <label class="form-check-label" for="historico_clinico_exploracion_fisica-craneo_nl">NL</label>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12" style="justify-content: center;">
              <small class="fw-medium d-block me-4"><strong>Cara: <i class="text-danger">*</i></strong></small>
              <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="radio" id="historico_clinico_exploracion_fisica-cara_sim" name="historico_clinico_exploracion_fisica[cara]" value="SIM"
                  {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['cara'] == 'SIM') ? 'checked' : '' }}/>
                <label class="form-check-label" for="historico_clinico_exploracion_fisica-cara_sim">SIM</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="radio" id="historico_clinico_exploracion_fisica-cara_asim" name="historico_clinico_exploracion_fisica[cara]" value="ASIM"
                  {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['cara'] == 'ASIM') ? 'checked' : '' }}/>
                <label class="form-check-label" for="historico_clinico_exploracion_fisica-cara_asim">ASIM</label>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-ojos" name="historico_clinico_exploracion_fisica[ojos]" placeholder="Escribe la descripción de los ojos...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['ojos'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['ojos'] : '' }}</textarea>
                <label for="">Ojos:</label>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-a_visual_oi" name="historico_clinico_exploracion_fisica[a_visual_oi]" placeholder="Ingresa la A. Visual del ojo izquierdo"
                  value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['a_visual_oi'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['a_visual_oi'] : '' }}" />
                <label for="">A. Visual OI <i class="text-danger">*</i></label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control campo_visualizar" id="historico_clinico_exploracion_fisica-a_visual_od" name="historico_clinico_exploracion_fisica[a_visual_od]" placeholder="Ingresa la A. Visual del ojo derecho"
                  value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['a_visual_od'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['a_visual_od'] : '' }}" />
                <label for="">A. Visual OD <i class="text-danger">*</i></label>
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-4">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-nariz" name="historico_clinico_exploracion_fisica[nariz]" placeholder="Escribe la descripción de la naríz...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['nariz'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['nariz'] : '' }}</textarea>
                <label for="">Naríz:</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-boca" name="historico_clinico_exploracion_fisica[boca]" placeholder="Escribe la descripción de la boca...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['boca'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['boca'] : '' }}</textarea>
                <label for="">Boca:</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-oidos" name="historico_clinico_exploracion_fisica[oidos]" placeholder="Escribe la descripción de los oídos...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['oidos'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_exploracion_fisica'][0]['oidos'] : '' }}</textarea>
                <label for="">Oídos:</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- acordion de exploracion de fisica - cuello --}}
    <div class="accordion-item">
      <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" style="background-color: #f4f4f6;" data-bs-target="#acordion_cuello" aria-expanded="false">
          <span class="mdi mdi-account-voice mdi-24px me-2"></span>Cuello
        </button>
      </h2>
      <div id="acordion_cuello" class="accordion-collapse collapse">
        <div class="accordion-body">
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-cuello" name="historico_clinico_exploracion_fisica[cuello]" placeholder="Escribe la descripción del cuello..."></textarea>
                <label for="">Cuello:</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- acordion de exploracion de fisica - torax --}}
    <div class="accordion-item">
      <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" style="background-color: #f4f4f6;" data-bs-target="#acordion_torax" aria-expanded="false">
          <span class="mdi mdi-lungs mdi-24px me-2"></span>Torax
        </button>
      </h2>
      <div id="acordion_torax" class="accordion-collapse collapse">
        <div class="accordion-body">
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-torax" name="historico_clinico_exploracion_fisica[torax]" placeholder="Escribe la descripción del torax..."></textarea>
                <label for="">Torax:</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- acordion de exploracion de fisica - columna --}}
    <div class="accordion-item">
      <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" style="background-color: #f4f4f6;" data-bs-target="#acordion_columna" aria-expanded="false">
          <span class="mdi mdi-bone mdi-24px me-2"></span>Columna
        </button>
      </h2>
      <div id="acordion_columna" class="accordion-collapse collapse">
        <div class="accordion-body">
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-columna" name="historico_clinico_exploracion_fisica[columna]" placeholder="Escribe la descripción de la columna..."></textarea>
                <label for="">Columna:</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- acordion de exploracion de fisica - abdomen --}}
    <div class="accordion-item">
      <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" style="background-color: #f4f4f6;" data-bs-target="#acordion_abdomen" aria-expanded="false">
          <span class="mdi mdi-stomach mdi-24px me-2"></span>Abdomen
        </button>
      </h2>
      <div id="acordion_abdomen" class="accordion-collapse collapse">
        <div class="accordion-body">
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-abdomen" name="historico_clinico_exploracion_fisica[abdomen]" placeholder="Escribe la descripción del abdomen..."></textarea>
                <label for="">Abdomen:</label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- acordion de exploracion de fisica - extremidades --}}
    <div class="accordion-item">
      <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" style="background-color: #f4f4f6;" data-bs-target="#acordion_extremidades" aria-expanded="false">
          <span class="mdi mdi-arm-flex mdi-24px me-2"></span>Extremidades
        </button>
      </h2>
      <div id="acordion_extremidades" class="accordion-collapse collapse">
        <div class="accordion-body">
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-extremidades_superiores" name="historico_clinico_exploracion_fisica[extremidades_superiores]" placeholder="Escribe la descripción de las extremidades superiores..."></textarea>
                <label for="">Extremidades superiores:</label>
              </div>
            </div>
          </div>
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="form-floating form-floating-outline">
                <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_exploracion_fisica-extremidades_inferiores" name="historico_clinico_exploracion_fisica[extremidades_inferiores]" placeholder="Escribe la descripción de las extremidades inferiores..."></textarea>
                <label for="">Extremidades inferiores:</label>
              </div>
            </div>
          </div>
        </div>
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
