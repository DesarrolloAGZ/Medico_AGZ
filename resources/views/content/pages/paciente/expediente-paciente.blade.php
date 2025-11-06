@extends('layouts/layoutMaster')

@section('title', 'Detalles de Consulta Paciente')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css') }}?v={{ date('YmdHis')}}">
  <link rel="stylesheet" href="{{asset('assets/css/pacientes/impresionExpediente.css') }}?v={{ date('YmdHis')}}">
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/pacientes/expedientePaciente.js') }}?v={{ date('YmdHis')}}"></script>
  <script>
    var datos_vista = @json($datos_vista);
  </script>
@endsection

@section('vendor-style')
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

  <div class="card p-5 ajuste-hoja-impresion">

    <div class="divider">
      <div class="divider-text texto-titulo">
        Detalle de la consulta
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-3 mb-5" style="justify-content: center;display: flex;">
        <div class="avatar avatar-xl me-2 mb-5" style="width: 150px;height: 150px;">
          <img src="{{ isset($datos_vista['paciente']['datos_generales']) && $datos_vista['paciente']['datos_generales'][0]['genero'] == 'M' ? asset('assets/img/avatars/17.png') : asset('assets/img/avatars/16.png') }}" alt="Avatar" class="rounded-circle">
          <div class="text-center">{{ (isset($datos_vista['paciente']['datos_generales'])) ? $datos_vista['paciente']['datos_generales'][0]['nombre'].' '.$datos_vista['paciente']['datos_generales'][0]['apellido_paterno'].' '. $datos_vista['paciente']['datos_generales'][0]['apellido_materno'] : '' }}</div>
        </div>
      </div>

      <div class="col-md-4" style="justify-content: center;display: flex;">
        <div style="">
          <ul class="list-group list-group-timeline">
            <li class="list-group-item list-group-timeline-primary"><strong># Gafete:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['gafete']) ? $datos_vista['paciente']['datos_generales'][0]['gafete'] : '' }}</li>
            <li class="list-group-item list-group-timeline-primary"><strong>Genero:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['genero']) && $datos_vista['paciente']['datos_generales'][0]['genero'] == 'M' ? 'Hombre' : 'Mujer' }}</li>
            <li class="list-group-item list-group-timeline-primary"><strong>Telefono:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['celular']) ? $datos_vista['paciente']['datos_generales'][0]['celular'] : '' }}</li>
            <li class="list-group-item list-group-timeline-primary"><strong>Edad:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['edad']) ? $datos_vista['paciente']['datos_generales'][0]['edad'].' años' : '' }}</li>
            <li class="list-group-item list-group-timeline-primary"><strong>CURP:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['curp']) ? $datos_vista['paciente']['datos_generales'][0]['curp'] : '' }}</li>
          </ul>
        </div>
      </div>

      <div class="col-md-5" style="justify-content: center;display: flex;">
        <div style="">
          <ul class="list-group list-group-timeline">
            <li class="list-group-item list-group-timeline-primary"><strong>Empresa:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['empresa_nombre']) ? $datos_vista['paciente']['datos_generales'][0]['empresa_nombre'] : '' }}</li>
            <li class="list-group-item list-group-timeline-primary"><strong>Unidad de negocio:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['unidad_negocio_nombre']) ? $datos_vista['paciente']['datos_generales'][0]['unidad_negocio_nombre'] : '' }}</li>
            <li class="list-group-item list-group-timeline-primary"><strong>Area:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['area_nombre']) ? $datos_vista['paciente']['datos_generales'][0]['area_nombre'] : '' }}</li>
            <li class="list-group-item list-group-timeline-primary"><strong>Subarea:</strong> {{ isset($datos_vista['paciente']['datos_generales'][0]['subarea_nombre']) ? $datos_vista['paciente']['datos_generales'][0]['subarea_nombre'] : '' }}</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="divider divider-dashed">
      <div class="divider-text texto-subtitulo">Datos del chequeo</div>
    </div>

    <div class="row">
      <div class="col-md-6" style="justify-content: center;display: flex;">
        <div style="">
          <ul class="list-group list-group-timeline">
            <li class="list-group-item list-group-timeline-success" style="align-items: center;display: flex;"><span class="mdi mdi-human-male-height mdi-36px p-2"></span><strong>Altura:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->altura.' m' : '' }}</mark></li>
            <li class="list-group-item list-group-timeline-success" style="align-items: center;display: flex;"><span class="mdi mdi-weight-kilogram mdi-36px p-2"></span><strong>Peso:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->peso.' kg' : '' }}</mark></li>
            <li class="list-group-item list-group-timeline-success" style="align-items: center;display: flex;"><span class="mdi mdi-scale-bathroom mdi-36px p-2"></span><strong>I.M.C:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->imc.' kg/m²' : '' }}</mark></li>
            <li class="list-group-item list-group-timeline-success" style="align-items: center;display: flex;"><span class="mdi mdi-thermometer mdi-36px p-2"></span><strong>Temperatura:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->temperatura.' °C' : '' }}</mark></li>
          </ul>
        </div>
      </div>

      <div class="col-md-6" style="justify-content: center;display: flex;">
        <div style="">
          <ul class="list-group list-group-timeline">
            <li class="list-group-item list-group-timeline-success" style="align-items: center;display: flex;"><span class="mdi mdi-lungs mdi-36px p-2"></span><strong>Saturación de oxígeno:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->saturacion_oxigeno.' %' : '' }}</mark></li>
            <li class="list-group-item list-group-timeline-success" style="align-items: center;display: flex;"><span class="mdi mdi-heart-pulse mdi-36px p-2"></span><strong>Frecuencia cardíaca:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->frecuencia_cardiaca.' Lpm' : '' }}</mark></li>
            <li class="list-group-item list-group-timeline-success" style="align-items: center;display: flex;"><span class="mdi mdi-heart mdi-36px p-2"></span><strong>Presión arterial:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->presion_arterial.' mmHg' : '' }}</mark></li>
            <li class="list-group-item list-group-timeline-success" style="align-items: center;display: flex;"><span class="mdi {{ (isset($datos_vista['paciente']['detalles_consulta']) && $datos_vista['paciente']['detalles_consulta']->paciente_tipo_visita_id == 1) ? 'mdi-virus' : 'mdi-account-injury' }} mdi-36px p-2"></span><strong>Tipo de visita:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta']) && $datos_vista['paciente']['detalles_consulta']->paciente_tipo_visita_id == 1) ? 'Enfermedad general' : 'Riesgo de trabajo' }}</mark></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="divider divider-dashed">
      <div class="divider-text texto-subtitulo">Motivo de consulta</div>
    </div>

    <div class="row">
      <div class="col-md-6" style="justify-content: center;display: flex;">
        <div style="">
          <ul class="list-group list-group-timeline">
            <li class="list-group-item list-group-timeline-warning" style="align-items: center;display: flex;"><span class="mdi mdi-clipboard-text mdi-36px p-2"></span><strong>CIE:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->cie_descripcion : '' }}</mark></li>
            <li class="list-group-item list-group-timeline-warning" style="align-items: center;display: flex;"><span class="mdi mdi-comment-text mdi-36px p-2"></span><strong>Motivo de la consulta:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->motivo_consulta : '' }}</mark></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6" style="justify-content: center;display: flex;">
        <div style="">
          <ul class="list-group list-group-timeline">
            <li class="list-group-item list-group-timeline-warning" style="align-items: center;display: flex;"><span class="mdi mdi-eye mdi-36px p-2"></span><strong>Observaciones:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->observaciones : 'Sin observaciones' }}</mark></li>
            <li class="list-group-item list-group-timeline-warning" style="align-items: center;display: flex;"><span class="mdi mdi-pill mdi-36px p-2"></span><strong>Medicamento recetado:</strong> <mark>{{ (isset($datos_vista['paciente']['detalles_consulta'])) ? $datos_vista['paciente']['detalles_consulta']->medicamento_recetado : 'Sin medicamento recetado' }}</mark></li>
          </ul>
        </div>
      </div>
    </div>

    <form id="form-nota_expediente" method="POST" enctype="multipart/form-data" onSubmit="return false">
      @csrf
      <div class="row mt-5">
        <div class="col-md-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <textarea class="form-control h-px-100" id="paciente_datos_consulta_nota-descripcion" name="paciente_datos_consulta_nota[descripcion]" placeholder="Escribe la nota a imprimir..."></textarea>
            <label for="paciente_datos_consulta_nota-descripcion">Nota de evolución:</label>
          </div>
        </div>
        <div class="col-md-12 mb-4 text-end no-imprimir">
          <button id="boton-imprimir_nota_consulta_externa" type="button" class="btn btn-warning me-2">
            <span class="mdi mdi-printer" style="margin-right: 10px;"></span>Imprimir nota
          </button>
          <button class="btn btn-secondary waves-effect waves-light me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#canvasNotasDeEnvio" aria-controls="canvasNotasDeEnvio">
            <span class="mdi mdi-page-next-outline" style="margin-right: 10px;"></span>Ver notas
          </button>
        </div>
      </div>
    </form>

    <div class="col-md-12 no-imprimir">
      <div class="btn-flex-group" style="position: fixed; bottom: 2rem; right: 0.8rem; z-index: 1080;">
        <a href="/" class="btn btn-principal waves-effect waves-light me-2" type="button" >
          <span class="mdi mdi-home me-2"></span>Inicio
        </a>
      </div>
    </div>
  </div>

  {{-- Detalles de la consulta anterior en un modal lateral --}}
  <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="canvasNotasDeEnvio" aria-labelledby="canvasNotasDeEnvioLabel" style="width: 700px;">
    <div class="offcanvas-header">
      <h5 id="canvasNotasDeEnvioLabel" class="offcanvas-title"><span class="mdi mdi-message-bulleted"></span> Notas de la consulta</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body my-auto mx-0 flex-grow-0">
      <p class="{{ $datos_vista['notas']?'d-none':'' }}"><span class="mdi mdi-message-bulleted-off"></span><strong> Sin Notas agregadas.</strong></p>
      <ul class="list-group list-group-timeline">
        @foreach($datos_vista['notas'] as $nota)
          <li class="list-group-item list-group-timeline-success"><strong class="me-1">Nota:</strong> {{ $nota['descripcion'] }}. </br><strong class="me-1">Fecha:</strong> {{ \Carbon\Carbon::parse($nota['created_at'])->format('d/m/Y H:i:s') }}</li>
        @endforeach

      </ul>
      <button type="button" class="btn btn-outline-warning d-grid w-100 mt-5" onclick="window.location.reload()">Recargar</button>
      <button type="button" class="btn btn-outline-danger d-grid w-100 mt-1" data-bs-dismiss="offcanvas">Cerrar</button>
    </div>
  </div>
@endsection
