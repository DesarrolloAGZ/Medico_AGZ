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
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  generarTabla();
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
  var paciente_id = $('#paciente_id_hidden').val();

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
      url: '/pacientes/api/obtener-lista-consultas-paciente',
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        paciente_id: paciente_id // Pasar paciente_id como parte de los datos
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
      { data: 'motivo_consulta' },
      { data: 'codigo' },
      { data: 'temperatura' },
      { data: 'peso' },
      { data: 'altura' },
      { data: 'imc' },
      { data: 'frecuencia_cardiaca' },
      { data: 'saturacion_oxigeno' },
      { data: 'presion_arterial' },
      { data: 'fecha_registro' },
      { data: 'acciones' }
    ],
    columnDefs: [
      /* Acciones a realizar para cada fila */
      {
        targets: 0,
        title: 'Motivo de consulta',
        width: '300px',
        render: function (data, type, full, meta) {
          return `<small>${full.motivo_consulta != null ? full.motivo_consulta : ''}</small>`;
        }
      },
      {
        targets: 1,
        className: 'text-center',
        title: 'CIE-10',
        render: function (data, type, full, meta) {
          return `<small><b>${full.codigo != null ? full.codigo : ''}</b></small>`;
        }
      },
      {
        targets: 2,
        className: 'text-center',
        title: '°C',
        render: function (data, type, full, meta) {
          return `<small><b>${full.temperatura}</b></small>`;
        }
      },
      {
        targets: 3,
        className: 'text-center',
        title: 'kg',
        render: function (data, type, full, meta) {
          return `<small><b>${full.peso}</b></small>`;
        }
      },
      {
        targets: 4,
        className: 'text-center',
        title: 'Cm',
        render: function (data, type, full, meta) {
          return `<small><b>${full.altura}</b></small>`;
        }
      },
      {
        targets: 5,
        className: 'text-center',
        title: 'IMC',
        render: function (data, type, full, meta) {
          return `<small><b>${full.imc}</b></small>`;
        }
      },
      {
        targets: 6,
        className: 'text-center',
        title: 'Lpm',
        render: function (data, type, full, meta) {
          return `<small><b>${full.frecuencia_cardiaca}</b></small>`;
        }
      },
      {
        targets: 7,
        className: 'text-center',
        title: '%O',
        render: function (data, type, full, meta) {
          return `<small><b>${full.saturacion_oxigeno}</b></small>`;
        }
      },
      {
        targets: 8,
        className: 'text-center',
        title: 'mmHg',
        render: function (data, type, full, meta) {
          return `<small><b>${full.presion_arterial}</b></small>`;
        }
      },
      {
        targets: 9,
        className: 'text-center',
        title: 'Fecha consulta',
        render: function (data, type, full, meta) {
          // Formatear la fecha usando moment.js en español
          let fecha_creacion = moment(full.fecha_registro).format('DD MMMM YYYY, HH:mm');

          // Capitalizar la primera letra del mes
          fecha_creacion = capitalizeFirstLetter(fecha_creacion);

          return `<small>${fecha_creacion}</small>`;
        }
      }
    ],
    order: [[1, 'asc']],
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
        <button onclick="generarTabla()" type="button" title="Recargar tabla" class="btn btn-label-secondary"><span class="mdi mdi-autorenew me-1"></span></button>
    `);
    }
  });
}

// ###################################################################################################
// ###################################################################################################
// ############################################## - BOTONES
// ###################################################################################################
// ###################################################################################################
