@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Nuevo Paciente')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/pacientes/pacientes.js') }}"></script>
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}">
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.full.min.js') }}" >
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}" >
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}" >
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}" >
@endsection

@section('content')
  <div class="card p-5" style="width: 100%; height: 100%;">

    <div class="divider">
      <div class="divider-text">Buscar paciente</div>
    </div>

    <form id="form-filtros_buscar_paciente" method="POST" action="return false">
      @csrf
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <div class="row">

        <div class="col-md-2 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="number" class="form-control" id="filtro-paciente_numero_gafete" name="filtro[paciente_numero_gafete]" placeholder="Ingresa el número de gafete." />
            <label for="filtro-paciente_numero_gafete">Número de gafete</label>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="filtro-paciente_nombre" name="filtro[paciente_nombre]" placeholder="Ingresa el nombre del paciente." />
            <label for="filtro-paciente_nombre">Nombre</label>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="filtro-paciente_apellido_paterno" name="filtro[paciente_apellido_paterno]" placeholder="Ingresa el apellido paterno del paciente." />
            <label for="filtro-paciente_apellido_paterno">Apellido Paterno</label>
          </div>
        </div>

        <div class="col-md-3 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="filtro-paciente_apellido_materno" name="filtro[paciente_apellido_materno]" placeholder="Ingresa el apellido materno del paciente." />
            <label for="filtro-paciente_apellido_materno">Apellido Materno</label>
          </div>
        </div>

      </div
    </form>

    <button id="boton-buscar_paciente" type="button" class="btn btn-info me-2">
      <span class="mdi mdi-magnify" style="margin-right: 10px;"></span>Buscar
    </button>

    <div class="divider">
      <div class="divider-text">Registrar Nuevo Paciente</div>
    </div>

    <form id="form-nuevo_paciente" action="return false">
      <div class="row">

        <div class="col-md-12 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="paciente-nombre" name="paciente[nombre]" placeholder="Ingresa el nombre completo del paciente." />
            <label for="paciente-nombre">Nombre (s) <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="paciente-apellido_paterno" name="paciente[apellido_paterno]" placeholder="Ingresa el apellido paterno del paciente." />
            <label for="paciente-apellido_paterno">Apellido Paterno <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="paciente-apellido_materno" name="paciente[apellido_materno]" placeholder="Ingresa el apellido materno del paciente." />
            <label for="paciente-apellido_materno">Apellido Materno <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-4 mb-4">
          <div class="form-floating form-floating-outline">
            <select multiple class="form-select h-px-100" id="paciente-genero" name="paciente[genero]" aria-label="Multiple select example">
              <option value="" selected disabled>Selecciona una opción</option>
              <option value="1">Hombre</option>
              <option value="2">Mujer</option>
            </select>
            <label for="paciente-genero">Género <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <input class="form-control" id="paciente-celular" name="paciente[celular]" type="tel" placeholder="Ingresa un número celular de contacto" />
            <label for="paciente-celular">Número Celular</label>
          </div>
        </div>

        <div class="col-md-2 mb-4">
          <div class="form-floating form-floating-outline">
            <input class="form-control" id="paciente-edad" name="paciente[edad]" type="number" placeholder="Ingresa la edad del paciente" />
            <label for="paciente-edad">Edad <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline">
            <input type="text" id="paciente-curp" name="paciente[curp]" class="form-control" placeholder="Ingresa el CURP del paciente." />
            <label for="paciente-curp">CURP</label>
          </div>
        </div>

        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select" id="paciente-ocupacion" name="paciente[ocupacion]" aria-label="Default select example">
              <option value="" selected disabled>Selecciona una opción</option>
              <option value="1">opcion 1</option>
              <option value="2">opcion 2</option>
              <option value="3">opcion 3</option>
            </select>
            <label for="paciente-ocupacion">Ocupación <i class="text-danger">*</i></label>
          </div>
        </div>

      </div>
    </form>

    <button id="boton-registrar_paciente" type="button" class="btn btn-success me-2" style="position: fixed; bottom: 0; right: 0; margin: 20px; box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;">
      <span class="mdi mdi-content-save" style="margin-right: 10px;"></span>Registrar Paciente
    </button>

  </div>
@endsection
