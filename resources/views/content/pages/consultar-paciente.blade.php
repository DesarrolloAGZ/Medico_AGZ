@extends('layouts/layoutMaster')

@section('title', 'Consulta Paciente')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/pacientes/pacientes.js') }}"></script>
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}" >
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}" >
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" >
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" >
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" >
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" >
@endsection

@section('vendor-script')
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}" >
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}" >
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}" >
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}" >
  <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}" >
@endsection

@section('content')
  <div class="card p-5">
    <h5 class="card-title">Lista de Pacientes</h5>
    <table id="tabla-pacientes" class="display" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Edad</th>
          <th>Género</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Juan Pérez</td>
          <td>30</td>
          <td>Masculino</td>
          <td>
            <a href="#" class="btn btn-sm btn-info">Editar</a>
            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <tr>
          <td>1</td>
          <td>Juan Pérez</td>
          <td>30</td>
          <td>Masculino</td>
          <td>
            <a href="#" class="btn btn-sm btn-info">Editar</a>
            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <tr>
          <td>1</td>
          <td>Juan Pérez</td>
          <td>30</td>
          <td>Masculino</td>
          <td>
            <a href="#" class="btn btn-sm btn-info">Editar</a>
            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <tr>
          <td>1</td>
          <td>Juan Pérez</td>
          <td>30</td>
          <td>Masculino</td>
          <td>
            <a href="#" class="btn btn-sm btn-info">Editar</a>
            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <tr>
          <td>1</td>
          <td>Juan Pérez</td>
          <td>30</td>
          <td>Masculino</td>
          <td>
            <a href="#" class="btn btn-sm btn-info">Editar</a>
            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
        <tr>
          <td>1</td>
          <td>Juan Pérez</td>
          <td>30</td>
          <td>Masculino</td>
          <td>
            <a href="#" class="btn btn-sm btn-info">Editar</a>
            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection

@section('page-script')
<script>
  $(document).ready(function() {
    $('#tabla-pacientes').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
      }
    });
  });
</script>
@endsection
