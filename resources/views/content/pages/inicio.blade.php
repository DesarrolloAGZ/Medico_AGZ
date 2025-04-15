@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Inicio')

@section('page-style')
@endsection

@section('page-script')
  <script>
    // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
    pantallaCarga('off');

    var datos_vista = @json($datos_vista);
  </script>
@endsection

@section('vendor-style')
@endsection

@section('vendor-script')
@endsection

@include('content.pages.pantalla-carga')

@section('content')
  <div class="row justify-content-center align-items-center">

    @php
      // dd($datos_vista);
    @endphp

    <!-- Inicio - Targeta de total de pacientes atendidos -->
    <div class="col-md-12 col-lg-8 mb-4">
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
    <!-- Fin - Targeta de total de pacientes atendidos -->

    <!-- Inicio - Targeta de total de pacientes atendidos mujeres -->
    <div class="col-md-12 col-lg-6 mb-4">
      <div class="card">
          <div class="card-body">
              <h5 class="card-title mb-0 flex-wrap">Total de mujeres</h5>
              <p class="mb-5">Número total de pacientes mujeres atendidas.</p>
              <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['pacientesMujeres'] }} Mujeres.</h4>
          </div>
          <i class="fa-solid fa-person-dress position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
      </div>
    </div>
    <!-- Fin - Targeta de total de pacientes atendidos mujeres -->

    <!-- Inicio - Targeta de total de pacientes atendidos hombres -->
    <div class="col-md-12 col-lg-6 mb-4">
      <div class="card">
          <div class="card-body">
              <h5 class="card-title mb-0 flex-wrap">Total de hombres</h5>
              <p class="mb-5">Número total de pacientes hombres atendidos.</p>
              <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['pacientesHombres'] }} Hombres.</h4>
          </div>
          <i class="fa-solid fa-person position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
      </div>
    </div>
    <!-- Fin - Targeta de total de pacientes atendidos hombres -->

    <!-- Inicio - Targeta de total de pacientes por enfermedad general -->
    <div class="col-md-12 col-lg-6 mb-4">
      <div class="card">
          <div class="card-body">
              <h5 class="card-title mb-0 flex-wrap">Total de consultas por {{ $datos_vista['catalogos']['tipo_visita'][0]['nombre'] }}</h5>
              <p class="mb-5">{{ $datos_vista['catalogos']['tipo_visita'][0]['descripcion'] }}</p>
              <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['enfermedadGeneral'] }} {{ $datos_vista['catalogos']['tipo_visita'][0]['nombre'] }}</h4>
          </div>
          <i class="fa-solid fa-virus-covid position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
      </div>
    </div>
    <!-- Fin - Targeta de total de pacientes por enfermedad general -->

     <!-- Inicio - Targeta de total de pacientes por riesgo de trabajo -->
     <div class="col-md-12 col-lg-6 mb-4">
      <div class="card">
          <div class="card-body">
              <h5 class="card-title mb-0 flex-wrap">Total de consultas por {{ $datos_vista['catalogos']['tipo_visita'][1]['nombre'] }}</h5>
              <p class="mb-5">{{ $datos_vista['catalogos']['tipo_visita'][1]['descripcion'] }}</p>
              <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">{{ $datos_vista['estadisticas']['riesgoTrabajo'] }} {{ $datos_vista['catalogos']['tipo_visita'][1]['nombre'] }}</h4>
          </div>
          <i class="fa-solid fa-user-injured position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
      </div>
    </div>
    <!-- Fin - Targeta de total de pacientes por riesgo de trabajo -->
  </div>
@endsection
