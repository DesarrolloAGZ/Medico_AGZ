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

$('#boton-recargar-tabla-historicos').on('click', function () {
  generarTabla();
});

function generarTabla() {
  // Verificar si la tabla ya existe y destruirla para evitar el error de reinitialise
  if ($.fn.DataTable.isDataTable('.datatables-basic-filas')) {
    $('.datatables-basic-filas').DataTable().clear().destroy();
  }

  let table = $('.datatables-basic-filas').DataTable({
    buttons: [],
    processing: true,
    serverSide: true,
    ajax: {
      url: '/historia_clinica/api/obtener-lista-historicos-clinicos',
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
      { data: 'tipo_registro' },
      { data: 'curp' },
      { data: 'nombre_completo' },
      { data: 'genero' },
      { data: 'edad' },
      { data: 'antidoping' },
      { data: 'calificacion' },
      { data: 'idx' },
      { data: 'created_at' },
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
        title: 'Tipo de histórico',
        orderable: false,
        className: 'text-center',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <h6 class="mb-0">${full.tipo_registro != null ? full.tipo_registro : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 2,
        className: 'text-center',
        orderable: false,
        title: 'CURP',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                            <h6 class="mb-0">${full.curp != null ? full.curp : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 3,
        className: 'text-center',
        title: 'Nombre',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                            <h6 class="mb-0">${full.nombre_completo != null ? full.nombre_completo : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 4,
        className: 'text-center',
        title: 'Genero',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                            <h6 class="mb-0">${
                              full.genero != null ? (full.genero == 'F' ? 'Mujer' : 'Hombre') : ''
                            }</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 5,
        className: 'text-center',
        title: 'Edad',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                            <h6 class="mb-0">${full.edad != null ? full.edad + ' años' : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 6,
        className: 'text-center',
        title: 'Antidoping',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                            <h6 class="mb-0" style="color: ${
                              full.antidoping != null ? (full.antidoping == 1 ? '#f43232' : '#006c39') : ''
                            }">${full.antidoping != null ? (full.antidoping == 1 ? 'Positivo' : 'Negativo') : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 7,
        className: 'text-center',
        title: 'Calificación',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12" style="justify-content: center;">
                          <div class="card-info ">
                            <h6 class="mb-0">${full.calificacion != null ? full.calificacion : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        },
        createdCell: function (td, cellData, rowData, row, col) {
          var color = '';

          if (rowData.calificacion === 'Apto') {
            color = '#D6FFC7';
          } else if (rowData.calificacion === 'No apto') {
            color = '#FFD6C7';
          } else if (rowData.calificacion === 'Apto con condicionante') {
            color = '#FFE9C7';
          }

          $(td).css('background-color', color);
        }
      },
      {
        targets: 8,
        className: 'text-center',
        title: 'IDX',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row" style="max-height: 200px;overflow: auto;width: 200px;">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                            <h6 class="mb-0">${full.idx != null ? full.idx : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 9,
        className: 'text-center',
        title: 'Fecha creación',
        orderable: false,
        render: function (data, type, full, meta) {
          // Formatear la fecha usando moment.js en español
          let fecha_creacion = moment(full.fecha_creacion).format('DD MMMM YYYY, HH:mm');

          // Capitalizar la primera letra del mes
          fecha_creacion = capitalizeFirstLetter(fecha_creacion);

          return `
                  <div class="row">
                    <div class="d-flex gap-2 align-items-center col-12">
                      <div class="card-info">
                          <h6 class="mb-0">${fecha_creacion}</h6><br>
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
