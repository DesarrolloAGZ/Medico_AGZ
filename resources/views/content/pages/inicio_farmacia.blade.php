@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Inicio Farmacia')

@section('page-style')
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
  <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"><script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')

  <div class="container mt-4">
    <div class="row">

      <div class="col-lg-12 col-md-12 col-sm-12">

        <!-- Columna del card de total de recetas -->
        <div class="row mb-3">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card position-relative overflow-hidden">
              <div class="card-body position-relative z-1">
                <h5 class="card-title mb-0 flex-wrap">Total de recetas</h5>
                <p class="mb-5">Número total de recetas creadas con el sistema.</p>
                <h4 class="text-primary mb-5 text-center" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">
                  <br>Recetas totales.
                </h4>
                <div class="row">
                  <div class="col-md-4">
                    <a href="{{ route('nuevo-paciente') }}" class="btn btn-sm btn-primary mb-2">Surtir nueva</a>
                  </div>
                  <div class="col-md-6">
                    <a href="{{ route('listado-paciente') }}" class="btn btn-sm btn-primary">Ver lista de recetas</a>
                  </div>
                </div>
              </div>
              <!-- Icono grande -->
              <i class="fa-solid fa-capsules position-absolute text-primary" style="font-size: 150px; right: -30px; bottom: -30px; opacity: 0.2; z-index: 0;"></i>
            </div>
          </div>
        </div>

        <div class="row">

          @foreach ($datos_vista['catalogos']['estatusReceta'] as $estatusReceta)
            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
              <div class="card position-relative overflow-hidden">
                <div class="card-body position-relative z-1">
                  <h5 class="card-title mb-0 flex-wrap">{{ $estatusReceta['nombre']}}s</h5>
                  <p class="mb-5" style="text-align: justify;">Número total de recetas {{ $estatusReceta['nombre']}}s.</p>
                  <h4 class="text-primary mb-5 text-center" style="font-size: calc(2rem + .3vw); word-wrap: break-word;">
                    <br>Recetas.
                  </h4>
                </div>
                <!-- Icono grande -->
                <i class="{{ $estatusReceta['icono'] }} position-absolute {{ $estatusReceta['clase'] }}" style="font-size: 150px; right: -30px; bottom: -30px; opacity: 0.2; z-index: 0;"></i>
              </div>
            </div>
          @endforeach

        </div>

      </div>

    </div>
  </div>
@endsection
