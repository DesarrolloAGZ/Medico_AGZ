$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  // Inicializa las validaciones para imprimir la nota
  const formExpediente = document.getElementById('form-nota_expediente');
  const validacionesExpediente = FormValidation.formValidation(formExpediente, {
    fields: {
      'paciente_datos_consulta_nota[descripcion]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: '.row'
      })
    }
  });

  $('#boton-imprimir_nota_consulta_externa').click(async function (e) {
    e.preventDefault();

    const camposFormulario = validacionesExpediente.getFields(); // Variable para obtener los campos del formulario
    let campoInvalidoEncontrado = false; // Inicializamos la variable que cambiara cuando este un campo mal llenado

    // Iterar sobre cada campo en el formulario del registro del paciente
    for (const nameCampo in camposFormulario) {
      // Solo proceder si no se ha encontrado otro campo inválido
      if (camposFormulario.hasOwnProperty(nameCampo) && !campoInvalidoEncontrado) {
        const estadoCampo = await validacionesExpediente.validateField(nameCampo);

        if (estadoCampo === 'Invalid') {
          const primerCampoInvalido = $(`[name="${nameCampo}"]`);
          if (primerCampoInvalido.length) {
            primerCampoInvalido.focus();
            campoInvalidoEncontrado = true;
          }
          break;
        }
      }
    }

    // Si no hay campos invalidos entra
    if (!campoInvalidoEncontrado) {
      // Pregunta si se desea guardar el registro del paciente
      alertify.confirm(
        '¿Desea guardar e imprimir la nota de evolución?',
        function (e, ui) {
          document.querySelector('.alertify')?.style.setProperty('display', 'none', 'important');
          guardarNota();
        },
        function (e, ui) {
          // alertify.error('Operación cancelada, no guardado');
        }
      );
    }
  });
});

function guardarNota() {
  // Obtenemos el formulario de registro de paciente
  var formData = $('#form-nota_expediente').serialize();
  // CSRF Token al encabezado de la solicitud
  var csrfToken = $('meta[name="csrf-token"]').attr('content');

  var paciente_id = datos_vista.paciente.datos_generales[0].id;
  var paciente_datos_consulta_id = datos_vista.paciente.detalles_consulta.id;
  formData +=
    '&paciente_datos_consulta_nota[paciente_id]=' +
    encodeURIComponent(paciente_id) +
    '&paciente_datos_consulta_nota[paciente_datos_consulta_id]=' +
    encodeURIComponent(paciente_datos_consulta_id);

  pantallaCarga('on');

  $.ajax({
    url: '/pacientes/api/registrar-nota',
    method: 'POST',
    data: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    success: function (response) {
      pantallaCarga('off');
      if (response.error == false) {
        window.print();
        document.getElementById('paciente_datos_consulta_nota-descripcion').value = '';
      } else {
        alertify.error(response.msg);
      }
    },
    error: function () {
      // Si ocurre un error en la solicitud
      console.log('Error en la solicitud');
      alertify.error(
        '¡Lo sentimos! No fue posible guardar la nota. Inténtalo de nuevo y si el problema persiste contacta con el equipo de desarrollo.'
      );
    }
  });
}
