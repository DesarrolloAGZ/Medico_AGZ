<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
  <div class="{{ (!empty($containerNav) ? $containerNav : 'container-xxl') }}">
    <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        © <script>
          document.write(new Date().getFullYear())
        </script>
        , Creado por
        <span class="text-success" data-bs-toggle="tooltip" title="Ing. en Informática {{ (!empty(config('variables.creatorName')) ? config('variables.creatorName') : '') }}">
          AGRIZAR
        </span>
        .
      </div>
      <div> V1.0 </div>
    </div>
  </div>
</footer>
<!--/ Footer-->
