@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Historico clinico')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/historicoClinico/historico.js') }}?v={{ date('YmdHis')}}"></script>
  <script>
    var datos_vista = @json($datos_vista);
  </script>
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
  <!-- Form Validation -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
@endsection

@section('vendor-script')
  <!-- Form Validation -->
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')

  <div class="card p-5" style="width: 100%; height: 100%;">
    <div class="divider">
      <div class="divider-text texto-titulo">Histórico clínico</div>
    </div>

    <form id="form-registra_historico_clinico" method="POST" enctype="multipart/form-data" onSubmit="return false">

      {{-- Tipo de registro de historico --}}
      <div class="row mb-3">
        <div class="col-md-8" style="justify-content: center;">
          <small class="fw-medium d-block me-4"><strong>Tipo de registro: <i class="text-danger">*</i></strong></small>
          <div class="form-check form-check-inline">
            <input class="form-check-input campo_visualizar" type="radio" name="historico_clinico[tipo_registro]" id="historico_clinico-tipo_registro_ingreso"
              value="Ingreso" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['tipo_registro'] == 'Ingreso') ? 'checked' : '' }} />
            <label class="form-check-label" for="historico_clinico-tipo_registro_ingreso">Ingreso</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input campo_visualizar" type="radio" name="historico_clinico[tipo_registro]" id="historico_clinico-tipo_registro_actualizacion"
              value="Actualizacion" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['tipo_registro'] == 'Actualizacion') ? 'checked' : '' }} />
            <label class="form-check-label" for="historico_clinico-tipo_registro_actualizacion">Actualización</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input campo_visualizar" type="radio" name="historico_clinico[tipo_registro]" id="historico_clinico-tipo_registro_solicitud"
              value="A solicitud" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['tipo_registro'] == 'A solicitud') ? 'checked' : '' }} />
            <label class="form-check-label" for="historico_clinico-tipo_registro_solicitud">A solicitud</label>
          </div>
        </div>
        <div class="col-md-4 text-end align-content-end">
          <small class="fw-medium d-block me-4 mb-4"><strong>Fecha: </strong>{{ date('d/m/Y'); }}</small>
        </div>
      </div>

      <div class="bs-stepper wizard-vertical vertical">
        <div class="bs-stepper-header gap-lg-2">

          {{-- Paso para registrar datos generales --}}
          <div class="step" data-target="#step-datos_generales">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"><span class="mdi mdi-file-account mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Datos generales</span>
                </span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          {{-- Paso para registrar contacto de emergencia --}}
          <div class="step" data-target="#step-contacto_emergencia">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"><span class="mdi mdi-card-account-phone mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Contacto para </br>emergencia</span>
                </span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          {{-- Paso para registrar Antecedentes heredofamiliares --}}
          <div class="step" data-target="#step-antecendentes_heredofamiliares">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"> <span class="mdi mdi-family-tree mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Antecedentes </br>heredofamiliares</span>
                </span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          {{-- Paso para registrar Antecedentes personales no patologicos --}}
          <div class="step" data-target="#step-antecendentes_personales_no_patologico">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"> <span class="mdi mdi-account-heart-outline mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Antecedentes </br>personales</br>no patológicos</span>
                </span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          {{-- Paso para registrar Antecedentes personales patologicos --}}
          <div class="step" data-target="#step-antecendentes_personales_patologico">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"> <span class="mdi mdi-virus-outline mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Antecedentes </br>personales</br>patológicos</span>
                </span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          {{-- Paso para registrar Antecedentes laborales --}}
          <div class="step" data-target="#step-antecendentes_laborales">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"> <span class="mdi mdi-briefcase-outline mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Antecedentes </br>laborales</span>
                </span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          {{-- Paso para registrar interrogatorio por aparatos y sistemas --}}
          <div class="step" data-target="#step-interrogatorio_por_aparatos_y_sistemas">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"> <span class="mdi mdi-brain mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Interrogatorio por </br>aparatos y sistemas</span>
                </span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          {{-- Paso para registrar exploracion fisica --}}
          <div class="step" data-target="#step-exploracion_fisica">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"> <span class="mdi mdi-human mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Exploración física</span>
                </span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          {{-- Paso para registrar drogas --}}
          <div class="step" data-target="#step-drogas">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="icon-base ri ri-check-line"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-number"> <span class="mdi mdi-smoking mdi-36px"></span></span>
                <span class="d-flex flex-column gap-1 ms-2">
                  <span class="bs-stepper-title">Drogas</span>
                </span>
              </span>
            </button>
          </div>

        </div>

        <div class="bs-stepper-content">
          {{-- Paso para registrar datos generales --}}
          @include('content.pages.historicoClinico.steps.step-datos_generales')

          {{-- Paso para registrar contacto de emergencia --}}
          @include('content.pages.historicoClinico.steps.step-contacto_emergencia')

          {{-- Paso para registrar Antecedentes heredofamiliares --}}
          @include('content.pages.historicoClinico.steps.step-antecendentes_heredofamiliares')

          {{-- Paso para registrar Antecedentes personales no patologicos --}}
          @include('content.pages.historicoClinico.steps.step-antecendentes_personales_no_patologicos')

          {{-- Paso para registrar Antecedentes personales patologicos --}}
          @include('content.pages.historicoClinico.steps.step-antecendentes_personales_patologico')

          {{-- Paso para registrar Antecedentes personales patologicos --}}
          @include('content.pages.historicoClinico.steps.step-antecendentes_laborales')

          {{-- Paso para registrar interrogatorio por aparatos y sistemas --}}
          @include('content.pages.historicoClinico.steps.step-interrogatorio_por_aparatos_y_sistemas')

          {{-- Paso para registrar exploracion fisica --}}
          @include('content.pages.historicoClinico.steps.step-exploracion_fisica')

          {{-- Paso para registrar drogas --}}
          @include('content.pages.historicoClinico.steps.step-drogas')
        </div>

      </div>

      <p class="lead text-center mt-4" style="font-size: 14px;">
        <b><i>HAGO CONSTAR QUE LOS DATOS AQUÍ PROPORCIONADOS SON VERDAD. EN CASO DE INCURRIR EN ALGUNA FALSEDAD PUEDE SER MOTIVO DE RESECIÓN DE CONTRATO LABORAL SIN RESPONSABILIDAD ALGUNA PARA LA EMPRESA.</i></b>
      </p>

    </form>

    <div class="col-md-12">
      <div class="btn-flex-group" style="position: fixed; bottom: 2rem; right: 0.8rem; z-index: 1080;">
        <a href="/" class="btn btn-principal waves-effect waves-light me-2" type="button" >
          <span class="mdi mdi-home me-2"></span>Inicio
        </a>
      </div>
    </div>

  </div>

@endsection

<style>
  .accordion-collapse {
    overflow: hidden;
    transition: height 0.35s ease;
  }

  .accordion-collapse:not(.show) {
    display: none;
  }
</style>
