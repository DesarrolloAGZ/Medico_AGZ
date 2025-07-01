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

      <div class="col-md-8">

        <!-- Columna del card de total de numero de pacientes -->
        <div class="row mb-3">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-0 flex-wrap">Total de pacientes</h5>
                <p class="mb-5">Número total de pacientes atendidos.</p>
                <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['pacientesHombres'] + $datos_vista['estadisticas']['pacientesMujeres'] }} Pacientes.</h4>
                <a href="{{ route('nuevo-paciente') }}" class="btn btn-sm btn-primary">Agregar nuevo</a>
                <a href="{{ route('listado-paciente') }}" class="btn btn-sm btn-primary">Ver lista de pacientes</a>
              </div>
              <i class="fa-solid fa-user-group position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
            </div>
          </div>
        </div>

        <div class="row">

          <!-- Columna de total de mujeres atendidas -->
          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-0 flex-wrap">Total de mujeres</h5>
                <p class="mb-5">Número total de pacientes mujeres atendidas.</p>
                <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['pacientesMujeres'] }} Mujeres.</h4>
              </div>
              <i class="fa-solid fa-person-dress position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
            </div>
          </div>

          <!-- Columna de total de hombres atendidos -->
          <div class="col-md-6 mb-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-0 flex-wrap">Total de hombres</h5>
                <p class="mb-5">Número total de pacientes hombres atendidos.</p>
                <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['pacientesHombres'] }} Hombres.</h4>
              </div>
              <i class="fa-solid fa-person position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
            </div>
          </div>

        </div>

      </div>

      <!-- Columna que muestra el numero de consultas por dias de la semana -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-0 flex-wrap">Número de consultas por dia</h5>
            <p class="mb-5">Distribución de consultas médicas - últimos 8 días.</p>
            <div id="horizontalBarChart"></div>
          </div>
        </div>
      </div>

    </div>

    <div class="row mt-3">

      <!-- Columna para saber el tipo de consulta por enfermedad general -->
      <div class="col-md-6 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="col-md-12">
              <h5 class="card-title mb-0 flex-wrap">Total de consultas por {{ $datos_vista['catalogos']['tipo_visita'][0]['nombre'] }}</h5>
              <p class="mb-5">{{ $datos_vista['catalogos']['tipo_visita'][0]['descripcion'] }}</p>
              <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['enfermedadGeneral'] }} {{ $datos_vista['catalogos']['tipo_visita'][0]['nombre'] }}</h4>
            </div>
            <div class="col-md-12">
              <i class="fa-solid fa-virus-covid position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
          </div>
          </div>
        </div>
      </div>

      <!-- Columna para saber el tipo de consulta por rieso de trabajo -->
      <div class="col-md-6 mb-3">
        <div class="card">
          <div class="card-body">
              <h5 class="card-title mb-0 flex-wrap">Total de consultas por {{ $datos_vista['catalogos']['tipo_visita'][1]['nombre'] }}</h5>
              <p class="mb-5">{{ $datos_vista['catalogos']['tipo_visita'][1]['descripcion'] }}</p>
              <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['riesgoTrabajo'] }} {{ $datos_vista['catalogos']['tipo_visita'][1]['nombre'] }}</h4>
          </div>
          <i class="fa-solid fa-user-injured position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
        </div>
      </div>

    </div>

  </div>

@endsection
