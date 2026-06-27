@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Inicio Consultas')

@section('page-style')
<style>
.content-wrapper{
  zoom: 0.85;
}
.dashboard-card{
    border:0;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.06);
    transition:.25s;
}
.dashboard-card:hover{
    transform:translateY(-3px);
}
.hero-card{
    min-height:430px;
}
.hero-icon{
    position:absolute;
    right:-40px;
    bottom:-50px;
    font-size:260px;
    opacity:.1;
}
.info-card{
    min-height:260px;
}
.icon-box{
    width:70px;
    height:70px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
}
.stat-number{
    font-size:3rem;
    font-weight:700;
}
.watermark{
    position:absolute;
    right:-10px;
    bottom:-10px;
    font-size:100px;
    opacity:.1;
}
.border-pink{
    border-bottom:4px solid #ff6b9d;
}
.border-blue{
    border-bottom:4px solid #4d8eff;
}
.border-green{
    border-bottom:4px solid #28a745;
}
.border-orange{
    border-bottom:4px solid #fd7e14;
}
.btn-dashboard{
    padding:.85rem 1.8rem;
    border-radius:12px;
    font-weight:600;
}
</style>
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

<div class="container-fluid mt-4">
  {{-- SEGUNDA FILA --}}
  <div class="row mb-4">
    {{-- CARD TOTAL --}}
    <div class="col-lg-6 mb-4 d-flex">
      <div class="card dashboard-card hero-card overflow-hidden w-100" style="border-bottom: 4px solid #26c6f9 !important;">
        <div class="card-body p-5 position-relative text-center">
          <h2 class="fw-bold mb-2">Total de pacientes</h2>
          <p class="text-muted mb-4">Número total de pacientes atendidos.</p>
          <div class="row align-items-center">
            <div class="col-lg-7">
              <div class="mb-4">
                <small class="text-muted">Pacientes registrados</small>
                <h1 class="text-info fw-bold" style="font-size:4rem;">
                  {{ $datos_vista['estadisticas']['pacientesHombres'] + $datos_vista['estadisticas']['pacientesMujeres'] }}
                </h1>
              </div>
              <div class="col-12 mb-4">
                <a href="{{ route('nuevo-paciente') }}" class="btn btn-info btn-dashboard w-100">
                  <i class="fa-solid fa-user-plus me-2"></i>
                  AGREGAR NUEVO
                </a>
              </div>
              <div class="col-12 mb-4">
                <a href="{{ route('listado-paciente') }}" class="btn btn-outline-info btn-dashboard w-100">
                  <i class="fa-solid fa-list me-2"></i>
                  VER PACIENTES
                </a>
              </div>
            </div>
            <div class="col-lg-5">
              <div class=" mb-3">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-person-dress text-danger me-3" style="font-size:35px;"></i>
                    <div>
                      <small class="text-muted">Mujeres</small>
                      <h3 class="mb-0">{{ $datos_vista['estadisticas']['pacientesMujeres'] }}</h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="fa-solid fa-person text-info me-3" style="font-size:35px;"></i>
                    <div>
                      <small class="text-muted">Hombres</small>
                      <h3 class="mb-0">{{ $datos_vista['estadisticas']['pacientesHombres'] }}</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <i class="fa-solid fa-user-group text-info hero-icon"></i>
        </div>
      </div>
    </div>

    {{-- CARD TOTAL CONSULTAS --}}
    <div class="col-lg-6 mb-4 d-flex">
      <div class="card dashboard-card hero-card overflow-hidden w-100" style="border-bottom: 4px solid #72e128 !important;">
        <div class="card-body p-5 position-relative text-center">
          <h2 class="fw-bold mb-2">Total de consultas</h2>
          <p class="text-muted mb-4">Número total de consultas médicas registradas.</p>
          <div class="row align-items-center" style="z-index: 100; position: relative;">
            {{-- TOTAL --}}
            <div class="col-lg-7">
              <div class="mb-4">
                <small class="text-muted">Consultas registradas</small>
                <h1 class="text-success fw-bold" style="font-size:4rem;">
                  {{ $datos_vista['estadisticas']['enfermedadGeneral'] + $datos_vista['estadisticas']['riesgoTrabajo'] }}
                </h1>
              </div>
              <div class="mb-3">
                <a href="{{ route('listado-consultas') }}" class="btn btn-success btn-dashboard w-100">
                  <i class="fa-solid fa-stethoscope me-2"></i>
                  VER CONSULTAS
                </a>
              </div>
            </div>
            {{-- CLASIFICACIONES --}}
            <div class="col-lg-5">
              {{-- Enfermedad --}}
              <div class="mb-3" style="z-index:100;">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <i class="fa-solid fa-virus text-success me-3" style="font-size:35px;"></i>
                      <div>
                        <small class="text-muted">
                          {{ $datos_vista['catalogos']['tipo_visita'][0]['nombre'] }}
                        </small>
                        <h3 class="mb-0">
                          {{ $datos_vista['estadisticas']['enfermedadGeneral'] }}
                        </h3>
                      </div>
                    </div>
                  </div>
                  <a href="{{ route('listado-consultas',['tipo_visita_seleccionado'=>1]) }}" class="btn btn-sm btn-outline-success w-100 mt-2">Ver</a>
                </div>
              </div>
              {{-- Riesgo --}}
              <div class="" style="z-index:100;">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <i class="fa-solid fa-user-injured text-warning me-3" style="font-size:35px;"></i>
                      <div>
                        <small class="text-muted">{{ $datos_vista['catalogos']['tipo_visita'][1]['nombre'] }}</small>
                        <h3 class="mb-0">{{ $datos_vista['estadisticas']['riesgoTrabajo'] }}</h3>
                      </div>
                    </div>
                  </div>
                  <a href="{{ route('listado-consultas',['tipo_visita_seleccionado'=>2]) }}" class="btn btn-sm btn-outline-warning w-100 mt-2">Ver</a>
                </div>
              </div>
            </div>
          </div>
          <i class="fa-solid fa-stethoscope text-success hero-icon"></i>
        </div>
      </div>
    </div>

    {{-- GRAFICA --}}
    <div class="col-lg-12 mb-4 d-flex">
      <div class="card dashboard-card w-100" style="border-bottom: 4px solid #268257 !important;">
        <div class="card-body p-4" style="padding: 50px !important;">
          <h4 class="fw-bold">Consultas por día</h4>
          <p class="text-muted">Últimos 8 días.</p>
          <div id="horizontalBarChart"></div>
        </div>
      </div>
    </div>

    {{-- FOOTER INFO --}}
    <div class="col-12">
      <div class="card dashboard-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center"><div>
            <h5 class="mb-1">
              <i class="fa-solid fa-circle-info text-success me-2"></i>
              Información actualizada
            </h5>
            <span class="text-muted">Los datos mostrados se actualizan al recargar el sitio.</span>
          </div>
          <div class="text-muted">
            <i class="fa-regular fa-clock me-1"></i>
            {{ date('d/m/Y H:i') }}
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
