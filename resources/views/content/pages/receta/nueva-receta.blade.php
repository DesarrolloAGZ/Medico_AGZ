@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Nueva Receta')

@section('page-style')
  <link rel="stylesheet" href="{{ asset('assets/css/recetas/recetas.css') }}?v={{ date('YmdHis')}}">
  <link rel="stylesheet" href="{{asset('assets/css/recetas/impresionReceta.css') }}?v={{ date('YmdHis')}}">

  <style>
    .editor-con-marca::before {
      content: '' !important;
      position: absolute !important;
      top: 0 !important;
      left: 0 !important;
      width: 100% !important;
      height: 100% !important;
      background-image: url('{{ env('APP_URL') }}/assets/img/logos/agzback.png') !important;
      background-repeat: no-repeat !important;
      background-position: center !important;
      background-size: 50% auto !important;
      opacity: 0.08 !important;
      pointer-events: none !important;
      z-index: 0 !important;
    }
    .list-group-timeline-item {
      border-left: 3px solid #7367f0;
      margin-bottom: 10px;
    }

    .list-group-timeline-item:hover {
      background-color: #eae9f1;
      border-radius: 10px;
    }
    #canvasMedicamentos{
      zoom: 0.8;
    }
    #form-receta{
      zoom: 0.8;
    }
  </style>
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/recetas/receta.js') }}?v={{ date('YmdHis')}}"></script>

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
// dd(Auth::user());
@endphp

  <div class="card p-5 ajuste-hoja-impresion" style="width: 100%; height: 100%;">

    <div class="divider no-imprimir {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ? 'd-none' : '' }}">
      <div class="divider-text texto-titulo">Crear receta para el paciente</div>
    </div>

    <form id="form-receta" method="POST" enctype="multipart/form-data" onSubmit="return false">
      @csrf
      <div class="row no-imprimir {{ (!empty($datos_vista['detalles_receta']) && isset($datos_vista['detalles_receta'][0]['receta_id'])) ? 'd-none' : '' }}" style="justify-content: center; align-items: center;">
        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select select2 form-select-sm" id="empleado-gafete" name="empleado[gafete]" onchange="colocarPacienteEnReceta(this)">
              <option value="" selected disabled>Selecciona una opción</option>
              @foreach ($datos_vista['todos_empleados_apsi'] as $empleado)
                <option
                  value="{{ $empleado['codigo'] }}" data-genero="{{ $empleado['sexo'] }}" data-curp="{{ $empleado['curp'] }}"
                  data-nombre="{{ $empleado['nombre'] }}" data-ap_paterno="{{ $empleado['ap_paterno'] }}"
                  data-ap_materno="{{ $empleado['ap_materno'] }}"
                  {{ isset($datos_vista['detalles_receta']['paciente_gafete']) && $datos_vista['detalles_receta']['paciente_gafete'] == $empleado['codigo'] ? 'selected' : '' }}>
                  {{ $empleado['nombre'].' '.$empleado['ap_paterno'].' '.$empleado['ap_materno'] }}
                </option>
              @endforeach
            </select>
            <label for="empleado-gafete">Paciente <i class="text-danger">*</i></label>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="editor-con-marca"></div>
        <div class="divider divider-dark">
          <div class="divider-text">-</div>
        </div>

        <img src="{{ asset('assets/img/logos/agzback.png') }}" alt="Logo" class="logo-superior-receta">

        <div class="col-md-12 text-center {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ?'d-none':'' }}">
          <label style="position: absolute; right: 0;"><strong>C.P.</strong> {{ Auth::user()->cedula_profesional }}</label>
          <h3>Dr. {{ Auth::user()->nombre.' '.Auth::user()->apellido_paterno.' '.Auth::user()->apellido_materno }}</h3>
          <label style="position: absolute; right: 0;"><strong>REG.SSA.</strong> {{ Auth::user()->registro_ssa }}</label>
          @if (Auth::user()->usuario_perfil_id == 1)
            <h4 style="color: #b1b0b0">MEDICO GENERAL</h4>
          @endif
          @if (Auth::user()->usuario_perfil_id == 2)
            <h4 style="color: #b1b0b0">MEDICO ESPECIALISTA</h4>
          @endif
        </div>

        <div class="col-md-12 text-center {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ? '' : 'd-none' }}">
          <label style="position: absolute; right: 0;"><strong>C.P.</strong> {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['cedula_profesional']) ? $datos_vista['detalles_receta'][0]['cedula_profesional'] : '' }}</label>
          <h3>Dr. {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['usuario_creados_nombre']) ? $datos_vista['detalles_receta'][0]['usuario_creados_nombre'] . ' ' . $datos_vista['detalles_receta'][0]['usuario_creador_apellido_p'] . ' ' . $datos_vista['detalles_receta'][0]['usuario_creador_apellido_m'] : '' }}</h3>
          <label style="position: absolute; right: 0;"><strong>REG.SSA.</strong> {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['registro_ssa']) ? $datos_vista['detalles_receta'][0]['registro_ssa'] : '' }}</label>
          @if (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['usuario_perfil_id'] == 1)
            <h4 style="color: #b1b0b0">MEDICO GENERAL</h4>
          @endif
          @if (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['usuario_perfil_id'] == 2)
            <h4 style="color: #b1b0b0">MEDICO ESPECIALISTA</h4>
          @endif
        </div>

        <div class="divider divider-dark">
          <div class="divider-text">-</div>
        </div>

        <div class="col-md-12">
          <p class="text-danger" style="position: absolute; right: 0;" id="receta-folio">#F-{{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ? $datos_vista['detalles_receta'][0]['receta_id'] : $datos_vista['folio'] }}</p>
          <h4 style="color: #b1b0b0">RECETA MEDICA</h4>
          <p style="position: absolute; right: 0;">Fecha: {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['fecha_creacion']) ? date('d/m/Y', strtotime($datos_vista['detalles_receta'][0]['fecha_creacion'])) : now()->format('d/m/Y') }}</p>
          <p>Nombre: <label id="paciente_receta-nombre">{{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['paciente_nombre']) ? $datos_vista['detalles_receta'][0]['paciente_nombre'].' '.$datos_vista['detalles_receta'][0]['paciente_apellido_p'].' '.$datos_vista['detalles_receta'][0]['paciente_apellido_m']:'' }}</label></p>
          <p style="position: absolute; right: 0;">Hora: {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['fecha_creacion']) ? date('H:i', strtotime($datos_vista['detalles_receta'][0]['fecha_creacion'])) : now()->format('H:m:s') }}</p>
          <p>Edad: <label id="paciente_receta-edad"></label>{{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['paciente_edad']) ? $datos_vista['detalles_receta'][0]['paciente_edad']:'' }} años</p>
        </div>

        <div class="col-md-12">
          <p class="text-center" style="background: #eee;"><strong>Medicamentos</strong></p>
        </div>
        <div class="col-md-12" id="contenedor-medicamentos" style="min-height: 100px;">
          <div class="container" style="width: 100%;padding: 0;margin: 0;display: contents; font-weight: bold; font-size: 16px;">
            {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['medicamentos_txt']) ? $datos_vista['detalles_receta'][0]['medicamentos_txt'] : '' }}
          </div>
        </div>
        <div class="col-md-12 text-center no-imprimir {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ? 'd-none' : '' }}">
          <button type="button" class="btn btn-label-info mb-4 mt-4 btn-sm" id="boton-obtener_listado_medicamentos">Agregar medicamento</button>
        </div>

        <div class="col-md-12">
          <p class="text-center" style="background: #eee;"><strong>Indicaciones del medicamento</strong></p>
        </div>
        <div class="col-md-12" style="font-size: 17px;">
          <textarea {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ? 'disabled' : '' }} id="receta-medicamento_indicaciones" name="receta[medicamento_indicaciones]" cols="30" rows="5" style="border: none; background: transparent; outline: none; width: 100%;">{{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['medicamento']) ? $datos_vista['detalles_receta'][0]['medicamento']:'' }}</textarea>
        </div>

        <div class="col-md-12">
          <p class="text-center" style="background: #eee;"><strong>Recomendaciones generales</strong></p>
        </div>
        <div class="col-md-12" style="font-size: 17px;">
          <textarea {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ?'disabled':'' }} id="receta-recomendaciones" name="receta[recomendaciones]" class="mb-5" cols="30" rows="5" style="border: none; background: transparent; outline: none; width: 100%;">{{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['recomendaciones']) ? $datos_vista['detalles_receta'][0]['recomendaciones'] : '' }}</textarea>
        </div>

        <div class="row mt-5">
          <div class="col-md-6"></div>
          <div class="col-md-6 text-center">
            <div class="firma-contenedor">
              <div class="firma-linea"></div>
              <p class="firma-texto {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ? 'd-none' : '' }}">Dr. {{ Auth::user()->nombre.' '.Auth::user()->apellido_paterno.' '.Auth::user()->apellido_materno }}</br>Firma o Sello</p>
              <p class="firma-texto {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ? '' : 'd-none' }}">Dr. {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['usuario_creados_nombre']) ? $datos_vista['detalles_receta'][0]['usuario_creados_nombre'] . ' ' . $datos_vista['detalles_receta'][0]['usuario_creador_apellido_p'] . ' ' . $datos_vista['detalles_receta'][0]['usuario_creador_apellido_m'] : '' }}</br>Firma o Sello</p>
            </div>
          </div>
        </div>

        <div class="divider divider-dark">
          <div class="divider-text">-</div>
        </div>

      </div>
    </form>

    <div class="row mt-5 no-imprimir {{ (isset($datos_vista['detalles_receta']) && $datos_vista['detalles_receta'][0]['receta_id']) ? 'd-none' : '' }}">
      <div class="col-md-12 mb-4 text-end">
        <button id="boton-imprimir_receta" type="button" class="btn btn-warning me-2">
          <span class="mdi mdi-printer" style="margin-right: 10px;"></span>Guardar e imprimir receta
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

  {{-- Listado del medicamento en un modal lateral --}}
  <div class="offcanvas offcanvas-end no-imprimir" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="canvasMedicamentos" aria-labelledby="canvasMedicamentosLabel" style="width: 700px;">
    <div class="offcanvas-header">
      <h5 id="canvasMedicamentosLabel" class="offcanvas-title"><span class="mdi mdi-format-list-bulleted-square"></span> Listado de medicamentos</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-0 d-flex flex-column">
      <!-- Sección FIJA (sin scroll) -->
      <div class="p-3 border-bottom bg-white" style="flex-shrink: 0;">
        <div class="row justify-content-center">
          <div class="col-md-12 mb-3">
            <div class="form-floating form-floating-outline">
              <select class="form-select form-select-sm" id="almacen_medicamentos" name="almacen_medicamentos" onchange="obtenerCatalogoMedicamentosHispatec()">
                <option value="" selected disabled>Selecciona una opción</option>
                @foreach ($datos_vista['usuario_almacenes'] as $almacen)
                  <option value="{{ $almacen['almacen_id'] }}" data-empresa_id="{{$almacen['empresa_id']}}" data-almacen_codigo="{{$almacen['almacen_codigo']}}">
                    {{ $almacen['almacen_codigo'] }} - {{ $almacen['almacen_nombre'] }} ({{ $almacen['empresa_nombre'] }})
                  </option>
                @endforeach
              </select>
              <label for="almacen_medicamentos">Almacén <i class="text-danger">*</i></label>
            </div>
          </div>
        </div>

        <div class="row justify-content-center" id="contenedor-filtros-medicamento" style="display: none;">
          <div class="col-md-12">
            <div class="form-floating form-floating-outline">
              <input type="text" id="filtro-medicamento" name="filtro-medicamento" class="form-control" placeholder="Ingresa el medicamento a buscar." />
              <label for="filtro-medicamento">Buscar medicamento</label>
            </div>
          </div>
        </div>
      </div>

      <!-- Sección con SCROLL (solo la lista) -->
      <div class="flex-grow-1" style="overflow-y: auto;">
        <div class="p-3">
          <ul class="list-group list-group-timeline" id="listado-medicamentos-receta">
          </ul>
        </div>
      </div>
    </div>

    <div class="offcanvas-footer p-3 border-top bg-white">
      <button type="button" class="btn btn-outline-danger w-100" data-bs-dismiss="offcanvas">
        Cerrar
      </button>
    </div>
  </div>
@endsection
