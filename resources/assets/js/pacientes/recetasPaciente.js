// ###################################################################################################
// ###################################################################################################
// ############################################## - VARIABLES
// ###################################################################################################
// ###################################################################################################
moment.locale('es');

// ###################################################################################################
// ###################################################################################################
// ############################################## - FUNCIONES INICIALIZADAS
// ###################################################################################################
// ###################################################################################################
$(document).ready(function () {
  pantallaCarga('off');

  generarTabla();

  formateaCampoNumeroEmpleado("[name='filtro-receta[numero_empleado]']");
  formateaCampoNumeroEmpleado("[name='filtro-receta[folio]']");
  formateaCampoNombre("[name='filtro-receta[empleado_nombre]']");
});

// ###################################################################################################
// ###################################################################################################
// ############################################## - FUNCIONES
// ###################################################################################################
// ###################################################################################################
// Función para capitalizar la primera letra de una cadena
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

function generarTabla() {
  // Obtener valores de los filtros
  const filtros = {
    fecha_inicio: $('#filtro-receta-fecha_inicio').val(),
    fecha_fin: $('#filtro-receta-fecha_fin').val(),
    numero_empleado: $('#filtro-receta-numero_empleado').val(),
    folio: $('#filtro-receta-folio').val(),
    empleado_nombre: $('#filtro-receta-empleado_nombre').val(),
    paciente_id: $('#paciente_id_hidden').val()
  };

  // Verificar si la tabla ya existe y destruirla para evitar el error de reinitialise
  if ($.fn.DataTable.isDataTable('.datatables-basic-filas')) {
    $('.datatables-basic-filas').DataTable().clear().destroy();
  }

  let table = $('.datatables-basic-filas').DataTable({
    buttons: [],
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url: '/pacientes/api/obtener-lista-recetas-paciente',
      type: 'POST',
      data: function (d) {
        d.fecha_inicio = filtros.fecha_inicio;
        d.fecha_fin = filtros.fecha_fin;
        d.numero_empleado = filtros.numero_empleado;
        d.folio = filtros.folio;
        d.empleado_nombre = filtros.empleado_nombre;
        d.paciente_id = filtros.paciente_id;
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function () {
        pantallaCarga('on');
      },
      complete: function () {
        pantallaCarga('off');
      },
      error: function (xhr, error, code) {
        if (xhr.status === 500) {
          // Si hay un error 500, espera 1 segundo y luego recarga los datos
          setTimeout(function () {
            table.ajax.reload();
          }, 1000);
        }
      }
    },
    columns: [
      { data: 'paciente_gafete' },
      { data: 'receta_id' },
      { data: 'paciente_nombre' },
      { data: 'medico_nombre' },
      { data: 'fecha_creacion' },
      { data: 'estatus_nombre' },
      { data: 'acciones' }
    ],
    columnDefs: [
      /* Acciones a realizar para cada fila */
      {
        targets: 0,
        title: 'Gafete',
        className: 'text-center',
        render: function (data, type, full, meta) {
          return `<small>${full.paciente_gafete != null ? full.paciente_gafete : ''}</small>`;
        }
      },
      {
        targets: 1,
        className: 'text-center',
        title: 'Folio receta',
        render: function (data, type, full, meta) {
          return `<small><b>#F-${full.receta_id != null ? full.receta_id : ''}</b></small>`;
        }
      },
      {
        targets: 2,
        title: 'Nombre paciente',
        className: 'text-center',
        render: function (data, type, full, meta) {
          return `<small>${
            full.paciente_nombre
              ? `${full.paciente_nombre} ${full.paciente_apellido_p ?? ''} ${full.paciente_apellido_m ?? ''}`.trim()
              : ''
          }</small>`;
        }
      },
      {
        targets: 3,
        title: 'Recetó',
        className: 'text-center',
        render: function (data, type, full, meta) {
          return `<small>${
            full.medico_nombre
              ? `${full.medico_nombre} ${full.medico_apellido_p ?? ''} ${full.medico_apellido_m ?? ''}`.trim()
              : ''
          }</small>`;
        }
      },
      {
        targets: 4,
        className: 'text-center',
        title: 'Fecha de creación',
        render: function (data, type, full, meta) {
          // Formatear la fecha usando moment.js en español
          let fecha_creacion = moment(full.fecha_creacion).format('DD MMMM YYYY, HH:mm');

          // Capitalizar la primera letra del mes
          fecha_creacion = capitalizeFirstLetter(fecha_creacion);

          return `<small>${fecha_creacion}</small>`;
        }
      },
      {
        targets: 5,
        title: 'Estatus receta',
        className: 'text-center',
        render: function (data, type, full, meta) {
          if (full.estatus_nombre) {
            return `
            <span class="badge rounded-pill badge-outline-dark ${full.estatus_clase}"><i class="${
              full.estatus_icono
            } me-2"></i>${full.estatus_nombre}</span>
            </br>
            <em><small>${
              full.se_entrego_medicamento == 1 ? 'Se entregó medicamento' : 'No se ha entregado medicamento'
            }</small></em>
            `;
          } else {
            return ``;
          }
        }
      }
    ],
    displayLength: 15,
    dom: '<"row"<"col-md-6"l><"col-md-6 d-flex justify-content-end align-items-center"<"toolbar-recetas me-2">>><"row"<"col-12"tr>><"row"<"col-md-6"i><"col-md-6"p>>',
    lengthMenu: [15, 30, 50, 75, 100, 150, 200],
    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron registros',
      info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
      infoEmpty: 'Mostrando 0 a 0 de 0 registros',
      infoFiltered: '(filtrado de _MAX_ registros totales)',
      search: 'Buscar:',
      loadingRecords: 'Cargando...',
      processing: 'Procesando...',
      emptyTable: 'No hay datos disponibles en la tabla',
      paginate: {
        first: 'Primero',
        last: 'Último',
        next: 'Siguiente',
        previous: 'Anterior'
      }
    },
    initComplete: function () {
      $('.toolbar-recetas').html(`
        <button onclick="borrarFiltrosTabla()" type="button" class="btn btn-label-warning" title="Borrar filtros"><span class="mdi mdi-filter-remove"></span></button>
        <button onclick="generarTabla()" type="button" title="Recargar tabla" class="btn btn-label-secondary"><span class="mdi mdi-autorenew me-1"></span></button>
    `);
    }
  });
}

function borrarFiltrosTabla() {
  // Borra los valores de los filtros
  $('#filtro-receta-fecha_inicio').val('');
  $('#filtro-receta-fecha_fin').val('');
  $('#filtro-receta-numero_empleado').val('');
  $('#filtro-receta-folio').val('');
  $('#filtro-receta-empleado_nombre').val('');

  // Muestra alerta de que se borraron filtros
  alertify.success('Filtros borrados correctamente.');

  generarTabla();
}

// ###################################################################################################
// ###################################################################################################
// ############################################## - BOTONES
// ###################################################################################################
// ###################################################################################################
