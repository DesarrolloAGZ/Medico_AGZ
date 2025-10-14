moment.locale('es');

$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  generarTabla();
});

$('#boton-recargar-tabla-pacientes').on('click', function () {
  generarTabla();
});

function generarTabla() {
  // Verificar si la tabla ya existe y destruirla para evitar el error de reinitialise
  if ($.fn.DataTable.isDataTable('.datatables-basic-filas')) {
    $('.datatables-basic-filas').DataTable().clear().destroy();
  }

  let table = $('.datatables-basic-filas').DataTable({
    buttons: [
      {
        extend: 'excel',
        text: '<i class="fas fa-file-excel"></i>',
        title: 'Listado de Expedientes',
        filename: 'pacientes_' + new Date().toISOString().slice(0, 10), // Nombre del archivo con fecha
        exportOptions: {
          modifier: {
            page: 'all'
          },
          columns: [1, 2, 3, 4, 5, 6]
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
          columns: [1, 2, 3, 4, 5, 6]
        },
        customize: function (win) {
          $(win.document.body).css('font-size', '12pt');
        }
      }
    ],
    processing: true,
    serverSide: true,
    ajax: {
      url: '/pacientes/api/obtener-lista-pacientes',
      type: 'POST',
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
      { data: 'id' },
      { data: 'gafete' },
      { data: 'nombre' },
      { data: 'edad' },
      { data: 'curp' },
      { data: 'celular' },
      { data: 'consultas' },
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
        title: 'Gafete',
        className: 'text-center',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                              <h6 class="mb-0">${full.gafete != null ? full.gafete : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 2,
        className: 'text-center',
        title: 'Nombre del paciente',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <h6 class="mb-0">${
                                full.nombre != null
                                  ? full.nombre + ' ' + full.apellido_paterno + ' ' + full.apellido_materno
                                  : ''
                              }</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 3,
        className: 'text-center',
        title: 'Edad',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                              <small class="mb-0">${full.edad}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 4,
        className: 'text-center',
        title: 'CURP',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                              <small class="mb-0">${full.curp}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 5,
        className: 'text-center',
        title: 'Telefono celular',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                              <small class="mb-0">${full.celular}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 6,
        className: 'text-center',
        title: 'Número de consultas',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info" >
                              <small class="mb-0" style="background: #dcf7c9;padding: 10px;border-radius: 100%;">${full.consultas_count}</small>
                          </div>
                      </div>
                  </div>`;
        }
      }
    ],
    order: [[1, 'asc']],
    displayLength: 30,
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"row"<"col-sm-12"B>><""t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [30, 50, 75, 100, 150, 200],
    language: {
      paginate: {
        // remove previous & next text from pagination
        previous: 'Anterior',
        next: 'Siguiente'
      }
    }
  });
}
