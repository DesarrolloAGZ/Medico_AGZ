{{-- Paso para registrar interrogatorio por aparatos y sistemas --}}
<div id="step-interrogatorio_por_aparatos_y_sistemas" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Interrogatorio por aparatos y sistemas</h6>
    <small>Los datos marcados con <i class="text-danger">*</i> son obligatorios</small>
  </div>
{{-- {{ dd($datos_vista)}} --}}
  <div class="list-group mb-4">

    <div class="list-group-item list-group-item-action active">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Sintomas generales:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-sintomas_generales" name="historico_clinico_aparatos_sistemas[sintomas_generales]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['sintomas_generales'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Astenia, adinamia, anorexia, pérdida de peso.</p>
    </div>

    <div class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Aparato digestivo:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-aparato_digestivo" name="historico_clinico_aparatos_sistemas[aparato_digestivo]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['aparato_digestivo'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Dolor abdominal, Diarrea, Estreñimiento, Gastritis, Ulcera.</p>
    </div>

    <div class="list-group-item list-group-item-action active">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Aparato respiratorio:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-aparato_respiratorio" name="historico_clinico_aparatos_sistemas[aparato_respiratorio]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['aparato_respiratorio'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Dificultad respiratoria, tos frecuente, dolor torácico u otros.</p>
    </div>

    <div class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Sist. Cardiovascular:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-cardiovascular" name="historico_clinico_aparatos_sistemas[cardiovascular]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['cardiovascular'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Palpitaciones, Disnea, Edema, Insuficiencia venosa o arterial.</p>
    </div>

    <div class="list-group-item list-group-item-action active">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Sist. Urogenital:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-urogenital" name="historico_clinico_aparatos_sistemas[urogenital]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['urogenital'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Disuria, polaquiuria, hematuria, cistitis, vaginitis, Alt. En eyaculaculación.</p>
    </div>

    <div class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Musculoesquelético:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-musculoesqueletico" name="historico_clinico_aparatos_sistemas[musculoesqueletico]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['musculoesqueletico'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Dolor muscular, Calambres, Limitación de la movilidad, dism de la fuerza, etc...</p>
    </div>

    <div class="list-group-item list-group-item-action active">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Sist. Endócrino:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-endocrino" name="historico_clinico_aparatos_sistemas[endocrino]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['endocrino'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Poliuria, polidipsia, fatiga fácil, intolerancia al frío o al calor, Dismenorrea.</p>
    </div>

    <div class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Sist. Hematopoyetico:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-hematopoyetico" name="historico_clinico_aparatos_sistemas[hematopoyetico]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['hematopoyetico'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Hemorragias, moretones, infecciones constantes.</p>
    </div>

    <div class="list-group-item list-group-item-action active">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Sist. Nervioso:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-nervioso" name="historico_clinico_aparatos_sistemas[nervioso]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['nervioso'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Cefalea, mareos, desorientación, confusión mental, trast del sueño, epilepsia.</p>
    </div>

    <div class="list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">Piel y faneras:</h5>
        <small>
          <label class="switch switch-primary ms-2" style="justify-content: center;">
            <input type="checkbox" class="switch-input campo_visualizar" id="historico_clinico_aparatos_sistemas-piel_faneras" name="historico_clinico_aparatos_sistemas[piel_faneras]"
              {{ (isset($datos_vista['historico_clinico']) && count($datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas']) > 0 && $datos_vista['historico_clinico'][0]['historico_clinico_aparatos_sistemas'][0]['piel_faneras'] == 1) ? 'checked': '' }} />
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
        </small>
      </div>
      <p class="mb-1">Piel seca, Pelo quebradizo, Lunares, Eritemas, Perforaciones, Tatuajes.</p>
    </div>

  </div>

  <div class="col-12 d-flex justify-content-between">
    <button class="btn btn-outline-secondary btn-prev"> <i class="icon-base ri ri-arrow-left-line icon-sm scaleX-n1-rtl me-sm-1 me-0"></i>
      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
    </button>
    <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span> <i class="icon-base ri ri-arrow-right-line icon-sm"></i></button>
  </div>
</div>
