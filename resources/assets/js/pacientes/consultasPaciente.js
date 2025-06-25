moment.locale('es');

// Función para capitalizar la primera letra de una cadena
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  generarTabla();
});

$('#boton-recargar-tabla-pacientes').on('click', function () {
  generarTabla();
});

function generarTabla() {
  var paciente_id = $('#paciente_id_hidden').val();

  // Verificar si la tabla ya existe y destruirla para evitar el error de reinitialise
  if ($.fn.DataTable.isDataTable('.datatables-basic-filas')) {
    $('.datatables-basic-filas').DataTable().clear().destroy();
  }

  let table = $('.datatables-basic-filas').DataTable({
    buttons: [
      {
        extend: 'excel',
        text: '<i class="fas fa-file-excel"></i>',
        title: 'Listado de consultas del paciente',
        filename: 'consultas_paciente_' + new Date().toISOString().slice(0, 10), // Nombre del archivo con fecha
        exportOptions: {
          modifier: {
            page: 'all'
          },
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        },
        footer: true
      },
      {
        extend: 'print',
        text: '<i class="fas fa-print"></i>',
        title: 'Listado de Expedientes',
        exportOptions: {
          modifier: {
            page: 'all'
          },
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        },
        customize: function (win) {
          $(win.document.body).css('font-size', '12pt');
        }
      }
    ],
    processing: true,
    serverSide: true,
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
      { data: 'id' },
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
      {
        className: 'control',
        orderable: false,
        responsivePriority: 2,
        targets: 0,
        visible: false
      },
      /* Acciones a realizar para cada fila */
      {
        targets: 1,
        title: 'Motivo de consulta',
        className: 'text-center',
        width: '300px',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <h6 class="mb-0">${full.motivo_consulta != null ? full.motivo_consulta : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 2,
        className: 'text-center',
        title: 'CIE-10',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.codigo != null ? full.codigo : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 3,
        className: 'text-center',
        title: '°C',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.temperatura}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 4,
        className: 'text-center',
        title: 'kg',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.peso}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 5,
        className: 'text-center',
        title: 'Cm',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row>
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.altura}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 6,
        className: 'text-center',
        title: 'IMC',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row>
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.imc}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 7,
        className: 'text-center',
        title: 'Lpm',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row>
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.frecuencia_cardiaca}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 8,
        className: 'text-center',
        title: '%O',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row>
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.saturacion_oxigeno}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 9,
        className: 'text-center',
        title: 'mmHg',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row>
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.presion_arterial}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 10,
        className: 'text-center',
        title: 'Fecha consulta',
        orderable: false,
        render: function (data, type, full, meta) {
          // Formatear la fecha usando moment.js en español
          let fecha_creacion = moment(full.fecha_registro).format('DD MMMM YYYY, HH:mm');

          // Capitalizar la primera letra del mes
          fecha_creacion = capitalizeFirstLetter(fecha_creacion);

          return `
                  <div class="row">
                    <div class="d-flex gap-2 align-items-center col-12">
                      <div class="card-info">
                          <small class="mb-0">${fecha_creacion}</small><br>
                      </div>
                    </div>
                  </div>`;
        }
      }
    ],
    order: [[1, 'asc']],
    displayLength: 10,
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"row"<"col-sm-12"B>><""t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [5, 10, 25, 50, 75, 100],
    language: {
      paginate: {
        // remove previous & next text from pagination
        previous: 'Anterior',
        next: 'Siguiente'
      }
    }
  });
}
