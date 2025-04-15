@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Nueva Receta')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/css/recetas/recetas.css') }}">
  <link rel="stylesheet" href="{{asset('assets/css/recetas/impresionReceta.css')}}">
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/recetas/receta.js') }}"></script>

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

@endsection

@section('vendor-script')
  <!-- Form Validation -->
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')

@php
// dd($datos_vista);
@endphp

  <div class="card p-5 ajuste-hoja-impresion" style="width: 100%; height: 100%;">

    <div class="divider no-imprimir {{ $datos_vista['receta_existente']['id']?'d-none':'' }}">
      <div class="divider-text texto-titulo">Crear receta para el paciente</div>
    </div>

    <form id="form-receta" method="POST" enctype="multipart/form-data" onSubmit="return false">
      @csrf
      <div class="row no-imprimir {{ $datos_vista['receta_existente']['id']?'d-none':'' }}" style="justify-content: center; align-items: center;">

        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select select2" id="receta-paciente_id" name="receta[paciente_id]" onchange="colocarPacienteEnReceta(this)">
              <option value="" selected disabled>Selecciona una opción</option>
              @foreach ($datos_vista['pacientes'] as $pacientes)
              <option value="{{ $pacientes['id'] }}"
              {{ isset($datos_vista['receta_existente']['paciente_id']) && $datos_vista['receta_existente']['paciente_id'] == $pacientes['id'] ? 'selected' : '' }}>
              {{ $pacientes['nombre'].' '.$pacientes['apellido_paterno'].' '.$pacientes['apellido_materno'] }}
            </option>
              @endforeach
            </select>
            <label for="receta-paciente_id">Paciente <i class="text-danger">*</i></label>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="editor-con-marca"></div>
        <div class="divider divider-dark">
          <div class="divider-text">-</div>
        </div>

        <img src="{{ asset('assets/img/logos/agzback.png') }}" alt="Logo" class="logo-superior-receta">

        <div class="col-md-12 text-center">
          <label style="position: absolute; right: 0;"><strong>C.P.</strong> {{ Auth::user()->cedula_profesional }}</label>
          <h3>Dr. {{ Auth::user()->nombre.' '.Auth::user()->apellido_paterno.' '.Auth::user()->apellido_materno }}</h3>
          <label style="position: absolute; right: 0;"><strong>REG.SSA.</strong> {{ Auth::user()->registro_ssa }}</label>
          <h4 style="color: #b1b0b0">Médico General</h4>
        </div>

        <div class="divider divider-dark">
          <div class="divider-text">-</div>
        </div>

        <div class="col-md-12">
          <p class="text-danger" style="position: absolute; right: 0;" id="receta-folio">#F-{{ $datos_vista['receta_existente']['id']?$datos_vista['receta_existente']['id']:$datos_vista['folio'] }}</p>
          <h4 style="color: #b1b0b0">RECETA MEDICA</h4>
          <p style="position: absolute; right: 0;">Fecha: {{ now()->format('d/m/Y') }}</p>
          <p>Nombre: <label id="paciente_receta-nombre">{{ $datos_vista['receta_existente']['paciente_nombre']?$datos_vista['receta_existente']['paciente_nombre'].' '.$datos_vista['receta_existente']['paciente_apellido_p'].' '.$datos_vista['receta_existente']['paciente_apellido_m']:'' }}</label></p>
          <p style="position: absolute; right: 0;">Hora: {{ now()->format('H:m:s') }}</p>
          <p>Edad: <label id="paciente_receta-edad"></label>{{ $datos_vista['receta_existente']['paciente_edad']?$datos_vista['receta_existente']['paciente_edad']:'' }} años</p>
        </div>

        <div class="col-md-12">
          <p class="text-center" style="background: #eee;"><strong>Medicamentos e indicaciones</strong></p>
        </div>
        <div class="col-md-12">
          <textarea {{ $datos_vista['receta_existente']['id']?'disabled':'' }} id="receta-medicamento_indicaciones" name="receta[medicamento_indicaciones]" cols="30" rows="5" style="border: none; background: transparent; outline: none; width: 100%;">{{ $datos_vista['receta_existente']['medicamento']?$datos_vista['receta_existente']['medicamento']:'' }}</textarea>
        </div>
        <div class="col-md-12">
          <p class="text-center" style="background: #eee;"><strong>Recomendaciones generales</strong></p>
        </div>
        <div class="col-md-12">
          <textarea {{ $datos_vista['receta_existente']['id']?'disabled':'' }} id="receta-recomendaciones" name="receta[recomendaciones]" class="mb-5" cols="30" rows="5" style="border: none; background: transparent; outline: none; width: 100%;">{{ $datos_vista['receta_existente']['recomendaciones']?$datos_vista['receta_existente']['recomendaciones']:'' }}</textarea>
        </div>

        <div class="row mt-5">
          <div class="col-md-6"></div>
          <div class="col-md-6 text-center">
            <div class="firma-contenedor">
              <div class="firma-linea"></div>
              <p class="firma-texto">Dr. {{ Auth::user()->nombre.' '.Auth::user()->apellido_paterno.' '.Auth::user()->apellido_materno }}</br>Firma o Sello</p>
            </div>
          </div>
        </div>

        <div class="divider divider-dark">
          <div class="divider-text">-</div>
        </div>

      </div>
    </form>

    <div class="row mt-5 no-imprimir {{ $datos_vista['receta_existente']['id']?'d-none':'' }}">
      <div class="col-md-12 mb-4 text-end">
        <button id="boton-imprimir_receta" type="button" class="btn btn-warning me-2">
          <span class="mdi mdi-printer" style="margin-right: 10px;"></span>Imprimir receta
        </button>
      </div>
    </div>

    <div class="col-md-12 no-imprimir">
      <div class="btn-flex-group" style="position: fixed; bottom: 2rem; right: 0.8rem; z-index: 1080;">
        <a href="/" class="btn btn-principal waves-effect waves-light me-2" type="button" >
          <span class="mdi mdi-home me-2"></span>Inicio
        </a>
      </div>
    </div>
  </div>
@endsection
