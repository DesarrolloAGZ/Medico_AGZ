@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Valoracion Paciente')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/pacientes/valoracionPacientes.js') }}"></script>
  <script>
    var datos_vista = @json($datos_vista);
  </script>
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
  <!-- Form Validation -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
 <!-- Form Validation -->
 <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')

@php
  // dd($datos_vista['paciente']['datos_paciente']->nombre);
@endphp
  <div class="card p-5" style="width: 100%; height: 100%;">

    <div class="divider">
      <div class="divider-text texto-titulo">
        Valoración del paciente </br>
        {{ isset($datos_vista['paciente']['datos_paciente']->nombre) ? $datos_vista['paciente']['datos_paciente']->nombre.' '.$datos_vista['paciente']['datos_paciente']->apellido_paterno.' '.$datos_vista['paciente']['datos_paciente']->apellido_materno: '' }}
      </div>
    </div>

    <form id="form-registrar_nuevo_paciente" method="POST" enctype="multipart/form-data" onSubmit="return false">
      @csrf

      <input id="paciente_datos_consulta-paciente_id" name="paciente_datos_consulta[paciente_id]" type="text" style="display: none;" value="{{ isset($datos_vista) ? $datos_vista['paciente_id'] : '' }}">

      <div class="divider divider-dashed">
        <div class="divider-text texto-subtitulo">Motivos de la consulta</div>
      </div>

      <div class="row mb-4">
        @foreach($datos_vista['catalogos']['tipo_visita'] as $tipo)
            <div class="col-md mb-md-0 mb-2"">
                <div class="form-check custom-option custom-option-icon">
                    <label class="form-check-label custom-option-content" for="customRadioIcon{{ $tipo['id'] }}">
                        <span class="custom-option-body">
                            <i class="{{ $tipo['icono'] }}"></i>
                            <span class="custom-option-title">{{ $tipo['nombre'] }}</span>
                            <small>{{ $tipo['descripcion'] }}</small>
                        </span>
                        <input name="paciente_datos_consulta[paciente_tipo_visita_id]" class="form-check-input" type="radio" value="{{ $tipo['id'] }}" id="customRadioIcon{{ $tipo['id'] }}" {{ $loop->first ? 'checked' : '' }} />
                    </label>
                </div>
            </div>
        @endforeach
      </div>

      <div class="row">
        <div class="col-md-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <textarea class="form-control h-px-100" id="paciente_datos_consulta-motivo_consulta" name="paciente_datos_consulta[motivo_consulta]" placeholder="Escribe el motivo inicial de la consulta..."></textarea>
            <label for="paciente_datos_consulta-motivo_consulta">Descripción del motivo principal de la consulta <i class="text-danger">*</i></label>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <input type="text" class="form-control" id="cie-search" name="paciente_datos_consulta[cie_id]" autocomplete="off" placeholder="Buscar CIE-10">
            <label for="cie-search">CIE 10 <i class="text-danger">*</i></label>
            <div id="cie-results" class="dropdown-menu" style="width: 100%; display: none;"></div>
            <input type="hidden" id="cie-id" name="paciente_datos_consulta[cie_id_hidden]">
          </div>
        </div>
      </div>

      <div class="{{ isset($datos_vista['paciente']['datos_ultima_consulta']) ? '' : 'd-none' }} }}">
        <div class="divider divider-dashed">
          <div class="divider-text texto-subtitulo">Parametros de la ultima consulta</div>
        </div>

        <div class="row justify-content-center">

          <div class="col-md-3 mb-4">
            <div style="display: flex;align-items: center;">
              <div class="form-floating form-floating-outline">
                <input class="form-control" id="temperatura_anterior" type="text" placeholder="Temperatura de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->temperatura) ? $datos_vista['paciente']['datos_ultima_consulta']->temperatura : '' }}" disabled />
                <label for="temperatura_anterior">Temperatura (°C)</label>
              </div>
              <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
                data-bs-content='
                  <div style="text-align:center;">
                    <ul class="list-group list-group-timeline">
                      <li class="list-group-item list-group-timeline-info text-list-color"><strong>Hipotermia:</strong> Menos de 35°C (95°F)</li>
                      <li class="list-group-item list-group-timeline-success text-list-color"><strong>Temperatura normal:</strong> Entre 36.1°C y 37.2°C (97°F - 99°F)</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Febrícula:</strong> Entre 37.3°C y 38°C (99.1°F - 100.4°F)</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Fiebre:</strong> Más de 38°C (100.4°F)</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Fiebre alta:</strong> Más de 39.5°C (103.1°F)</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Hiperpirexia (peligrosa):</strong> Más de 41°C (105.8°F)</li>
                    </ul>
                  </div>
                '>
              </span>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <div style="display: flex;align-items: center;">
              <div class="form-floating form-floating-outline">
                <input class="form-control" id="peso_anterior" type="text" placeholder="Peso de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->peso) ? $datos_vista['paciente']['datos_ultima_consulta']->peso : '' }}" disabled />
                <label for="peso_anterior">Peso (Kg)</label>
              </div>
              <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
                data-bs-content='
                  <div style="text-align:center;">
                    <ul class="list-group list-group-timeline">
                      <li class="list-group-item list-group-timeline-info text-list-color"><strong>Bajo peso:</strong> Menos de 50 kg</li>
                      <li class="list-group-item list-group-timeline-success text-list-color"><strong>Peso normal (depende de la estatura):</strong> Entre 50 y 90 kg</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Sobrepeso:</strong> Entre 91 y 120 kg</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Obesidad:</strong> Más de 120 kg </li>
                    </ul>
                  </div>
                '>
              </span>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <div style="display: flex;align-items: center;">
              <div class="form-floating form-floating-outline">
                <input class="form-control" id="altura_anterior" type="text" placeholder="Altura de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->altura) ? $datos_vista['paciente']['datos_ultima_consulta']->altura : '' }}" disabled />
                <label for="altura_anterior">Altura (m.cm)</label>
              </div>
              <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
                data-bs-content='
                  <div style="text-align:center;">
                    <p>Hombres</p>
                    <ul class="list-group list-group-timeline">
                      <li class="list-group-item list-group-timeline-info text-list-color"><strong>Baja estatura:</strong> Menos de 1.60 m</li>
                      <li class="list-group-item list-group-timeline-success text-list-color"><strong>Estatura promedio:</strong> Entre 1.60 y 1.74 m</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Estatura alta:</strong> Entre 1.75 y 1.89 m</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Estatura muy alta:</strong> Más de 1.90 m</li>
                    </ul>
                    <p>Mujeres</p>
                    <ul class="list-group list-group-timeline">
                      <li class="list-group-item list-group-timeline-info text-list-color"><strong>Baja estatura:</strong> Menos de 1.50 m</li>
                      <li class="list-group-item list-group-timeline-success text-list-color"><strong>Estatura promedio:</strong> Entre 1.50 y 1.69 m</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Estatura alta:</strong> Entre 1.70 y 1.80 m</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Estatura muy alta:</strong> Más de 1.80 m</li>
                    </ul>
                  </div>
                '>
              </span>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <div style="display: flex;align-items: center;">
              <div class="form-floating form-floating-outline">
                <input class="form-control" id="imc_anterior" type="text" placeholder="I.M.C de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->imc) ? $datos_vista['paciente']['datos_ultima_consulta']->imc : '' }}" disabled />
                <label for="imc_anterior">I.M.C</label>
              </div>
              <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
                data-bs-content='
                  <div style="text-align:center;">
                    <ul class="list-group list-group-timeline">
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Peso bajo:</strong> Menos de 18.5</li>
                      <li class="list-group-item list-group-timeline-success text-list-color"><strong>Peso normal:</strong> Entre 18.5 y 24.9</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Sobrepeso:</strong> Entre 25 y 29.9</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Obesidad 1° (moderada):</strong> Entre 30 y 34.9</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Obesidad 2° (severa):</strong> Entre 35 y 39.9</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Obesidad 3° (extrema):</strong> Más de 40.9</li>
                    </ul>
                  </div>
                '>
              </span>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <div style="display: flex;align-items: center;">
              <div class="form-floating form-floating-outline">
                <input class="form-control" id="frecuencia_cardiaca_anterior" type="text" placeholder="Frecuencia cardiaca de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->frecuencia_cardiaca) ? $datos_vista['paciente']['datos_ultima_consulta']->frecuencia_cardiaca : '' }}" disabled />
                <label for="frecuencia_cardiaca_anterior">Frec. cardiaca (lpm)</label>
              </div>
              <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
                data-bs-content='
                  <div style="text-align:center;">
                    <p>En reposo (estado normal)</p>
                    <ul class="list-group list-group-timeline">
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Bradicardia:</strong> Menos de 50 LPM</li>
                      <li class="list-group-item list-group-timeline-success text-list-color"><strong>Normal:</strong> Entre 50 y 100 LPM</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Taquicardia:</strong> Más de 100 LPM</li>
                    </ul>
                  </div>
                '>
              </span>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <div style="display: flex;align-items: center;">
              <div class="form-floating form-floating-outline">
                <input class="form-control" id="saturacion_oxigeno_anterior" type="text" placeholder="Saturacion de oxigeno de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->saturacion_oxigeno) ? $datos_vista['paciente']['datos_ultima_consulta']->saturacion_oxigeno : '' }}" disabled />
                <label for="saturacion_oxigeno_anterior">Sat. de oxígeno (%)</label>
              </div>
              <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
                data-bs-content='
                  <div style="text-align:center;">
                    <ul class="list-group list-group-timeline">
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Hipoxemia grave:</strong> Menos de 90%</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Hipoxemia leve:</strong> Entre 90 y 94 %</li>
                      <li class="list-group-item list-group-timeline-success text-list-color"><strong>Normal:</strong> Entre 95 y 100 %</li>
                    </ul>
                  </div>
                '>
              </span>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <div style="display: flex;align-items: center;">
              <div class="form-floating form-floating-outline">
                <input class="form-control" id="presion_arterial_anterior" type="text" placeholder="Presion arterial de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->presion_arterial) ? $datos_vista['paciente']['datos_ultima_consulta']->presion_arterial : '' }}" disabled />
                <label for="presion_arterial_anterior">Presión arterial (mmHg)</label>
              </div>
              <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
                data-bs-content='
                  <div style="text-align:center;">
                    <ul class="list-group list-group-timeline">
                      <li class="list-group-item list-group-timeline-success text-list-color"><strong>Normal:</strong> Menos de 120/80 mmHg</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Elevada:</strong> Entre 120 y 129 / Menos de 80 mmHg</li>
                      <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Hipertensión etapa 1:</strong> Entre 130 y 139 / Entre 80 y 89 mmHg</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Hipertensión etapa 2:</strong> 140 o más / 90 o más mmHg</li>
                      <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Crisis hipertensiva:</strong> Más de 180/120 mmHg</li>
                    </ul>
                  </div>
                '>
              </span>
            </div>
          </div>

          <div class="col-md-3 mb-4">
            <button class="btn btn-secondary waves-effect waves-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#canvasConsultaAnterior" aria-controls="canvasConsultaAnterior">
              <span class="mdi mdi-page-next-outline" style="margin-right: 10px;"></span>Ver completos
            </button>
          </div>

        </div>
      </div>

      <div class="divider divider-dashed {{ isset($datos_vista['paciente']['datos_ultima_consulta']) ? '' : 'd-none' }} }}">
        <div class="divider-text texto-subtitulo">Registro de parametros actuales</div>
      </div>

      <div class="row justify-content-center">

        <div class="col-md-3 mb-4">
          <div style="display: flex;align-items: center;">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="paciente_datos_consulta-temperatura" name="paciente_datos_consulta[temperatura]" type="text" placeholder="Ingresa la temperatura" />
              <label for="paciente_datos_consulta-temperatura">Temperatura (°C) <i class="text-danger">*</i></label>
            </div>
            <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
              data-bs-content='
                <div style="text-align:center;">
                  <ul class="list-group list-group-timeline">
                    <li class="list-group-item list-group-timeline-info text-list-color"><strong>Hipotermia:</strong> Menos de 35°C (95°F)</li>
                    <li class="list-group-item list-group-timeline-success text-list-color"><strong>Temperatura normal:</strong> Entre 36.1°C y 37.2°C (97°F - 99°F)</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Febrícula:</strong> Entre 37.3°C y 38°C (99.1°F - 100.4°F)</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Fiebre:</strong> Más de 38°C (100.4°F)</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Fiebre alta:</strong> Más de 39.5°C (103.1°F)</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Hiperpirexia (peligrosa):</strong> Más de 41°C (105.8°F)</li>
                  </ul>
                </div>
              '>
            </span>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div style="display: flex;align-items: center;">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="paciente_datos_consulta-peso" name="paciente_datos_consulta[peso]" type="text" placeholder="Ingresa el peso" onkeyup="calculaIMC()" />
              <label for="paciente_datos_consulta-peso">Peso (Kg) <i class="text-danger">*</i></label>
            </div>
            <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
              data-bs-content='
                <div style="text-align:center;">
                  <ul class="list-group list-group-timeline">
                    <li class="list-group-item list-group-timeline-info text-list-color"><strong>Bajo peso:</strong> Menos de 50 kg</li>
                    <li class="list-group-item list-group-timeline-success text-list-color"><strong>Peso normal (depende de la estatura):</strong> Entre 50 y 90 kg</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Sobrepeso:</strong> Entre 91 y 120 kg</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Obesidad:</strong> Más de 120 kg </li>
                  </ul>
                </div>
              '>
            </span>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div style="display: flex;align-items: center;">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="paciente_datos_consulta-altura" name="paciente_datos_consulta[altura]" type="text" placeholder="Ingresa la altura" onkeyup="calculaIMC()" />
              <label for="paciente_datos_consulta-altura">Altura (m.cm) <i class="text-danger">*</i></label>
            </div>
            <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
              data-bs-content='
                <div style="text-align:center;">
                  <p>Hombres</p>
                  <ul class="list-group list-group-timeline">
                    <li class="list-group-item list-group-timeline-info text-list-color"><strong>Baja estatura:</strong> Menos de 1.60 m</li>
                    <li class="list-group-item list-group-timeline-success text-list-color"><strong>Estatura promedio:</strong> Entre 1.60 y 1.74 m</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Estatura alta:</strong> Entre 1.75 y 1.89 m</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Estatura muy alta:</strong> Más de 1.90 m</li>
                  </ul>
                  <p>Mujeres</p>
                  <ul class="list-group list-group-timeline">
                    <li class="list-group-item list-group-timeline-info text-list-color"><strong>Baja estatura:</strong> Menos de 1.50 m</li>
                    <li class="list-group-item list-group-timeline-success text-list-color"><strong>Estatura promedio:</strong> Entre 1.50 y 1.69 m</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Estatura alta:</strong> Entre 1.70 y 1.80 m</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Estatura muy alta:</strong> Más de 1.80 m</li>
                  </ul>
                </div>
              '>
            </span>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div style="display: flex;align-items: center;">
            <div class="form-floating form-floating-outline">
              <input class="form-control solo_visualizar" id="paciente_datos_consulta-imc" name="paciente_datos_consulta[imc]" type="text" placeholder="Ingresa el I.M.C" readonly />
              <label for="paciente_datos_consulta-imc">I.M.C <i class="text-danger">*</i></label>
            </div>
            <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
              data-bs-content='
                <div style="text-align:center;">
                  <ul class="list-group list-group-timeline">
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Peso bajo:</strong> Menos de 18.5</li>
                    <li class="list-group-item list-group-timeline-success text-list-color"><strong>Peso normal:</strong> Entre 18.5 y 24.9</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Sobrepeso:</strong> Entre 25 y 29.9</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Obesidad 1° (moderada):</strong> Entre 30 y 34.9</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Obesidad 2° (severa):</strong> Entre 35 y 39.9</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Obesidad 3° (extrema):</strong> Más de 40.9</li>
                  </ul>
                </div>
              '>
            </span>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div style="display: flex;align-items: center;">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="paciente_datos_consulta-frecuencia_cardiaca" name="paciente_datos_consulta[frecuencia_cardiaca]" type="text" placeholder="Ingresa la frecuencia cardiaca" />
              <label for="paciente_datos_consulta-frecuencia_cardiaca">Frec. cardiaca (lpm) <i class="text-danger">*</i></label>
            </div>
            <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
              data-bs-content='
                <div style="text-align:center;">
                  <p>En reposo (estado normal)</p>
                  <ul class="list-group list-group-timeline">
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Bradicardia:</strong> Menos de 50 LPM</li>
                    <li class="list-group-item list-group-timeline-success text-list-color"><strong>Normal:</strong> Entre 50 y 100 LPM</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Taquicardia:</strong> Más de 100 LPM</li>
                  </ul>
                </div>
              '>
            </span>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div style="display: flex;align-items: center;">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="paciente_datos_consulta-saturacion_oxigeno" name="paciente_datos_consulta[saturacion_oxigeno]" type="text" placeholder="Ingresa la saturacion de oxigeno" />
              <label for="paciente_datos_consulta-saturacion_oxigeno">Sat. de oxígeno (%) <i class="text-danger">*</i></label>
            </div>
            <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
              data-bs-content='
                <div style="text-align:center;">
                  <ul class="list-group list-group-timeline">
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Hipoxemia grave:</strong> Menos de 90%</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Hipoxemia leve:</strong> Entre 90 y 94 %</li>
                    <li class="list-group-item list-group-timeline-success text-list-color"><strong>Normal:</strong> Entre 95 y 100 %</li>
                  </ul>
                </div>
              '>
            </span>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div style="display: flex;align-items: center;">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="paciente_datos_consulta-presion_arterial" name="paciente_datos_consulta[presion_arterial]" type="text" placeholder="Ingresa la presion arterial" />
              <label for="paciente_datos_consulta-presion_arterial">Presión arterial (mmHg)</label>
            </div>
            <span style="color: #006c39; cursor: pointer;" class="mdi mdi-information" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="popover-primary" data-bs-html="true" data-bs-trigger="hover"
              data-bs-content='
                <div style="text-align:center;">
                  <ul class="list-group list-group-timeline">
                    <li class="list-group-item list-group-timeline-success text-list-color"><strong>Normal:</strong> Menos de 120/80 mmHg</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Elevada:</strong> Entre 120 y 129 / Menos de 80 mmHg</li>
                    <li class="list-group-item list-group-timeline-warning text-list-color"><strong>Hipertensión etapa 1:</strong> Entre 130 y 139 / Entre 80 y 89 mmHg</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Hipertensión etapa 2:</strong> 140 o más / 90 o más mmHg</li>
                    <li class="list-group-item list-group-timeline-danger text-list-color"><strong>Crisis hipertensiva:</strong> Más de 180/120 mmHg</li>
                  </ul>
                </div>
              '>
            </span>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <textarea class="form-control h-px-100" id="paciente_datos_consulta-observaciones" name="paciente_datos_consulta[observaciones]" placeholder="Escribe las observaciones de la consulta..."></textarea>
            <label for="paciente_datos_consulta-observaciones">Observaciones</label>
          </div>
        </div>

        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <textarea class="form-control h-px-100" id="paciente_datos_consulta-medicamento_recetado" name="paciente_datos_consulta[medicamento_recetado]" placeholder="Escribe el medicamento recetado..."></textarea>
            <label for="paciente_datos_consulta-medicamento_recetado">Medicamento recetado</label>
          </div>
        </div>
      </div>

    </form>

    <div class="col-md-12">
      <div class="btn-flex-group" style="position: fixed; bottom: 2rem; right: 0.8rem; z-index: 1080;">
        <a href="/" class="btn btn-principal waves-effect waves-light me-2" type="button" >
          <span class="mdi mdi-home me-2"></span>Inicio
        </a>

        <button class="btn btn-success waves-effect waves-light me-2" id="boton-guardar_valoracion" type="button" style="box-shadow: 0 1px 20px 1px #72e128 !important;">
          <span class="mdi mdi-content-save" style="margin-right: 10px;"></span>Guardar Valoración
        </button>

      </div>
    </div>

  </div>

  {{-- Detalles de la consulta anterior en un modal lateral --}}
  <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="canvasConsultaAnterior" aria-labelledby="canvasConsultaAnteriorLabel" style="width: 500px;">
    <div class="offcanvas-header">
      <h5 id="canvasConsultaAnteriorLabel" class="offcanvas-title"><span class="mdi mdi-table-heart"></span> Parametros de consulta anterior</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
      <ul class="list-group list-group-timeline">
        <li class="list-group-item list-group-timeline-primary"><strong>Motivo de la consulta:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->motivo_consulta) ? $datos_vista['paciente']['datos_ultima_consulta']->motivo_consulta : 'Sin motivo.' }}</li>
        <li class="list-group-item list-group-timeline-success"><strong>CIE-10:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->cie_descripcion) ? $datos_vista['paciente']['datos_ultima_consulta']->cie_descripcion : 'Sin CIE-10' }}.</li>
        <li class="list-group-item list-group-timeline-primary"><strong>Temperatura:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->temperatura) ? $datos_vista['paciente']['datos_ultima_consulta']->temperatura.' °C' : 'Sin temperatura.' }}</li>
        <li class="list-group-item list-group-timeline-success"><strong>Peso:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->peso) ? $datos_vista['paciente']['datos_ultima_consulta']->peso.' Kg' : 'Sin peso.' }}</li>
        <li class="list-group-item list-group-timeline-primary"><strong>Altura:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->altura) ? $datos_vista['paciente']['datos_ultima_consulta']->altura.' m' : 'Sin altura.' }}</li>
        <li class="list-group-item list-group-timeline-success"><strong>IMC:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->imc) ? $datos_vista['paciente']['datos_ultima_consulta']->imc.' kg/m²' : 'Sin IMC.' }}</li>
        <li class="list-group-item list-group-timeline-primary"><strong>Frecuencia cardíaca:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->frecuencia_cardiaca) ? $datos_vista['paciente']['datos_ultima_consulta']->frecuencia_cardiaca.' Lpm' : 'Sin frecuencia.' }}</li>
        <li class="list-group-item list-group-timeline-success"><strong>Saturación de oxígeno:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->saturacion_oxigeno) ? $datos_vista['paciente']['datos_ultima_consulta']->saturacion_oxigeno.' %' : 'Sin saturación.' }}</li>
        <li class="list-group-item list-group-timeline-primary"><strong>Presión arterial:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->presion_arterial) ? $datos_vista['paciente']['datos_ultima_consulta']->presion_arterial.' mmHg' : 'Sin presión.' }}</li>
        <li class="list-group-item list-group-timeline-success"><strong>Observaciones:</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->observaciones) ? $datos_vista['paciente']['datos_ultima_consulta']->observaciones : 'Sin observaciones.' }}</li>
        <li class="list-group-item list-group-timeline-primary"><strong>Medicamento(s) recetado(s):</strong> {{ isset($datos_vista['paciente']['datos_ultima_consulta']->medicamento_recetado) ? $datos_vista['paciente']['datos_ultima_consulta']->medicamento_recetado : 'Sin medicamento.' }}</li>
      </ul>
      <button type="button" class="btn btn-outline-secondary d-grid w-100 mt-5" data-bs-dismiss="offcanvas">Cerrar</button>
    </div>
  </div>
@endsection
