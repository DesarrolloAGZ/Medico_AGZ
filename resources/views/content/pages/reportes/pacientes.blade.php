@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Reporte pacientes')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/reportes/pacientes.js') }}?v={{ date('YmdHis')}}"></script>
  <script>
    var datos_vista = @json($datos_vista);
  </script>
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
 <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')
<div class="card p-5">

  <div class="divider">
    <div class="divider-text texto-titulo">Reporte de pacientes</div><br>
  </div>

  <form id="form-reporte_pacientes" method="POST" enctype="multipart/form-data" onSubmit="return false">

    <div class="divider text-start">
      <div class="divider-text"><span class="mdi mdi-filter-multiple me-2"></span>Filtros para generar reporte de pacientes</div>
    </div>

    <div class="row mt-2 mb-4">
      <div class="col-lg-2 col-md-3 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline">
          <input type="date" class="form-control" id="filtro-fecha_inicio" placeholder="Selecciona la fecha inicial." />
          <label for="filtro-fecha_inicio">Fecha inicio</label>
        </div>
      </div>
      <div class="col-lg-2 col-md-3 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline">
          <input type="date" class="form-control" id="filtro-fecha_fin" placeholder="Selecciona la fecha final." />
          <label for="filtro-fecha_fin">Fecha fin</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-nombre_paciente">
            <option value="" selected disabled>Selecciona una opción</option>
            @foreach ($datos_vista['catalogos']['pacientes'] as $gafete)
              <option value="{{ $gafete['id'] }}">{{ $gafete['nombre'].' '.$gafete['apellido_paterno'].' '. $gafete['apellido_materno']}}</option>
            @endforeach
          </select>
          <label for="filtro-nombre_paciente">Nombre de paciente</label>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-edad">
            <option value="" selected disabled>Selecciona una opción</option>
            @for ($edad = 1; $edad <= 100; $edad++)
              <option value="{{ $edad }}">{{ $edad }} años</option>
            @endfor
          </select>
          <label for="filtro-edad">Edad</label>
        </div>
      </div>
      <div class="col-lg-2 col-md-2 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-genero">
            <option value="" selected disabled>Selecciona una opción</option>
            <option value="F">Femenino</option>
            <option value="M">Masculino</option>
          </select>
          <label for="filtro-genero">Genero</label>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-empresa">
            <option value="" selected disabled>Selecciona una opción</option>
            @foreach ($datos_vista['catalogos']['empresa'] as $empresa)
              <option value="{{ $empresa['id'] }}">{{ $empresa['nombre'] }}</option>
            @endforeach
          </select>
          <label for="filtro-empresa">Empresa</label>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-unidad_negocio">
            <option value="" selected disabled>Selecciona una opción</option>
            @foreach ($datos_vista['catalogos']['unidad_negocio'] as $unidad_negocio)
              <option value="{{ $unidad_negocio['id'] }}">{{ $unidad_negocio['nombre'] }}</option>
            @endforeach
          </select>
          <label for="filtro-unidad_negocio">Unidad de negocio</label>
        </div>
      </div>
      <div class="col-lg-3 col-md-5 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-area">
            <option value="" selected disabled>Selecciona una opción</option>
            @foreach ($datos_vista['catalogos']['area'] as $area)
              <option value="{{ $area['id'] }}">{{ $area['nombre'] }}</option>
            @endforeach
          </select>
          <label for="filtro-area">Area</label>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-subarea">
            <option value="" selected disabled>Selecciona una opción</option>
            @foreach ($datos_vista['catalogos']['subarea'] as $subarea)
              <option value="{{ $subarea['id'] }}">{{ $subarea['nombre'] }}</option>
            @endforeach
          </select>
          <label for="filtro-subarea">Subarea</label>
        </div>
      </div>
      <div class="col-lg-1 col-md-1 col-sm-12 mb-3" style="text-align: end;">
        <button type="button" class="btn btn-sm btn-secondary mb-3" id="boton-limpiar_filtros_reporte_pacientes">
          <i class="mdi mdi-filter-off"></i>
        </button>
      </div>
    </div>

    <div class="divider text-start">
      <div class="divider-text"><span class="mdi mdi-table-column-width me-2"></span>Selección de columnas para el reporte</div>
    </div>

    <div class="row">
      <div class="col-md-12" style="text-align: end;">
        <button type="button" class="btn btn-sm btn-primary mb-3" id="boton-seleccionar_todas_columnas_reporte_pacientes">
          Seleccionar todas
        </button>
      </div>
    </div>

    <div class="row">

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_gafete" value="paciente_gafete" />
          <label class="form-check-label" for="paciente_gafete">Gafete paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_nombre" value="paciente_nombre" />
          <label class="form-check-label" for="paciente_nombre">Nombre paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_apellido_paterno" value="paciente_apellido_paterno" />
          <label class="form-check-label" for="paciente_apellido_paterno">Ap. paterno paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_apellido_materno" value="paciente_apellido_materno" />
          <label class="form-check-label" for="paciente_apellido_materno">Ap. materno paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_genero" value="paciente_genero" />
          <label class="form-check-label" for="paciente_genero">Género del paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_edad" value="paciente_edad" />
          <label class="form-check-label" for="paciente_edad">Edad del paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_telefono" value="paciente_telefono" />
          <label class="form-check-label" for="paciente_telefono">Teléfono del paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_curp" value="paciente_curp" />
          <label class="form-check-label" for="paciente_curp">CURP paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_empresa" value="paciente_empresa" />
          <label class="form-check-label" for="paciente_empresa">Empresa</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_unidad_negocio" value="paciente_unidad_negocio" />
          <label class="form-check-label" for="paciente_unidad_negocio">Unidad de negocio</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_area" value="paciente_area" />
          <label class="form-check-label" for="paciente_area">Area</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="paciente_subarea" value="paciente_subarea" />
          <label class="form-check-label" for="paciente_subarea">Subarea</label>
        </div>
      </div>

    </div>

  </form>

  <div class="row mt-4">
    <div class="col-md-12" style="text-align: center">
      <button id="boton-generar_reporte_pacientes" type="button" class="btn btn-success"><span class="mdi mdi-file-excel me-2"></span>Generar reporte</button>
    </div>
  </div>

</div>
@endsection
