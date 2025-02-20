$(document).ready(function () {});

// Boton para buscar un paciente a registrar.
$('#boton-buscar_paciente').on('click', function () {
  // Obtenemos los datos del formulario
  var filtros = $('#form-filtros_buscar_paciente').serialize();

  // Realizamos la solicitud AJAX
  $.ajax({
    url: base_url + '/pacientes/consultar',
    type: 'POST',
    data: filtros,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Agrega el token CSRF aquí
    },
    success: function (response) {
      console.log(response);
    },
    error: function (xhr, status, error) {
      console.log('Error:', error);
    }
  });
});
