@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Inicio')

@section('page-style')
@endsection

@section('page-script')
@endsection

@section('vendor-style')
@endsection

@section('vendor-script')
@endsection

@section('content')
  <div class="row justify-content-center align-items-center">

    <!-- Inicio - Targeta de total de pacientes atendidos -->
    <div class="col-md-12 col-lg-8 mb-4">
        <div class="card">
            <div class="card-body text-nowrap">
                <h5 class="card-title mb-0 flex-wrap text-nowrap">Total de pacientes</h5>
                <p class="mb-5">Número total de pacientes atendidos.</p>
                <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw);">100 pacientes.</h4>
                <a href="{{ route('nuevo-paciente') }}" class="btn btn-sm btn-primary">Agregar nuevo</a>
            </div>
            <i class="fa-solid fa-user-group position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
        </div>
    </div>
    <!-- Fin - Targeta de total de pacientes atendidos -->

    <!-- Inicio - Targeta de total de pacientes atendidos mujeres -->
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-body text-nowrap">
                <h5 class="card-title mb-0 flex-wrap text-nowrap">Total de mujeres</h5>
                <p class="mb-5">Número total de pacientes mujeres atendidas.</p>
                <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw);">78 mujeres.</h4>
            </div>
            <i class="fa-solid fa-person-dress position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
        </div>
    </div>
    <!-- Fin - Targeta de total de pacientes atendidos mujeres -->

    <!-- Inicio - Targeta de total de pacientes atendidos hombres -->
    <div class="col-md-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-body text-nowrap">
                <h5 class="card-title mb-0 flex-wrap text-nowrap">Total de hombres</h5>
                <p class="mb-5">Número total de pacientes hombres atendidos.</p>
                <h4 class="text-primary mb-5" style="font-size: calc(2rem + .3vw);">22 hombres.</h4>
            </div>
            <i class="fa-solid fa-person position-absolute bottom-0 end-0 me-5 mb-5" style="font-size: 50px;"></i>
        </div>
    </div>
    <!-- Fin - Targeta de total de pacientes atendidos hombres -->
  </div>
@endsection
