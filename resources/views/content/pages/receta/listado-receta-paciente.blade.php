@extends('layouts/layoutMaster')

@section('title', 'Listado Recetas Paciente')

@section('page-style')
@endsection

@section('page-script')
<script src="{{ asset('assets/js/pacientes/recetasPaciente.js') }}?v={{ date('YmdHis')}}"></script>
<script>
    var datos_vista = @json($datos_vista);

</script>
@endsection

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
<link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
@endsection

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

<!-- Scripts necesarios para DataTables y botones de exportación -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.8.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')

@php
// dd($datos_vista);
@endphp

<div class="card p-5">

    <input id="paciente_id_hidden" value="{{ $datos_vista['paciente_id'] ?? '' }}" style="display: none;">

    <div class="divider">
        <div class="divider-text texto-titulo {{ $datos_vista['paciente_id'] ?? 'd-none' }}">
            Listado de recetas del paciente </br>
            {{ (isset($datos_vista['paciente']['datos_generales'])) ? $datos_vista['paciente']['datos_generales'][0]['nombre'].' '.$datos_vista['paciente']['datos_generales'][0]['apellido_paterno'].' '. $datos_vista['paciente']['datos_generales'][0]['apellido_materno'] : '' }}
        </div>
        <div class="divider-text texto-titulo {{ empty($datos_vista['paciente_id']) ? '' : 'd-none' }}">
            <span class="badge bg-label-primary"><i class="mdi mdi-format-list-text me-2"></i>Listado de todas las recetas de pacientes</span>
        </div>
    </div>

    <div class="divider text-start">
        <div class="divider-text"><span class="mdi mdi-filter-multiple me-2"></span>Filtros para buscar receta</div>
    </div>

    {{-- Filtros para buscar receeta --}}
    <div class="row mt-2 {{ empty($datos_vista['paciente_id']) ? '' : 'd-none' }}">
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                <input type="date" class="form-control" id="filtro-receta-fecha_inicio" placeholder="Selecciona la fecha inicial." onchange="generarTabla()" />
                <label for="filtro-receta-fecha_inicio">Fecha inicio</label>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                <input type="date" class="form-control" id="filtro-receta-fecha_fin" placeholder="Selecciona la fecha final." onchange="generarTabla()" />
                <label for="filtro-receta-fecha_fin">Fecha fin</label>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="filtro-receta-numero_empleado" name="filtro-receta[numero_empleado]" placeholder="Escribe el numero de empleado." onkeyup="generarTabla()" />
                <label for="filtro-receta-numero_empleado"># Empleado</label>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="filtro-receta-folio" name="filtro-receta[folio]" placeholder="Escribe el folio de la receta." onkeyup="generarTabla()" />
                <label for="filtro-receta-folio">Folio de la receta</label>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-floating form-floating-outline">
                <input type="text" class="form-control" id="filtro-receta-empleado_nombre" name="filtro-receta[empleado_nombre]" placeholder="Escribe el nombre del paciente." onkeyup="generarTabla()" />
                <label for="filtro-receta-empleado_nombre">Nombre del paciente</label>
            </div>
        </div>
    </div>

    <div class="card-datatable table-responsive pt-0">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
            <div class="row">
                <div class="col-md-12">
                    <table class="table datatables-basic-filas table-hover table-striped w-100">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center">Gafete</th>
                                <th class="text-center">Folio receta</th>
                                <th class="text-center">Nombre paciente</th>
                                <th class="text-center">Recetó</th>
                                <th class="text-center">Fecha de creación</th>
                                <th class="text-center">Estatus receta</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="btn-flex-group" style="position: fixed; bottom: 2rem; right: 0.8rem; z-index: 1080;">
            <a href="/" class="btn btn-principal waves-effect waves-light me-2" type="button">
                <span class="mdi mdi-home me-2"></span>Inicio
            </a>
        </div>
    </div>
</div>
@endsection
