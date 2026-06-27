@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Inicio Farmacia')

@section('page-style')
<style>
    .dashboard-card {
        border: 0;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
        transition: .25s;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
    }

    .hero-card {
        min-height: 380px;
    }

    .hero-icon {
        font-size: 280px;
        opacity: .08;
        position: absolute;
        right: -30px;
        bottom: -40px;
    }

    .status-icon-bg {
        width: 75px;
        height: 75px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .04);
    }

    .status-number {
        font-size: 3rem;
        font-weight: 700;
    }

    .bg-success-soft {
        background: rgba(25, 135, 84, .15);
    }

    .status-card {
        min-height: 280px;
    }

    .card-icon-watermark {
        position: absolute;
        right: -10px;
        bottom: -15px;
        font-size: 100px;
        opacity: .08;
    }

    .border-blue {
        border-bottom: 4px solid #26c6f9 !important;
    }

    .border-primary-green {
        border-bottom: 4px solid #006c39 !important;
    }

    .border-green {
        border-bottom: 4px solid #72e128 !important;
    }

    .border-yellow {
        border-bottom: 4px solid #fdb528 !important;
    }

    .border-red {
        border-bottom: 4px solid #ff4d49 !important;
    }

    .btn-dashboard {
        padding: .85rem 1.8rem;
        font-weight: 600;
        border-radius: 12px;
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

</script>
@endsection

@section('vendor-style')
<link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
@endsection

@section('vendor-script')
<script src="../../assets/vendor/libs/apex-charts/apexcharts.js">
    <script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')
<div class="container-fluid mt-4">

  {{-- CARD DEL TOTAL --}}
  <div class="card dashboard-card hero-card overflow-hidden mb-4 border-primary-green">
    <div class="card-body p-5 position-relative">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h2 class="fw-bold mb-2">Total de recetas</h2>
          <p class="text-muted mb-4">Número total de recetas creadas con el sistema.</p>
          <div class="d-flex align-items-center mb-4">
            <div class="rounded-circle bg-success-soft d-flex align-items-center justify-content-center" style="width:120px;height:120px;">
              <i class="fa-solid fa-file-medical text-primary" style="font-size:55px;"></i>
            </div>
            <div class="ms-4">
              <small class="text-muted d-block mb-2">Recetas totales</small>
              <h1 class="fw-bold text-primary mb-2" style="font-size:4rem;">
                {{ ($datos_vista['recetas']['vigentes'] + $datos_vista['recetas']['surtidas'] + $datos_vista['recetas']['canceladas'] + $datos_vista['recetas']['caducadas']) }}
              </h1>
            </div>
          </div>
          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('receta-surtir') }}" class="btn btn-primary btn-dashboard">
              <i class="fa-solid fa-plus me-2"></i>
              SURTIR NUEVA
            </a>
            <a href="{{ route('listado-recetas') }}" class="btn btn-outline-primary btn-dashboard">
              <i class="fa-solid fa-list me-2"></i>
              VER LISTA DE RECETAS
            </a>
          </div>
        </div>
        <div class="col-lg-4 text-end d-none d-lg-block">
          <i class="fa-solid fa-capsules text-primary hero-icon"></i>
        </div>
      </div>
    </div>
  </div>

  {{-- CARDS DE ESTATUS --}}
  <div class="row">

    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card dashboard-card status-card position-relative overflow-hidden border-blue">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-4">
            <div class="status-icon-bg">
              <i class="fa-solid fa-file-contract text-info" style="font-size:30px;"></i>
            </div>
            <div class="ms-3">
              <h4 class="fw-bold mb-1">Vigentes</h4>
              <small class="text-muted">Total recetas vigentes</small>
            </div>
          </div>
          <div class="status-number text-dark">
            {{ $datos_vista['recetas']['vigentes'] }}
          </div>
          <p class="text-muted mb-0">
            Número total de recetas
            vigentes.
          </p>
        </div>
        <i class="fa-solid fa-file-contract text-info card-icon-watermark"></i>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card dashboard-card status-card position-relative overflow-hidden border-green">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-4">
            <div class="status-icon-bg">
              <i class="fa-solid fa-file-circle-check text-success" style="font-size:30px;"></i>
            </div>
            <div class="ms-3">
              <h4 class="fw-bold mb-1">Surtidas</h4>
              <small class="text-muted">Total recetas surtidas</small>
            </div>
          </div>
          <div class="status-number text-dark">
            {{ $datos_vista['recetas']['surtidas'] }}
          </div>
          <p class="text-muted mb-0">
            Número total de recetas
            surtidas.
          </p>
        </div>
        <i class="fa-solid fa-file-circle-check text-success card-icon-watermark"></i>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card dashboard-card status-card position-relative overflow-hidden border-red">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-4">
            <div class="status-icon-bg">
              <i class="fa-solid fa-file-circle-xmark text-danger" style="font-size:30px;"></i>
            </div>
            <div class="ms-3">
              <h4 class="fw-bold mb-1">Canceladas</h4>
              <small class="text-muted">Total registradas</small>
            </div>
          </div>
          <div class="status-number text-dark">
            {{ $datos_vista['recetas']['canceladas'] }}
          </div>
          <p class="text-muted mb-0">
            Número total de recetas
            canceladas.
          </p>
        </div>
        <i class="fa-solid fa-file-circle-xmark text-danger card-icon-watermark"></i>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card dashboard-card status-card position-relative overflow-hidden border-yellow">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-4">
            <div class="status-icon-bg">
              <i class="fa-solid fa-file-circle-exclamation text-warning" style="font-size:30px;"></i>
            </div>
            <div class="ms-3">
              <h4 class="fw-bold mb-1">Caducadas</h4>
              <small class="text-muted">Total registradas</small>
            </div>
          </div>
          <div class="status-number text-dark">
            {{ $datos_vista['recetas']['caducadas'] }}
          </div>
          <p class="text-muted mb-0">
            Número total de recetas
            caducadas.
          </p>
        </div>
        <i class="fa-solid fa-file-circle-exclamation text-warning card-icon-watermark"></i>
      </div>
    </div>

  </div>

  {{-- INFORMACION --}}
  <div class="card dashboard-card mt-2">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h5 class="mb-1">
            <i class="fa-solid fa-circle-info text-success me-2"></i>
            Información actualizada
          </h5>
          <span class="text-muted">Los datos mostrados se actualizan al recargar el sitio.</span>
        </div>
        <div class="text-muted mt-2 mt-md-0">
          <i class="fa-regular fa-clock me-1"></i>
          Última actualización:
          {{ date('d/m/Y H:i') }}
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
