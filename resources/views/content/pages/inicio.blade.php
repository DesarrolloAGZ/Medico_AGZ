@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Inicio')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/funciones_generales.js') }}?v={{ date('YmdHis')}}"></script>
  <script>
    // Variable con los datos de la vista
    var datos_vista = @json($datos_vista);
    // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
    pantallaCarga('off');
    // Iniciamos la grafica de consultas por dia
    verGraficoConsultasPorDia(datos_vista.estadisticas.consultasPorDia);
  </script>
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
@endsection

@section('vendor-script')
  <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"><script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')

  <div class="container mt-4">
    <div class="row">

      <div class="col-lg-8 col-md-12 col-sm-12">

        <!-- Columna del card de total de numero de pacientes -->
        <div class="row mb-3">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card position-relative overflow-hidden">
              <div class="card-body position-relative z-1">
                <h5 class="card-title mb-0 flex-wrap">Total de pacientes</h5>
                <p class="mb-5">Número total de pacientes atendidos.</p>
                <h4 class="text-primary mb-5 text-center" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">
                    {{ $datos_vista['estadisticas']['pacientesHombres'] + $datos_vista['estadisticas']['pacientesMujeres'] }} <br>Pacientes.
                </h4>
                <div class="row">
                  <div class="col-md-4">
                    <a href="{{ route('nuevo-paciente') }}" class="btn btn-sm btn-primary mb-2">Agregar nuevo</a>
                  </div>
                  <div class="col-md-6">
                    <a href="{{ route('listado-paciente') }}" class="btn btn-sm btn-primary">Ver lista de pacientes</a>
                  </div>
                </div>
              </div>
              <!-- Icono grande -->
              <i class="fa-solid fa-user-group position-absolute" style="font-size: 150px; right: -30px; bottom: -30px; opacity: 0.1; z-index: 0;"></i>
            </div>
          </div>
        </div>

        <div class="row">

          <!-- Columna de total de mujeres atendidas -->
          <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card position-relative overflow-hidden">
              <div class="card-body position-relative z-1">
                <h5 class="card-title mb-0 flex-wrap">Total de mujeres</h5>
                <p class="mb-5" style="text-align: justify;">Número total de pacientes mujeres atendidas.</p>
                <h4 class="text-primary mb-5 text-center" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">
                  {{ $datos_vista['estadisticas']['pacientesMujeres'] }} <br>Mujeres.
                </h4>
              </div>
              <!-- Icono grande -->
              <i class="fa-solid fa-person-dress position-absolute" style="font-size: 150px; right: -30px; bottom: -30px; opacity: 0.1; z-index: 0; color: #ff6b9d;"></i>
            </div>
          </div>

          <!-- Columna de total de hombres atendidos -->
          <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
            <div class="card position-relative overflow-hidden">
              <div class="card-body position-relative z-1">
                <h5 class="card-title mb-0 flex-wrap">Total de hombres</h5>
                <p class="mb-5" style="text-align: justify;">Número total de pacientes hombres atendidos.</p>
                <h4 class="text-primary mb-5 text-center" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">
                  {{ $datos_vista['estadisticas']['pacientesHombres'] }} <br>Hombres.
                </h4>
              </div>
              <!-- Icono grande -->
              <i class="fa-solid fa-person position-absolute" style="font-size: 150px; right: -30px; bottom: -30px; opacity: 0.1; z-index: 0; color: #4d8eff;"></i>
            </div>
          </div>

        </div>

      </div>

      <!-- Columna que muestra el numero de consultas por dias de la semana -->
      <div class="col-lg-4 col-md-12 col-sm-12">
        <div class="card position-relative overflow-hidden" style="height: 97%;">
          <div class="card-body position-relative z-1">
            <h5 class="card-title mb-0 flex-wrap">Número de consultas por día</h5>
            <p class="mb-5">Distribución de consultas médicas - últimos 8 días.</p>
            <div id="horizontalBarChart"></div>
          </div>
          <!-- Icono grande -->
          <i class="fa-solid fa-stethoscope position-absolute" style="font-size: 120px; right: -20px; bottom: -20px; opacity: 0.08; z-index: 0; color: #6c757d;"></i>
        </div>
      </div>

    </div>

    <div class="row mt-3">

      <!-- Columna para saber el tipo de consulta por enfermedad general -->
      <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
        <div class="card position-relative overflow-hidden">
          <div class="card-body position-relative z-1">
            <h5 class="card-title mb-0 flex-wrap">Total de consultas por {{ $datos_vista['catalogos']['tipo_visita'][0]['nombre'] }}</h5>
            <p class="mb-5" style="text-align: justify;">{{ $datos_vista['catalogos']['tipo_visita'][0]['descripcion'] }}</p>
            <h4 class="text-primary mb-5 text-center" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">
              {{ $datos_vista['estadisticas']['enfermedadGeneral'] }} <br>{{ $datos_vista['catalogos']['tipo_visita'][0]['nombre'] }}
            </h4>
            <div class="row">
              <div class="col-md-12">
                <a href="{{ route('listado-consultas', ['tipo_visita_seleccionado' => 1]) }}" class="btn btn-sm btn-primary mb-2">Ver clasificación</a>
              </div>
            </div>
          </div>
          <!-- Icono grande -->
          <i class="fa-solid fa-virus position-absolute" style="font-size: 140px; right: -25px; bottom: -25px; opacity: 0.08; z-index: 0; color: #28a745;"></i>
        </div>
      </div>

      <!-- Columna para saber el tipo de consulta por rieso de trabajo -->
      <div class="col-lg-6 col-md-12 col-sm-12 mb-3">
        <div class="card position-relative overflow-hidden">
          <div class="card-body position-relative z-1">
            <h5 class="card-title mb-0 flex-wrap">Total de consultas por {{ $datos_vista['catalogos']['tipo_visita'][1]['nombre'] }}</h5>
            <p class="mb-5" style="text-align: justify;">{{ $datos_vista['catalogos']['tipo_visita'][1]['descripcion'] }}</p>
            <h4 class="text-primary mb-5 text-center" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">
              {{ $datos_vista['estadisticas']['riesgoTrabajo'] }} <br>{{ $datos_vista['catalogos']['tipo_visita'][1]['nombre'] }}
            </h4>
            <div class="row">
              <div class="col-md-12">
                <a href="{{ route('listado-consultas', ['tipo_visita_seleccionado' => 2]) }}" class="btn btn-sm btn-primary mb-2">Ver clasificación</a>
              </div>
            </div>
          </div>
          <!-- Icono grande -->
          <i class="fa-solid fa-user-injured position-absolute" style="font-size: 140px; right: -25px; bottom: -25px; opacity: 0.08; z-index: 0; color: #fd7e14;"></i>
        </div>
      </div>

    </div>

  </div>

@endsection
