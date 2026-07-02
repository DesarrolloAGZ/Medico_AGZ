@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Existencia medicamentos')

@section('page-style')
@endsection

@section('page-script')
<script src="{{ asset('assets/js/medicamentos/existencias.js') }}?v={{ date('YmdHis') }}"></script>

<script>
    var datos_vista = @json($datos_vista);

</script>
@endsection

@section('vendor-style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
<!-- Form Validation -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />

@endsection

@section('vendor-script')
<!-- Form Validation -->
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
@endsection

@include('content.pages.pantalla-carga')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title"><i class="mdi mdi-format-list-bulleted-square me-2"></i>Listado de existencias de medicamentos</h5>

        <div class="alert alert-primary" role="alert">
            <i class="mdi mdi-information me-2"></i>
            Las existencias de medicamentos mostradas en esta sección son consultadas directamente desde Hispatec.
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-12 mb-3">
                <div class="form-floating form-floating-outline">
                    <select class="form-select form-select-sm" id="almacen_medicamentos" name="almacen_medicamentos" onchange="obtenerCatalogoMedicamentosHispatec()">
                        <option value="" selected>Selecciona una opción</option>
                        @foreach ($datos_vista['usuario_almacenes'] as $almacen)
                        <option value="{{ $almacen['almacen_id'] }}" data-empresa_id="{{ $almacen['empresa_id'] }}" data-almacen_codigo="{{ $almacen['almacen_codigo'] }}">
                            {{ $almacen['almacen_codigo'] }} - {{ $almacen['almacen_nombre'] }}
                            ({{ $almacen['empresa_nombre'] }})
                        </option>
                        @endforeach
                    </select>
                    <label for="almacen_medicamentos">Almacén <i class="text-danger">*</i></label>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" id="contenedor-filtros-medicamento" style="display: none;">
            <div class="col-md-12">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="filtro-medicamento" name="filtro-medicamento" class="form-control" placeholder="Ingresa el medicamento a buscar." />
                    <label for="filtro-medicamento">Buscar medicamento</label>
                </div>
            </div>
        </div>

        <!-- Sección con SCROLL (solo la lista) -->
        <div class="flex-grow-1 mt-4" style="overflow-y: auto;">
            <div class="p-3">
                <ul class="list-group list-group-timeline" id="listado-medicamentos-receta" style="max-height:500px;overflow-y:auto;">
                </ul>
                <div id="indicador-scroll" class="text-center mb-2 mt-4 text-primary fw-semibold d-none">
                    <i class="mdi mdi-mouse fs-5 me-1"></i>
                    <i class="mdi mdi-chevron-double-down fs-4"></i>
                    Utiliza el scroll para ver más medicamentos
                </div>
            </div>
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
@endsection
