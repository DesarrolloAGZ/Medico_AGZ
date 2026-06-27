// ###################################################################################################
// ###################################################################################################
// ############################################## - VARIABLES
// ###################################################################################################
// ###################################################################################################
let signaturePadPaciente = null;

// ###################################################################################################
// ###################################################################################################
// ############################################## - FUNCIONES INICIALIZADAS
// ###################################################################################################
// ###################################################################################################
$(document).ready(function () {
  pantallaCarga('off');

  const inputEscaner = $('#inp-entrada_escaner');
  formateaCampoNumeroEmpleado("[name='inp[entrada_escaner]']");

  // Siempre mantener el foco
  inputEscaner.focus();

  $(document).on('click', function () {
    inputEscaner.focus();
  });

  // Cuando termina de escanear (Enter)
  inputEscaner.on('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault();

      let codigo = $(this).val().trim();

      if (codigo === '') {
        return;
      }

      pantallaCarga('on');

      buscarReceta(codigo);

      // Limpiar para el siguiente escaneo
      $(this).val('');
    }
  });
});

// ###################################################################################################
// ###################################################################################################
// ############################################## - FUNCIONES
// ###################################################################################################
// ###################################################################################################
function limpiarReceta() {
  pantallaCarga('on');
  // Ocultar tarjetas
  $('#card-detalles_receta').addClass('d-none');
  $('#card-detalles_medicamentos').addClass('d-none');
  $('#card-botones_acciones').addClass('d-none');

  // Limpiar datos de la receta
  $('#hidden-paciente_id').val('');
  $('#detalle_receta-folio').text('');
  $('#detalle_receta-fecha_emision').text('');
  $('#detalle_receta-medico_recetante').text('');
  $('#detalle_receta-medico_cedula').text('');

  // Limpiar datos del paciente
  $('#detalle_receta-paciente_nombre').text('');
  $('#detalle_receta-paciente_edad').text('');
  $('#detalle_receta-paciente_gafete').text('');
  $('#detalle_receta-paciente_curp').text('');

  // Avatar por defecto
  $('#detalle_receta-avatar').attr('src', '/assets/img/avatars/16.png');

  // Limpiar estatus
  $('#detalle_receta-estatus')
    .removeClass(function (index, className) {
      return (className.match(/(^|\s)bg-label-\S+/g) || []).join(' ');
    })
    .text('');

  // Limpiar medicamentos
  $('#detalle_receta-total_medicamentos').text('');
  $('#contenedor-medicamentos').empty();
  pantallaCarga('off');
}

function buscarReceta(codigo) {
  $.ajax({
    url: '/receta/api/obtener-detalle-receta',
    method: 'GET',
    data: {
      folioReceta: codigo
    },
    success: function (response) {
      pantallaCarga('off');

      if (response.error) {
        alertify.error(response.msg);
        limpiarReceta();

        return;
      }

      alertify.success(response.msg);

      var datos = response.receta.detalle_receta;

      // Mostrar tarjetas
      $('#card-detalles_receta').removeClass('d-none');
      $('#card-detalles_medicamentos').removeClass('d-none');
      $('#card-botones_acciones').removeClass('d-none');

      // Datos de la receta
      $('#hidden-paciente_id').val(datos.paciente_id);
      $('#detalle_receta-folio').text('#F-' + datos.receta_id);
      $('#detalle_receta-fecha_emision').text(datos.fecha_creacion);
      $('#detalle_receta-medico_recetante').text(
        'Dr. ' +
          datos.usuario_creador_nombre +
          ' ' +
          datos.usuario_creador_apellido_p +
          ' ' +
          datos.usuario_creador_apellido_m
      );
      $('#detalle_receta-medico_cedula').text(datos.cedula_profesional);

      // Datos del paciente
      $('#detalle_receta-paciente_nombre').text(
        datos.paciente_nombre + ' ' + datos.paciente_apellido_p + ' ' + datos.paciente_apellido_m
      );
      $('#detalle_receta-paciente_edad').text(datos.paciente_edad + ' años');
      $('#detalle_receta-paciente_gafete').text(datos.paciente_gafete);
      $('#detalle_receta-paciente_curp').text(datos.paciente_curp);

      const avatar = datos.paciente_genero === 'M' ? '/assets/img/avatars/17.png' : '/assets/img/avatars/16.png';

      $('#detalle_receta-avatar').attr('src', avatar);
      $('#detalle_receta-avatar').attr('src', avatar);

      // Estatus
      var $estatus = $('#detalle_receta-estatus');

      console.log(datos.estatus_id);

      if (datos.estatus_id != 1) {
        $('#boton-surtir_receta_completa').addClass('d-none');
      } else {
        $('#boton-surtir_receta_completa').removeClass('d-none');
      }

      $estatus
        .removeClass('text-success text-danger text-warning text-info')
        .addClass(datos.estatus_clase)
        .text(datos.estatus);

      // Medicamentos
      var datosMedicamentos = response.receta.medicamentos;
      // Total de medicamentos
      $('#detalle_receta-total_medicamentos').text(
        datosMedicamentos.length + (datosMedicamentos.length === 1 ? ' Medicamento' : ' Medicamentos')
      );

      // Limpiar tabla
      $('#contenedor-medicamentos').empty();

      // Agregar medicamentos
      $.each(datosMedicamentos, function (index, medicamento) {
        $('#contenedor-medicamentos').append(`
          <tr>
            <td class="text-center">
              <small>${index + 1}</small>
            </td>
            <td>
              <small>${medicamento.medicamento_nombre}</small>
            </td>
            <td class="text-center">
              <small>${medicamento.abreviatura}</small>
            </td>
            <td class="text-center">
              <small>${medicamento.cantidad_solicitada}</small>
            </td>
          </tr>
        `);
      });
    },
    error: function () {
      pantallaCarga('off');

      limpiarReceta();

      alertify.error(
        '¡Lo sentimos! No fue posible obtener los detalles de la receta. Inténtalo de nuevo y si el problema persiste contacta con el equipo de desarrollo.'
      );
    }
  });
}

