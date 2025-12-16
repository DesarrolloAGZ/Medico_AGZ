@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Reporte recetas')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/reportes/recetas.js') }}?v={{ date('YmdHis')}}"></script>
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
    <div class="divider-text texto-titulo">Reporte de recetas</div><br>
  </div>

  <form id="form-reporte_recetas" method="POST" enctype="multipart/form-data" onSubmit="return false">

    <div class="divider text-start">
      <div class="divider-text"><span class="mdi mdi-filter-multiple me-2"></span>Filtros para generar reporte de recetas</div>
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
      <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-nombre_paciente">
            <option value="" selected disabled>Selecciona una opción</option>
            @foreach ($datos_vista['catalogos']['pacientes'] as $gafete)
              <option value="{{ $gafete['id'] }}">{{ '#'.$gafete['gafete'].' - '.$gafete['nombre'].' '.$gafete['apellido_paterno'].' '. $gafete['apellido_materno']}}</option>
            @endforeach
          </select>
          <label for="filtro-nombre_paciente">Nombre de paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-11 col-sm-12 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-medico">
            <option value="" selected disabled>Selecciona una opción</option>
            @foreach ($datos_vista['catalogos']['medico_tratante'] as $medico)
              <option value="{{ $medico['id'] }}">{{ $medico['nombre'].' '.$medico['apellido_paterno'].' '.$medico['apellido_materno']}}</option>
            @endforeach
          </select>
          <label for="filtro-medico">Médico tratante</label>
        </div>
      </div>
      <div class="col-lg-1 col-md-1 col-sm-12 mb-3" style="text-align: end;">
        <button type="button" class="btn btn-sm btn-secondary mb-3" id="boton-limpiar_filtros_reporte_recetas">
          <i class="mdi mdi-filter-off"></i>
        </button>
      </div>
    </div>

    <div class="divider text-start">
      <div class="divider-text"><span class="mdi mdi-table-column-width me-2"></span>Selección de columnas para el reporte</div>
    </div>

    <div class="row">
      <div class="col-md-12" style="text-align: end;">
        <button type="button" class="btn btn-sm btn-primary mb-3" id="boton-seleccionar_todas_columnas_reporte_recetas">
          Seleccionar todas
        </button>
      </div>
    </div>

    <div class="row">

      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="fecha_creacion" value="fecha_creacion" />
          <label class="form-check-label" for="fecha_creacion">Fecha</label>
        </div>
      </div>
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
          <input class="form-check-input" type="checkbox" id="paciente_curp" value="paciente_curp" />
          <label class="form-check-label" for="paciente_curp">CURP paciente</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="medico_tratante_nombre" value="medico_tratante_nombre" />
          <label class="form-check-label" for="medico_tratante_nombre">Nombre médico tratante</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="medico_tratante_apellido_paterno" value="medico_tratante_apellido_paterno" />
          <label class="form-check-label" for="medico_tratante_apellido_paterno">Ap. paterno médico tratante</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="medico_tratante_apellido_materno" value="medico_tratante_apellido_materno" />
          <label class="form-check-label" for="medico_tratante_apellido_materno">Ap. materno médico tratante</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="medico_tratante_correo" value="medico_tratante_correo" />
          <label class="form-check-label" for="medico_tratante_correo">Correo médico tratante</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="indicaciones_medicamento" value="indicaciones_medicamento" />
          <label class="form-check-label" for="indicaciones_medicamento">Indicaciones de medicamento</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="recomendaciones_receta" value="recomendaciones_receta" />
          <label class="form-check-label" for="recomendaciones_receta">Recomendaciones en receta</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="medicamento_recetado" value="medicamento_recetado" />
          <label class="form-check-label" for="medicamento_recetado">Medicamento recetado</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="medicamento_codigo" value="medicamento_codigo" />
          <label class="form-check-label" for="medicamento_codigo">Código medicamento</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="medicamento_cantidad_solicitada" value="medicamento_cantidad_solicitada" />
          <label class="form-check-label" for="medicamento_cantidad_solicitada">Cantidad de medicamento recetado</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="centro_costos_medicamento" value="centro_costos_medicamento" />
          <label class="form-check-label" for="centro_costos_medicamento">Centro de costos medicamento</label>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="vale_medicamento" value="vale_medicamento" />
          <label class="form-check-label" for="vale_medicamento">Numero de vale medicamento</label>
        </div>
      </div>

    </div>

  </form>

  <div class="row mt-4">
    <div class="col-md-12" style="text-align: center">
      <button id="boton-generar_reporte_recetas" type="button" class="btn btn-success"><span class="mdi mdi-file-excel me-2"></span>Generar reporte</button>
    </div>
  </div>

</div>
@endsection
