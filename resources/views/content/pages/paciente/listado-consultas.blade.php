@extends('layouts/layoutMaster')

@section('title', 'Listado Consultas totales')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/pacientes/todasConsultas.js') }}?v={{ date('YmdHis')}}"></script>
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

  <div class="card p-5">

    <div class="divider">
      <div class="divider-text texto-titulo">
        Listado de consultas totales
      </div>
    </div>
    <div class="divider text-start">
      <div class="divider-text"><span class="mdi mdi-filter-multiple me-2"></span>Filtros para buscar consulta</div>
    </div>

    {{-- Filtros para buscar consulta --}}
    <div class="row mt-2 mb-4">
      <div class="col-md-2 mb-3">
        <div class="form-floating form-floating-outline">
          <input type="date" class="form-control" id="filtro-consulta-fecha_inicio" placeholder="Selecciona la fecha inicial." onchange="generarTabla()" />
          <label for="filtro-consulta-fecha_inicio">Fecha inicio</label>
        </div>
      </div>
      <div class="col-md-2 mb-3">
        <div class="form-floating form-floating-outline">
          <input type="date" class="form-control" id="filtro-consulta-fecha_fin" placeholder="Selecciona la fecha final." onchange="generarTabla()" />
          <label for="filtro-consulta-fecha_fin">Fecha fin</label>
        </div>
      </div>
      <div class="col-md-2 mb-3">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" id="filtro-consulta-numero_empleado" placeholder="Escribe el numero de empleado." onkeyup="generarTabla()" />
          <label for="filtro-consulta-numero_empleado"># Empleado</label>
        </div>
      </div>
      <div class="col-md-2 mb-3">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" id="filtro-consulta-empleado_nombre" placeholder="Escribe el nombre del paciente." onkeyup="generarTabla()" />
          <label for="filtro-consulta-empleado_nombre">Nombre del paciente</label>
        </div>
      </div>

      <div class="col-md-2 mb-3">
        <div class="form-floating form-floating-outline mb-6">
          <select class="form-select select2" id="filtro-consulta-tipo_visita" onchange="generarTabla()">
            <option value="" selected disabled>Selecciona una opción</option>
            @foreach ($datos_vista['catalogos']['tipo_visita'] as $tipo_visita)
              <option value="{{ $tipo_visita['id'] }}" @if(isset($datos_vista['tipo_visita_seleccionado']) && $datos_vista['tipo_visita_seleccionado'] == $tipo_visita['id']) selected @endif>
                {{ $tipo_visita['nombre'] }}
              </option>
            @endforeach
          </select>
          <label for="filtro-consulta-tipo_visita">Tipo visita</label>
        </div>
      </div>

      {{-- Botones filtros --}}
      <div class="col-md-1 mb-3">
        <button type="button" title="Quitar filtros" style="background: #f4f4f6;" id="boton-borrar-filtros-consultas" class="btn btn-label-secondary"><span class="mdi mdi-filter-remove"></span></button>
      </div>
      <div class="col-md-1 mb-3">
        <button type="button" title="Recargar tabla" style="background: #f4f4f6;" id="boton-recargar-tabla-consultas" class="btn btn-label-secondary"><span class="mdi mdi-autorenew"></span></button>
      </div>
    </div>

    <div class="card-datatable table-responsive pt-0">
      <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
        <div class="row">
          <div class="col-md-12">
            <table class="table datatables-basic-filas table-hover table-striped w-100">
              <thead class="table-dark">
                <tr style="height: 50px;">
                  <th class="text-center">id</th>
                  <th class="text-center">Gafete</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Edad</th>
                  <th class="text-center">Tipo de visita</th>
                  <th class="text-center">CIE-10</th>
                  <th class="text-center">Observaciones</th>
                  <th class="text-center">Medicamento</th>
                  <th class="text-center">Empresa</th>
                  <th class="text-center">Unidad negocio</th>
                  <th class="text-center">Area</th>
                  <th class="text-center">Subarea</th>
                  <th class="text-center">Fecha de consulta</th>
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
        <a href="/" class="btn btn-principal waves-effect waves-light me-2" type="button" >
          <span class="mdi mdi-home me-2"></span>Inicio
        </a>
      </div>
    </div>
  </div>
@endsection
