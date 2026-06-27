@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Surtir Receta')

@section('page-style')
@endsection

@section('page-script')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@5/dist/signature_pad.umd.min.js"></script>
<script src="{{ asset('assets/js/recetas/surtirReceta.js') }}?v={{ date('YmdHis') }}"></script>

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
<input id="hidden-paciente_id" type="hidden" />
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-1 align-content-center">
                <div class="avatar avatar-xl" style="zoom: 1.3;">
                    <div class="avatar-initial rounded-circle bg-label-primary">
                        <i class="mdi mdi-form-textbox-password fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h5><b>Escanear código de barras</b></h5>
                <h6 class="text-muted">Apunta el escáner al código de barras de la receta</h6>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-10">
                            <input id="inp-entrada_escaner" name="inp[entrada_escaner]" class="form-control form-control-lg" type="text" placeholder="Esperando lectura del código de barras..." />
                        </div>
                        <div class="col-md-2">
                            <i class="mdi mdi-barcode-scan fs-1 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-none bg-label-primary">
                    <div class="card-body mt-2" style="align-self: center;">
                        <h6 class="text-primary"><i class="mdi mdi-shield-check-outline fs-4 me-2"></i>Listo para escanear</h6>
                        <h6><small>Una vez escaneada la receta, se mostrarán los detalles y podrá ser surtida.</small></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 d-none" id="card-detalles_receta">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-9">
                        <h6 class="text-primary">Detalles de la receta</h6>
                    </div>
                    <div class="col-md-3 text-end">
                        <span class="badge rounded-pill bg-label-secondary fs-6" id="detalle_receta-estatus"></span>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-2 align-content-center" style="justify-content: center;display: grid;">
                        <div class="avatar avatar-xl">
                            <div class="avatar-initial rounded-circle bg-label-primary">
                                <i class="mdi mdi-text-box-multiple fs-1"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4 text-end">
                                <h6><small class="text-muted">Folio de receta:</small></h6>
                            </div>
                            <div class="col-md-8">
                                <h6><span class="text-primary" id="detalle_receta-folio"></span></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-end">
                                <h6><small class="text-muted">Fecha de emisión:</small></h6>
                            </div>
                            <div class="col-md-8">
                                <h6><span id="detalle_receta-fecha_emision"></span></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-end">
                                <h6><small class="text-muted">Médico emisor:</small></h6>
                            </div>
                            <div class="col-md-8">
                                <h6><span id="detalle_receta-medico_recetante"></span></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-end">
                                <h6><small class="text-muted">Cédula profesional:</small></h6>
                            </div>
                            <div class="col-md-8">
                                <h6><span id="detalle_receta-medico_cedula"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="divider">
                    <div class="divider-text">-</div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3 text-end">
                                <h6><small class="text-muted">Paciente:</small></h6>
                            </div>
                            <div class="col-md-9">
                                <h6><span id="detalle_receta-paciente_nombre"></span></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-end">
                                <h6><small class="text-muted">Edad:</small></h6>
                            </div>
                            <div class="col-md-9">
                                <h6><span id="detalle_receta-paciente_edad"></span></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-end">
                                <h6><small class="text-muted">Gafete:</small></h6>
                            </div>
                            <div class="col-md-9">
                                <h6><span id="detalle_receta-paciente_gafete"></span></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 text-end">
                                <h6><small class="text-muted">CURP:</small></h6>
                            </div>
                            <div class="col-md-9">
                                <h6><span id="detalle_receta-paciente_curp"></span></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 align-content-center">
                        <div class="avatar avatar-xl">
                            <img id="detalle_receta-avatar" src="{{ asset('assets/img/avatars/16.png') }}" alt="Avatar" class="rounded-circle">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 d-none" id="card-detalles_medicamentos">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-primary">Medicamentos prescritos</h6>
                    </div>
                    <div class="col-md-4 text-end">
                        <span class="badge rounded-pill bg-label-secondary fs-6" id="detalle_receta-total_medicamentos"></span>
                    </div>
                </div>
                <div class="table-responsive mb-4 mt-4">
                    <table class="table table-hover mb-0 table-sm" id="tabla-medicamentos-receta">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-white">#</th>
                                <th class="text-white">Medicamento</th>
                                <th class="text-center text-white">Presentación</th>
                                <th class="text-center text-white">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody id="contenedor-medicamentos"></tbody>
                    </table>
                </div>

                <div class="alert alert-info" role="alert">
                    <i class="mdi mdi-information me-2"></i>
                    Verifica que los medicamentos, presentaciones y cantidades <b>coincidan con la receta</b>.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4 d-none" id="card-botones_acciones">
    <div class="col-md-6">
        <div class="btn-flex-group">
            <button id="boton-limpiar_datos_escaneo_receta" class="btn btn-secondary waves-effect waves-light me-2">
                <span class="mdi mdi-scan-helper me-2"></span>
                Limpiar escaneo
            </button>
        </div>
    </div>
    <div class="col-md-6 text-end">
        <div class="btn-flex-group">
            <button id="boton-surtir_receta_completa" class="btn btn-success waves-effect waves-light me-2">
                <span class="mdi mdi-bookmark-check me-2"></span>
                Surtir receta completa
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="btn-flex-group" style="position: fixed; bottom: 2rem; right: 0.8rem; z-index: 1080;">
            <button href="/" class="btn btn-principal waves-effect waves-light me-2">
                <span class="mdi mdi-home me-2"></span>Inicio
            </button>
        </div>
    </div>
</div>

@endsection
