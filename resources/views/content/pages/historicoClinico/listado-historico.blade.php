@extends('layouts/layoutMaster')

@section('title', 'Listado Historicos clinicos')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/historicoClinico/seguimientoHistorico.js') }}?v={{ date('YmdHis')}}"></script>
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
  <div class="card p-5">
    <div class="divider">
      <div class="divider-text texto-titulo">Listado de históricos clínicos</div>
    </div>
    <div class="card-datatable table-responsive pt-0">
      <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
        <div class="row">
          <div class="col-md-12" style="text-align: end;">
            <button type="button" style="background: #f4f4f6;" id="boton-recargar-tabla-historicos" class="btn btn-label-secondary"><span class="mdi mdi-autorenew me-1"></span></button>
          </div>
        </div>
        <div class="row">
          <div class="table-responsive">
            <table class="table datatables-basic-filas table-hover table-striped">
              <thead class="table-dark">
                <tr style="height: 50px;">
                  <th>#</th>
                  <th class="text-center">Tipo de histórico</th>
                  <th class="text-center">CURP</th>
                  <th class="text-center">Nombre</th>
                  <th class="text-center">Genero</th>
                  <th class="text-center">Edad</th>
                  <th class="text-center">Antidoping</th>
                  <th class="text-center">Calificación</th>
                  <th class="text-center">IDX</th>
                  <th class="text-center">Fecha creación</th>
                  <th class="text-center" style="width: 100px;">Acciones</th>
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
