<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ (!empty($containerNav) ? $containerNav : 'container-xxl') }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        © <script>document.write(new Date().getFullYear())</script> | Creado por
        <span class="text-success" data-bs-toggle="tooltip" data-bs-placement="top" title=" Desarrollador - Ing. Informático {{ (!empty(config('variables.creatorName')) ? config('variables.creatorName') : '') }}">
          AGRIZAR
        </span>
        .
      </div>
      <div>V1.4</div>
    </div>
  </div>
</footer>
<!--/ Footer-->

<!-- Agrega el script de Bootstrap para tooltip -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Inicializa todos los tooltips en la página
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });
</script>
