@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Valoracion Paciente')

@section('page-style')
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/pacientes/valoracionPacientes.js') }}"></script>
  <script>
    var datos_vista = @json($datos_vista);
  </script>
@endsection

@section('vendor-style')
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
  <!-- Form Validation -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
@endsection

@section('vendor-script')
 <!-- Form Validation -->
 <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
@endsection

@include('content.pages.pantalla-carga')

@section('content')

@php
  // dd($datos_vista);
@endphp
  <div class="card p-5" style="width: 100%; height: 100%;">

    <div class="divider">
      <div class="divider-text texto-titulo">Valoración paciente</div>
    </div>

    <form id="form-registrar_nuevo_paciente" method="POST" enctype="multipart/form-data" onSubmit="return false">
      @csrf

      <input id="paciente_datos_consulta-paciente_id" name="paciente_datos_consulta[paciente_id]" type="text" style="display: none;" value="{{ isset($datos_vista) ? $datos_vista['paciente_id'] : '' }}">

      <div class="row">
        <div class="col-md-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <textarea class="form-control h-px-100" id="paciente_datos_consulta-motivo_consulta" name="paciente_datos_consulta[motivo_consulta]" placeholder="Escribe el motivo inicial de la consulta..."></textarea>
            <label for="paciente_datos_consulta-motivo_consulta">Motivo principal de la consulta <i class="text-danger">*</i></label>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <select class="form-select select2" id="paciente_datos_consulta-cie_id" name="paciente_datos_consulta[cie_id]">
              <option value="" selected disabled>Selecciona una opción</option>
              @foreach ($datos_vista['catalogos']['cie'] as $cie)
                <option value="{{ $cie['id'] }}">
                  {{ $cie['descripcion'] }}
                </option>
              @endforeach
            </select>
            <label for="paciente-paciente_empresa_id">CIE 10 <i class="text-danger">*</i></label>
          </div>
        </div>
      </div>

      <div class="{{ isset($datos_vista['paciente']['datos_ultima_consulta']) ? '' : 'd-none' }} }}">
        <div class="divider divider-dashed">
          <div class="divider-text texto-subtitulo">Datos de la ultima consulta</div>
        </div>

        <div class="row">

          <div class="col-md-2 mb-4">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="temperatura_anterior" type="text" placeholder="Temperatura de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->temperatura) ? $datos_vista['paciente']['datos_ultima_consulta']->temperatura : '' }}" disabled />
              <label for="temperatura_anterior">Temperatura (°C)</label>
            </div>
          </div>

          <div class="col-md-2 mb-4">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="peso_anterior" type="text" placeholder="Peso de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->peso) ? $datos_vista['paciente']['datos_ultima_consulta']->peso : '' }}" disabled />
              <label for="peso_anterior">Peso (Kg)</label>
            </div>
          </div>

          <div class="col-md-2 mb-4">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="altura_anterior" type="text" placeholder="Altura de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->altura) ? $datos_vista['paciente']['datos_ultima_consulta']->altura : '' }}" disabled />
              <label for="altura_anterior">Altura (m.cm)</label>
            </div>
          </div>

          <div class="col-md-2 mb-4">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="imc_anterior" type="text" placeholder="I.M.C de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->imc) ? $datos_vista['paciente']['datos_ultima_consulta']->imc : '' }}" disabled />
              <label for="imc_anterior">I.M.C</label>
            </div>
          </div>

          <div class="col-md-2 mb-4">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="frecuencia_cardiaca_anterior" type="text" placeholder="Frecuencia cardiaca de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->frecuencia_cardiaca) ? $datos_vista['paciente']['datos_ultima_consulta']->frecuencia_cardiaca : '' }}" disabled />
              <label for="frecuencia_cardiaca_anterior">Frec. cardiaca (lpm)</label>
            </div>
          </div>

          <div class="col-md-2 mb-4">
            <div class="form-floating form-floating-outline">
              <input class="form-control" id="saturacion_oxigeno_anterior" type="text" placeholder="Saturacion de oxigeno de la ultima consulta" value="{{ isset($datos_vista['paciente']['datos_ultima_consulta']->saturacion_oxigeno) ? $datos_vista['paciente']['datos_ultima_consulta']->saturacion_oxigeno : '' }}" disabled />
              <label for="saturacion_oxigeno_anterior">Sat. de oxígeno (%)</label>
            </div>
          </div>

        </div>
      </div>

      <div class="divider divider-dashed {{ isset($datos_vista['paciente']['datos_ultima_consulta']) ? '' : 'd-none' }} }}">
        <div class="divider-text texto-subtitulo">Registro de datos actuales</div>
      </div>

      <div class="row">

        <div class="col-md-2 mb-4">
          <div class="form-floating form-floating-outline">
            <input class="form-control" id="paciente_datos_consulta-temperatura" name="paciente_datos_consulta[temperatura]" type="text" placeholder="Ingresa la temperatura" />
            <label for="paciente_datos_consulta-temperatura">Temperatura (°C) <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-2 mb-4">
          <div class="form-floating form-floating-outline">
            <input class="form-control" id="paciente_datos_consulta-peso" name="paciente_datos_consulta[peso]" type="text" placeholder="Ingresa el peso" onkeyup="calculaIMC()" />
            <label for="paciente_datos_consulta-peso">Peso (Kg) <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-2 mb-4">
          <div class="form-floating form-floating-outline">
            <input class="form-control" id="paciente_datos_consulta-altura" name="paciente_datos_consulta[altura]" type="text" placeholder="Ingresa la altura" onkeyup="calculaIMC()" />
            <label for="paciente_datos_consulta-altura">Altura (m.cm) <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-2 mb-4">
          <div class="form-floating form-floating-outline">
            <input class="form-control solo_visualizar" id="paciente_datos_consulta-imc" name="paciente_datos_consulta[imc]" type="text" placeholder="Ingresa el I.M.C" readonly />
            <label for="paciente_datos_consulta-imc">I.M.C <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-2 mb-4">
          <div class="form-floating form-floating-outline">
            <input class="form-control" id="paciente_datos_consulta-frecuencia_cardiaca" name="paciente_datos_consulta[frecuencia_cardiaca]" type="text" placeholder="Ingresa la frecuencia cardiaca" />
            <label for="paciente_datos_consulta-frecuencia_cardiaca">Frec. cardiaca (lpm) <i class="text-danger">*</i></label>
          </div>
        </div>

        <div class="col-md-2 mb-4">
          <div class="form-floating form-floating-outline">
            <input class="form-control" id="paciente_datos_consulta-saturacion_oxigeno" name="paciente_datos_consulta[saturacion_oxigeno]" type="text" placeholder="Ingresa la saturacion de oxigeno" />
            <label for="paciente_datos_consulta-saturacion_oxigeno">Sat. de oxígeno (%) <i class="text-danger">*</i></label>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <textarea class="form-control h-px-100" id="paciente_datos_consulta-observaciones" name="paciente_datos_consulta[observaciones]" placeholder="Escribe las observaciones de la consulta..."></textarea>
            <label for="paciente_datos_consulta-observaciones">Observaciones</label>
          </div>
        </div>

        <div class="col-md-6 mb-4">
          <div class="form-floating form-floating-outline mb-6">
            <textarea class="form-control h-px-100" id="paciente_datos_consulta-medicamento_recetado" name="paciente_datos_consulta[medicamento_recetado]" placeholder="Escribe el medicamento recetado..."></textarea>
            <label for="paciente_datos_consulta-medicamento_recetado">Medicamento recetado</label>
          </div>
        </div>
      </div>

    </form>

    <div class="col-md-12">
      <div class="btn-flex-group" style="position: fixed; bottom: 2rem; right: 0.8rem; z-index: 1080;">
        <a href="/" class="btn btn-principal waves-effect waves-light me-2" type="button" >
          <span class="mdi mdi-home me-2"></span>Inicio
        </a>

        <button class="btn btn-success waves-effect waves-light me-2" id="boton-guardar_valoracion" type="button" style="box-shadow: 0 1px 20px 1px #72e128 !important;">
          <span class="mdi mdi-content-save" style="margin-right: 10px;"></span>Guardar Valoración
        </button>

      </div>
    </div>

  </div>
@endsection
