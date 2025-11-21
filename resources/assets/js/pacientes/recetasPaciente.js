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

$('#boton-recargar-tabla-recetas').on('click', function () {
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
        title: 'Listado de recetas del paciente',
        filename: 'consultas_paciente_' + new Date().toISOString().slice(0, 10), // Nombre del archivo con fecha
        exportOptions: {
          modifier: {
            page: 'all'
          },
          columns: [1, 2, 3, 4, 5]
        },
        footer: true
      },
      {
        extend: 'print',
        text: '<i class="fas fa-print"></i>',
        title: 'Listado de recetas del paciente',
        exportOptions: {
          modifier: {
            page: 'all'
          },
          columns: [1, 2, 3, 4, 5]
        },
        customize: function (win) {
          $(win.document.body).css('font-size', '12pt');
        }
      }
    ],
    processing: true,
    serverSide: true,
    ajax: {
      url: '/pacientes/api/obtener-lista-recetas-paciente',
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
      { data: 'nombre' },
      { data: 'indicaciones_medicamento' },
      { data: 'recomendaciones' },
      { data: 'id' },
      { data: 'fecha_creacion' },
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
        title: 'Recetó',
        className: 'text-center',
        width: '300px',
        render: function (data, type, full, meta) {
          return `
            <div class="row">
              <div class="d-flex gap-2 align-items-center col-12">
                <div class="card-info">
                  ${full.nombre ? `${full.nombre} ${full.apellido_p ?? ''} ${full.apellido_m ?? ''}`.trim() : ''}
                </div>
              </div>
            </div>`;
        }
      },
      {
        targets: 2,
        className: 'text-center',
        title: 'Indicaciones del medicamento',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                              <small class="mb-0">${
                                full.indicaciones_medicamento != null ? full.indicaciones_medicamento : ''
                              }</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 3,
        className: 'text-center',
        title: 'Recomendaciones',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                   <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                              <small class="mb-0">${full.recomendaciones != null ? full.recomendaciones : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 4,
        className: 'text-center',
        title: 'Folio',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                   <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                              <small class="mb-0">#F-${full.id != null ? full.id : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 5,
        className: 'text-center',
        title: 'Fecha de creación',
        orderable: false,
        render: function (data, type, full, meta) {
          // Formatear la fecha usando moment.js en español
          let fecha_creacion = moment(full.fecha_creacion).format('DD MMMM YYYY, HH:mm');

          // Capitalizar la primera letra del mes
          fecha_creacion = capitalizeFirstLetter(fecha_creacion);

          return `
                  <div class="row">
                    <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                      <div class="card-info">
                          <small class="mb-0">${fecha_creacion}</small><br>
                      </div>
                    </div>
                  </div>`;
        }
      }
    ],
    order: [[1, 'asc']],
    displayLength: 30,
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"row"<"col-sm-12"B>><""t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [
      [30, 50, 75, 100, 150, 200, -1],
      [30, 50, 75, 100, 150, 200, 'Todos']
    ],
    language: {
      paginate: {
        // remove previous & next text from pagination
        previous: 'Anterior',
        next: 'Siguiente'
      }
    }
  });
}
