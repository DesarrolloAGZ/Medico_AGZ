$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  $('.select2').select2();

  // Inicializa el formulario de valoracion
  const formValoracionPaciente = document.getElementById('form-registrar_nuevo_paciente');
  const validacionesValoracionPaciente = FormValidation.formValidation(formValoracionPaciente, {
    fields: {
      'paciente_datos_consulta[motivo_consulta]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          stringLength: {
            min: 3,
            message: 'El tamaño minimo es de 3 caracteres'
          },
          regexp: {
            regexp: /^[A-Za-zÑñáéíóúÁÉÍÓÚ0-9\s\$.,()¿?¡!'/_#:;]*$/,
            message: 'Solo se aceptan letras.'
          }
        }
      },
      'paciente_datos_consulta[cie_id]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          }
        }
      },
      'paciente_datos_consulta[temperatura]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^([0-9]{2}(\.[0-9]{1})?|[0-9]{1}(\.[0-9]{1})?)$/,
            message: 'Por favor ingrese una temperatura válida (por ejemplo: 36.5 o 37)'
          }
        }
      },
      'paciente_datos_consulta[peso]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^([0-9]{1,3}(\.[0-9]{1})?)$/, // Permite de 1 a 3 dígitos, con un solo decimal
            message: 'Por favor ingrese un peso válido (por ejemplo: 70 o 70.5)'
          }
        }
      },
      'paciente_datos_consulta[altura]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^[1-9]{1}[0-9]{0,2}(\.[0-9]{1,2})$/, // Permitirá números como 1.75 o 1.80
            message: 'Por favor ingrese una altura válida en formato m.cm (por ejemplo: 1.75 o 1.80)'
          }
        }
      },
      'paciente_datos_consulta[frecuencia_cardiaca]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^[1-9]{1}[0-9]{0,2}(\.[0-9]{1})?$/, // Permite números como 72, 85.5, 120, 99.9
            message: 'Por favor ingrese una frecuencia cardíaca válida (por ejemplo: 72 o 85.5)'
          }
        }
      },
      'paciente_datos_consulta[saturacion_oxigeno]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^(100(\.0{1})?|[1-9]{1}[0-9]{0,1}(\.[0-9]{1})?)$/, // Permite números entre 0 y 100, con un decimal opcional
            message: 'Por favor ingrese un valor de saturación de oxígeno válido (por ejemplo: 98 o 98.5)'
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

  // Boton para guardar la valoracion del paciente
  $('#boton-guardar_valoracion').click(async function (e) {
    var boton = $(this); // Referencia al botón
    boton.prop('disabled', true); // Deshabilitar el botón para evitar el doble clic

    const camposFormulario = validacionesValoracionPaciente.getFields(); // Variable para obtener los campos del formulario
    let campoInvalidoEncontrado = false; // Inicializamos la variable que cambiara cuando este un campo mal llenado

    // Iterar sobre cada campo en el formulario del registro del paciente
    for (const nameCampo in camposFormulario) {
      // Solo proceder si no se ha encontrado otro campo inválido
      if (camposFormulario.hasOwnProperty(nameCampo) && !campoInvalidoEncontrado) {
        const estadoCampo = await validacionesValoracionPaciente.validateField(nameCampo);

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
      // Pregunta si se desea guardar la valoracion del paciente
      alertify.confirm(
        '¿Estás seguro de guardar la valoración del paciente?',
        function (e, ui) {
          guardarValoracionPaciente();
          boton.prop('disabled', false);
        },
        function (e, ui) {
          alertify.error('Operación cancelada, no guardado');
          boton.prop('disabled', false);
        }
      );
    } else {
      boton.prop('disabled', false);
    }
  });

  // Funcion para guardar el registro de un paciente
  function guardarValoracionPaciente() {
    // Obtenemos el formulario de registro de paciente
    var formData = $('#form-registrar_nuevo_paciente').serialize();
    // CSRF Token al encabezado de la solicitud
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    var cie_descripcion = $('#paciente_datos_consulta-cie_id option:selected').text();
    formData += '&paciente_datos_consulta[cie_descripcion]=' + encodeURIComponent(cie_descripcion);

    pantallaCarga('on');

    $.ajax({
      url: '/pacientes/api/guardar-valoracion',
      method: 'POST',
      data: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      success: function (response) {
        if (response.error == false) {
          alertify.success(response.msg);
          setTimeout(function () {
            pantallaCarga('off');
            window.location.href = response.url;
          }, 3000); // Espera 3 segundos (3000 milisegundos)
        } else {
          pantallaCarga('off');
          alertify.error(response.msg);
        }
      },
      error: function () {
        pantallaCarga('off');
        // Si ocurre un error en la solicitud
        console.log('Error en la solicitud');
        alertify.error(
          '¡Lo sentimos! No fue posible guardar el registro. Inténtalo de nuevo y si el problema persiste contacta con el equipo de desarrollo.'
        );
      }
    });
  }
});

// Funcion para calcular automaticamente el IMC y ponerlo en el campo de IMC
function calculaIMC() {
  var peso = $('#paciente_datos_consulta-peso').val();
  var altura = $('#paciente_datos_consulta-altura').val();
  var imc = 0;

  if (peso > 0 && altura > 0) {
    imc = peso / (altura * altura);
  }

  $('#paciente_datos_consulta-imc').val(imc.toFixed(2));
}
