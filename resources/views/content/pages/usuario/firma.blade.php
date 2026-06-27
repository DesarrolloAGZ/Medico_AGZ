@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Registro de Firma')

@section('page-style')
<style>
    #signature-pad {
        width: 100%;
        height: 350px;
        border: 2px dashed #696cff;
        border-radius: 10px;
        background: #fff;
        cursor: crosshair;
    }

</style>
@endsection

@section('page-script')

<script src="{{ asset('assets/js/funciones_generales.js') }}?v={{ date('YmdHis')}}"></script>

<!-- Librería SignaturePad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@5/dist/signature_pad.umd.min.js"></script>

<script>
    window.guardarFirmaUrl = "{{ route('guardar-firma-medico') }}";
    window.inicioUrl = "{{ route('pantalla-inicio') }}";

</script>

<!-- Tu JS -->
<script src="{{ asset('assets/js/usuario/firma.js') }}?v={{ date('YmdHis') }}"></script>

@endsection

@include('content.pages.pantalla-carga')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header text-center">

                <h3 class="mb-2">
                    <span class="mdi mdi-draw-pen"></span>
                    Registro de firma
                </h3>

                <p class="text-muted mb-0">
                    Antes de utilizar el sistema debe registrar su firma.
                    Esta será utilizada para firmar automáticamente las recetas médicas.
                </p>

            </div>

            <div class="card-body">

                <canvas id="signature-pad"></canvas>

                <div class="text-end mt-4">

                    <button type="button" class="btn btn-outline-secondary me-2" id="limpiar-firma">

                        <span class="mdi mdi-delete"></span>
                        Limpiar

                    </button>

                    <button type="button" class="btn btn-primary" id="guardar-firma">

                        <span class="mdi mdi-content-save"></span>
                        Guardar firma

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
