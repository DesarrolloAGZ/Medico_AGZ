@php
$containerNav = $containerNav ?? 'container-xxl';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
  <nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
@endif
  @if(isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
      <div class="{{$containerNav}}">
  @endif
    @if(isset($navbarFull))
      <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="{{ url('/') }}" class="app-brand-link">
          <span class="app-brand-logo demo">
          </span>
          <span class="app-brand-text demo menu-text fw-bold ms-2">
            {{ config('variables.templateName') }}
          </span>
        </a>
      </div>
    @endif
      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)" id="mobileMenuToggle">
            <i class="mdi mdi-menu mdi-24px"></i>
          </a>
        </div>
      @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <!-- Style Switcher -->
        <div class="navbar-nav align-items-center">
          <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
            <i class='mdi mdi-24px'></i>
          </a>
        </div>
        <!--/ Style Switcher -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" id="userDropdownToggle">
              <div class="avatar avatar-online">
                <img src="{{ asset('assets/img/avatars/16.png') }}" alt class="w-px-40 h-auto rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" id="userDropdownMenu" style="display: none; right: 0px;">
              <!-- Opciones del menú -->
              <li style="pointer-events: none;">
                <a class="dropdown-item" href="">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/16.png') }}" alt class="w-px-40 h-auto rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <span class="fw-semibold d-block">
                        @if (Auth::check())
                        {{ Auth::user()->username }}
                        @else
                        @endif
                      </span>
                      <small class="text-muted">Agrizar</small>
                    </div>
                  </div>
                </a>
              </li>
              <!-- Otras opciones -->
              <li style="pointer-events: none;">
                <a class="" href="javascript:void(0);">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item" style="pointer-events: auto;">
                      <i class="mdi mdi-logout me-2"></i>
                      <span class="align-middle">Cerrar sesión</span>
                    </button>
                  </form>
                </a>
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

    @if(!isset($navbarDetached))
      </div>
    @endif
</nav>

<style>
  /* Estilo personalizado para hover del menú usuario */
  #userDropdownMenu .dropdown-item:hover {
    color: #dc3545 !important;
  }
</style>

<!-- / Navbar -->
<script>
  document.addEventListener('DOMContentLoaded', function () {

    // *****************************************************************
    // ***************************************** Toggle del menú lateral
    // *****************************************************************
    if (window.location.pathname === '/') {
      const menuToggle = document.getElementById('mobileMenuToggle');
      const menu = document.getElementById('layout-menu');

      menuToggle?.addEventListener('click', (e) => {
        e.stopPropagation();
        document.body.classList.toggle('layout-menu-expanded');
      });

      // Cerrar al hacer clic fuera
      document.addEventListener('click', (e) => {
        if (!menu?.contains(e.target) && !menuToggle?.contains(e.target)) {
          document.body.classList.remove('layout-menu-expanded');
        }
      });
    }

    // *****************************************************************
    // **************************  Menu del avatar y el menú desplegable
    // *****************************************************************
    const dropdownToggle = document.getElementById('userDropdownToggle');
    const dropdownMenu = document.getElementById('userDropdownMenu');

    // Añadimos el evento de clic en el avatar
    dropdownToggle.addEventListener('click', function (event) {
      // Evitar que el enlace haga su acción por defecto
      event.preventDefault();

      // Alternamos la visibilidad del menú desplegable
      if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
        dropdownMenu.style.display = 'block';  // Mostrar el menú
      } else {
        dropdownMenu.style.display = 'none';  // Ocultar el menú
      }
    });

    // Cerrar el menú si el usuario hace clic fuera de él
    document.addEventListener('click', function (event) {
      if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
        dropdownMenu.style.display = 'none';  // Cerrar el menú si se hace clic fuera
      }
    });
  });
</script>
