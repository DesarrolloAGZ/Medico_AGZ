@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Nuevo Paciente')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/pacientes/pacientes.js') }}?v={{ date('YmdHis')}}"></script>
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
  <div class="card p-5" style="width: 100%; height: 100%;">

    <div id="contenedor_buscador_empleado">
      <div class="divider">
        <div class="divider-text texto-titulo">Buscar paciente</div>
      </div>

      <form id="form-filtros_buscar_paciente" method="POST" enctype="multipart/form-data" onSubmit="return false">
        @csrf
        <div class="row" style="justify-content: center; align-items: center;">

          <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="form-floating form-floating-outline">
              <input type="number" class="form-control" id="filtro-paciente_numero_gafete" name="filtro[paciente_numero_gafete]" placeholder="Ingresa el número de gafete." />
              <label for="filtro-paciente_numero_gafete"># Empleado</label>
            </div>
          </div>

          <div class="col-lg-2 col-md-2 col-sm-12 mb-4">
            <button id="boton-buscar_paciente" type="button" class="btn btn-info me-2">
              <span class="mdi mdi-magnify" style="margin-right: 10px;"></span>Buscar
            </button>
          </div>

        </div>
      </form>
    </div>

    <div class="divider">
      <div class="divider-text texto-titulo">Registrar Nuevo Paciente</div>
    </div>

    <form></form>

    <form id="form-registrar_nuevo_paciente" method="POST" enctype="multipart/form-data" onSubmit="return false">
      @csrf

      <input id="paciente_id" type="text" style="display: none;">

      <div class="row">

        <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline">
            <input readonly type="text" class="form-control" id="paciente-gafete" name="paciente[gafete]" placeholder="Ingresa el número de gafete." />
            <label for="paciente-gafete"># Empleado <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-9 col-md-8 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline">
            <input readonly type="text" class="form-control" id="paciente-nombre" name="paciente[nombre]" placeholder="Ingresa el nombre completo del paciente." />
            <label for="paciente-nombre">Nombre (s) <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline">
            <input readonly type="text" class="form-control" id="paciente-apellido_paterno" name="paciente[apellido_paterno]" placeholder="Ingresa el apellido paterno del paciente." />
            <label for="paciente-apellido_paterno">Apellido Paterno <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline">
            <input readonly type="text" class="form-control" id="paciente-apellido_materno" name="paciente[apellido_materno]" placeholder="Ingresa el apellido materno del paciente." />
            <label for="paciente-apellido_materno">Apellido Materno <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-4 col-md-5 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline">
            <select readonly multiple class="form-select h-px-100 select2" id="paciente-genero" name="paciente[genero]" aria-label="Multiple select example">
              <option value="" selected disabled>Selecciona una opción</option>
              <option value="M">Hombre</option>
              <option value="F">Mujer</option>
            </select>
            <label for="paciente-genero">Género <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-6 col-md-7 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <input class="form-control" id="paciente-celular" name="paciente[celular]" type="tel" placeholder="Ingresa un número celular de contacto" />
            <label for="paciente-celular">Número Celular</label>
          </div>
        </div>

        <div class="col-lg-2 col-md-4 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline">
            <input class="form-control" id="paciente-edad" name="paciente[edad]" type="number" placeholder="Ingresa la edad del paciente" />
            <label for="paciente-edad">Edad <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-6 col-md-8 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" id="paciente-curp" name="paciente[curp]" class="form-control" placeholder="Ingresa el CURP del paciente." />
            <label for="paciente-curp">CURP</label>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select select2" id="paciente-paciente_empresa_id" name="paciente[paciente_empresa_id]">
              <option value="" selected disabled>Selecciona una opción</option>
              @foreach ($datos_vista['catalogos']['empresas'] as $empresa)
                <option value="{{ $empresa['id'] }}">
                  {{ $empresa['nombre'] }}
                </option>
              @endforeach
            </select>
            <label for="paciente-paciente_empresa_id">Empresa <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select select2" id="paciente-paciente_unidad_negocio_id" name="paciente[paciente_unidad_negocio_id]">
              <option value="" selected disabled>Selecciona una opción</option>
              @foreach ($datos_vista['catalogos']['unidad_negocio'] as $unidad_negocio)
                <option value="{{ $unidad_negocio['id'] }}">
                  {{ $unidad_negocio['nombre'] }}
                </option>
              @endforeach
            </select>
            <label for="paciente-paciente_unidad_negocio_id">Unidad de negocio <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select select2" id="paciente-paciente_area_id" name="paciente[paciente_area_id]">
              <option value="" selected disabled>Selecciona una opción</option>
              @foreach ($datos_vista['catalogos']['area'] as $area)
                <option value="{{ $area['id'] }}">
                  {{ $area['nombre'] }}
                </option>
              @endforeach
            </select>
            <label for="paciente-paciente_area_id">Area <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select select2" id="paciente-paciente_subarea_id" name="paciente[paciente_subarea_id]">
              <option value="" selected disabled>Selecciona una opción</option>
              @foreach ($datos_vista['catalogos']['subarea'] as $subarea)
                <option value="{{ $subarea['id'] }}">
                  {{ $subarea['nombre'] }}
                </option>
              @endforeach
            </select>
            <label for="paciente-paciente_subarea_id">Subarea <i class="text-danger">*</i></label>
          </div>
        </div>

      </div>
    </form>

    <div class="col-lg-12">
      <div class="btn-flex-group" style="position: fixed; bottom: 2rem; right: 0.8rem; z-index: 1080;">
        <a href="/" class="btn btn-principal waves-effect waves-light me-2" type="button" >
          <span class="mdi mdi-home me-2"></span>Inicio
        </a>

        <button class="btn btn-success waves-effect waves-light me-2" id="boton-registrar_paciente" type="button" style="box-shadow: 0 1px 20px 1px #72e128 !important;">
          <span class="mdi mdi-content-save" style="margin-right: 10px;"></span>Registrar Paciente
        </button>

        <button class="btn btn-warning waves-effect waves-light me-2" id="boton-continuar_valoracion" type="button" style="box-shadow: 0 1px 20px 1px #fdb528 !important; display: none !important;">
          <span class="mdi mdi-medical-cotton-swab" style="margin-right: 10px;"></span>Continuar valoración
        </button>
      </div>
    </div>

  </div>
@endsection
