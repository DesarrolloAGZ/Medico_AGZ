$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  $('.select2').select2();

  // Inicializa las validaciones para imprimir la nota
  const formReceta = document.getElementById('form-receta');
  const validacionesReceta = FormValidation.formValidation(formReceta, {
    fields: {
      'receta[paciente_id]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          }
        }
      },
      'receta[medicamento_indicaciones]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          stringLength: {
            min: 3,
            message: 'El tamaño minimo es de 3 caracteres'
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

  $('#boton-imprimir_receta').click(async function (e) {
    e.preventDefault();

    const camposFormulario = validacionesReceta.getFields(); // Variable para obtener los campos del formulario
    let campoInvalidoEncontrado = false; // Inicializamos la variable que cambiara cuando este un campo mal llenado

    // Iterar sobre cada campo en el formulario del registro del paciente
    for (const nameCampo in camposFormulario) {
      // Solo proceder si no se ha encontrado otro campo inválido
      if (camposFormulario.hasOwnProperty(nameCampo) && !campoInvalidoEncontrado) {
        const estadoCampo = await validacionesReceta.validateField(nameCampo);

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
        '¿Desea guardar e imprimir la receta?',
        function (e, ui) {
          document.querySelector('.alertify')?.style.setProperty('display', 'none', 'important');
          guardarReceta();
        },
        function (e, ui) {
          // alertify.error('Operación cancelada, no guardado');
        }
      );
    }
  });
});

function colocarPacienteEnReceta(elm) {
  const pacienteId = elm.value;
  // Busca el paciente con ese ID
  const paciente = datos_vista.pacientes.find(p => p.id == pacienteId);

  if (paciente) {
    $('#paciente_receta-nombre').text(
      paciente.nombre + ' ' + paciente.apellido_paterno + ' ' + paciente.apellido_materno
    );
    $('#paciente_receta-edad').text(paciente.edad);
  } else {
    // alertify.error('Ocurrio un error, intenta de nuevo. Si el problema continua contacta con el equipo de desarrollo');
  }
}

function guardarReceta() {
  // Obtenemos el formulario de registro de paciente
  var formData = $('#form-receta').serialize();
  // CSRF Token al encabezado de la solicitud
  var csrfToken = $('meta[name="csrf-token"]').attr('content');

  pantallaCarga('on');

  $.ajax({
    url: '/receta/api/registrar-receta',
    method: 'POST',
    data: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    success: function (response) {
      pantallaCarga('off');
      if (response.error == false) {
        window.print();
        $('#receta-paciente_id').val('').trigger('change'); // Limpiamos el campo de paciente
        $('#paciente_receta-nombre').text(''); // Limpiamos el label del paciente en la receta
        $('#paciente_receta-edad').text(''); // Limpiamos el label de la edad del paciente
        $('#receta-medicamento_indicaciones').val(''); // Limpiamos el campo de las indicaciones de la receta
        $('#receta-recomendaciones').val(''); // Limpiamos el campo de las recomendaciones de la receta
        $('#receta-folio').text('#F-' + (response.receta_id + 1)); // Actualizamos el folio al siguiente
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
