
@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
  <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
  <!-- AlertifyJS CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
  <style>
    html{
      zoom: 1 !important;
    }
  </style>
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
  <div class="login-container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center">
      <div class="container login-container">
        <div class="row justify-content-end">
          <div class="col-lg-6 col-md-12 col-sm-12 d-flex flex-column align-items-center justify-content-center">

            <div class="card">
              <div class="card-body">
                <div class="pt-4 mt-3">
                  <h5 class="card-title text-center pb-0 fs-4">Inicio de sesión</h5>
                </div>

                <form class="row g-3 needs-validation mb-2" id="frm-login" method="POST" action="{{ route('procesar-login') }}" >
                  @csrf
                  <div class="col-12">
                    <label for="correo" class="form-label">Usuario</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-user" style="color: #828282 !important; font-size: 20px !important;"></i></span>
                      <input type="text" name="correo" class="form-control" style=" border-end-end-radius: 15px !important; border-start-end-radius: 15px !important" id="correo" required minlength="2" maxlength="191" oninput="this.value = this.value.toLowerCase();">
                      <div class="invalid-feedback">Por favor ingrese su usuario.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-key" style="color: #828282 !important; font-size: 20px !important;"></i></span>
                      <input type="password" name="password" class="form-control" id="password" required minlength="8" maxlength="65">
                      <div class="invalid-feedback">Por favor ingrese su contraseña</div>
                      <div class="input-group-text" onclick="mostrarContrasena()">
                        <i id="iconoPassword" class="fas fa-eye" style="color: #828282 !important; font-size: 20px !important;"></i>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 mb-4 mt-4">
                    <button id="btnLogin" class="btn btn-success w-100" type="submit">INGRESAR <i class="fa-solid fa-chevron-right ms-3"></i></button>
                  </div>

                </form>

                <div class="row mb-4">
                  <div class="col-4 text-center"><i class="fa-solid fa-user-shield" style="font-size: 30px;"></i></br>Confidencialidad</div>
                  <div class="col-4 text-center"><i class="fa-solid fa-shield-halved" style="font-size: 30px;"></i></br>Seguridad</div>
                  <div class="col-4 text-center"><i class="fa-regular fa-star" style="font-size: 30px;"></i></br>Calidad</div>
                </div>

              </div>
            </div>

            <div class="text-center mt-3 soporte-login">
              <i class="fa-solid fa-headset me-2"></i>
              <span>
                ¿Problemas para ingresar al sistema?
                <a href="https://servicedesk.agrizar.com/WOListView.do" target="_blank" class="link-soporte">
                  Genera un ticket de soporte aquí
                </a>.
              </span>
            </div>

          </div>
        </div>
      </div>
      <div class="row w-100 copi-etiqueta">
        <div class="col-md-12 text-center">
          <small class="text-white fs-6" style="opacity: 0.6;">© {{ date('Y') }} Agrizar. Sistema de Servicio Médico. Todos los derechos reservados.</small>
        </div>
      </div>
    </section>

  </div>
@endsection