function surtirReceta() {
  var recetaFolio = $('#detalle_receta-folio').text();
  recetaFolio = recetaFolio.split('-');
  var recetaid = recetaFolio[1];

  $.ajax({
    url: '/receta/api/surtir-receta-completa',
    method: 'GET',
    data: {
      recetaid: recetaid
    },
    success: function (response) {
      pantallaCarga('off');

      if (response.error) {
        alertify.error(response.msg);
        limpiarReceta();

        return;
      }

      alertify.success(response.msg);

      // Abrir modal para la firma del paciente
      abrirModalFirmaPaciente(recetaid);
    }
  });
}

function abrirModalFirmaPaciente(recetaid) {
  //Eliminar modal anterior si existe
  $('#modalFirmaPaciente').remove();

  $('body').append(`
    <div class="modal fade" id="modalFirmaPaciente" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white mb-3">
              <i class="mdi mdi-draw-pen me-2"></i>
              Firma de recibido del paciente
            </h5>
          </div>

          <div class="modal-body">
            <input type="hidden" id="firmaPacienteRecetaId" value="${recetaid}">
            <div class="alert alert-light border border-warning">
              <div class="d-flex align-items-start">
                <i class="mdi mdi-alert-circle text-warning fs-3 me-3"></i>
                <div>
                  <strong>Confirmación de entrega</strong>
                  <p class="mb-2 mt-1">
                    El paciente deberá firmar únicamente después de recibir los medicamentos correspondientes a esta receta.
                  </p>
                  <small class="text-danger fw-semibold">
                    La firma confirma la recepción de los medicamentos y esta acción no podrá deshacerse.
                  </small>
                </div>
              </div>
            </div>

            <label class="form-label fw-semibold mt-3">
              Firma del paciente
            </label>

            <canvas id="firmaPacienteCanvas" style="width:100%; height:280px; border:2px dashed #696cff; border-radius:8px; background:#fff; cursor:crosshair;"></canvas>
            <small class="text-muted">Firme dentro del recuadro.</small>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" onclick="limpiarFirmaPaciente()">
              <i class="mdi mdi-delete-outline me-1"></i>
              Limpiar
          </button>
          <button type="button" class="btn btn-success" onclick="guardarFirmaPaciente()">
            <i class="mdi mdi-check-circle-outline me-1"></i>
            Confirmar recepción
          </button>

        </div>
      </div>
    </div>
  </div>
`);

  $('#modalFirmaPaciente').modal('show');

  $('#modalFirmaPaciente').on('shown.bs.modal', function () {
    inicializarFirmaPaciente();
  });
}

function inicializarFirmaPaciente() {
  const canvas = document.getElementById('firmaPacienteCanvas');

  canvas.width = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;

  signaturePadPaciente = new SignaturePad(canvas);
}

function limpiarFirmaPaciente() {
  if (signaturePadPaciente) {
    signaturePadPaciente.clear();
  }
}

function guardarFirmaPaciente() {
  if (signaturePadPaciente.isEmpty()) {
    alertify.error('El paciente debe firmar para confirmar la recepción de los medicamentos.');

    return;
  }

  pantallaCarga('on');

  $.ajax({
    url: '/receta/api/guardar-firma-paciente',
    type: 'POST',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      recetaid: $('#firmaPacienteRecetaId').val(),
      firma: signaturePadPaciente.toDataURL(),
      paciente_id: $('#hidden-paciente_id').val()
    },

    success: function (response) {
      pantallaCarga('off');

      if (response.error) {
        alertify.error(response.msg);
        return;
      }

      $('#modalFirmaPaciente').modal('hide');
      $('#modalFirmaPaciente').remove();
      limpiarReceta();
      alertify.success(response.msg);
    },

    error: function () {
      pantallaCarga('off');
      alertify.error('Ocurrió un error al guardar la firma.');
    }
  });
}

// ###################################################################################################
// ###################################################################################################
// ############################################## - BOTONES
// ###################################################################################################
// ###################################################################################################
$('#boton-limpiar_datos_escaneo_receta').on('click', function () {
  limpiarReceta();
});

$('#boton-surtir_receta_completa').on('click', function () {
  pantallaCarga('on');
  surtirReceta();
});
