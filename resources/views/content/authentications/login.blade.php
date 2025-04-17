
@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
  <!-- AlertifyJS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
@endsection

@section('page-script')
  <script src="{{ asset('assets/js/login.js') }}"></script>
  <!-- AlertifyJS JS -->
  <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

  @if ($errors->has('correo'))
    <script>
      window.addEventListener('load', function () {
        alertify.error("{{ $errors->first('correo') }}");
      });
    </script>
  @endif
@endsection

@section('vendor-style')
@endsection

@section('vendor-script')
@endsection

@include('content.pages.pantalla-carga')

@section('content')
  <table class="centrada">
    <tr>
        <td class="centrada">
            <img src="{{ asset('images/logo.png') }}" class="responsive" />
        </td>
    </tr>
  </table>

  <section class="fondo-gradiente">
    <section class="contenedor-body">
      <div class="login-box">
        <p class="titulo-login mb-5">
          <span class="mdi mdi-medical-cotton-swab mdi-36px me-3"></span>
          Servicio Médico
          <span class="mdi mdi-medical-cotton-swab mdi-36px ms-3"></span>
        </p>
        <form id="frm-login" method="POST" action="{{ route('procesar-login') }}" style="padding: 50px;">
          @csrf
          <div class="user-box">
              <input type="text" name="correo" id="correo" required minlength="2" maxlength="191">
              <label id="labelUser">Usuario</label>
          </div>
          <div class="user-box">
            <input type="password" name="password" id="password" required minlength="8" maxlength="65">
            <label id="labelPass">Contraseña</label>
          </div>
          <center>
              <button class="logIn" id="btnLogin" value="Entrar">Autenticar<span></span></button>
          </center>
        </form>
      </div>
    </section>
  </section>
@endsection
