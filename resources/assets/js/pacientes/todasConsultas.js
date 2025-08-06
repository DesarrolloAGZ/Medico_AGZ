moment.locale('es');

// Función para capitalizar la primera letra de una cadena
function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
}

$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  generarTabla();

  $('[data-bs-toggle="tooltip"]').tooltip();
});

$('#boton-recargar-tabla-consultas').on('click', function () {
  generarTabla();
  alertify.success('Tabla recargada correctamente.');
});

$('#boton-borrar-filtros-consultas').on('click', function () {
  // Borra los valores de los filtros
  $('#filtro-consulta-fecha_inicio').val('');
  $('#filtro-consulta-fecha_fin').val('');
  $('#filtro-consulta-empleado_nombre').val('');
  $('#filtro-consulta-numero_empleado').val('');
  $('#filtro-consulta-tipo_visita').val('');

  // Vuelve a generar la tabla
  generarTabla();

  // Muestra alerta de que se borraron filtros
  alertify.success('Filtros borrados correctamente.');
});

function generarTabla() {
  // Obtener valores de los filtros
  const filtros = {
    fecha_inicio: $('#filtro-consulta-fecha_inicio').val(),
    fecha_fin: $('#filtro-consulta-fecha_fin').val(),
    numero_empleado: $('#filtro-consulta-numero_empleado').val(),
    empleado_nombre: $('#filtro-consulta-empleado_nombre').val(),
    tipo_visita: $('#filtro-consulta-tipo_visita').val()
  };

  // Verificar si la tabla ya existe y destruirla para evitar el error de reinitialise
  if ($.fn.DataTable.isDataTable('.datatables-basic-filas')) {
    $('.datatables-basic-filas').DataTable().clear().destroy();
  }

  let table = $('.datatables-basic-filas').DataTable({
    buttons: [
      {
        extend: 'excel',
        text: '<i class="fas fa-file-excel"></i>',
        title: 'Listado de consultas',
        filename: 'consultas_' + new Date().toISOString().slice(0, 10), // Nombre del archivo con fecha
        exportOptions: {
          modifier: {
            page: 'all'
          },
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        },
        footer: true
      },
      {
        extend: 'print',
        text: '<i class="fas fa-print"></i>',
        title: 'Listado de consultas',
        exportOptions: {
          modifier: {
            page: 'all'
          },
          columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        },
        customize: function (win) {
          $(win.document.body).css('font-size', '12pt');
        }
      }
    ],
    processing: true,
    serverSide: true,
    ajax: {
      url: '/pacientes/api/obtener-lista-todas-consultas',
      type: 'POST',
      data: function (d) {
        // Combinar los parámetros de DataTables con nuestros filtros
        return $.extend({}, d, {
          fecha_inicio: filtros.fecha_inicio,
          fecha_fin: filtros.fecha_fin,
          numero_empleado: filtros.numero_empleado,
          empleado_nombre: filtros.empleado_nombre,
          tipo_visita: filtros.tipo_visita
        });
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
      { data: 'consulta_id' },
      { data: 'paciente_gafete' },
      { data: 'paciente_nombre' },
      { data: 'paciente_edad' },
      { data: 'tipo_visita' },
      { data: 'motivo_consulta' },
      { data: 'consulta_observaciones' },
      { data: 'consulta_medicamento' },
      { data: 'paciente_empresa' },
      { data: 'paciente_unidad_negocio' },
      { data: 'paciente_area' },
      { data: 'paciente_subarea' },
      { data: 'fecha_consulta' },
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
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <h6 class="mb-0">${full.paciente_gafete != null ? full.paciente_gafete : ''}</h6>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 2,
        className: 'text-center',
        title: 'Nombre paciente',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.paciente_nombre != null ? full.paciente_nombre : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 3,
        className: 'text-center',
        title: 'Edad',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.paciente_edad != null ? full.paciente_edad : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 4,
        className: 'text-center',
        title: 'Tipo de visita',
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.tipo_visita != null ? full.tipo_visita : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 5,
        className: 'text-center',
        title: 'Motivo de consulta',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.motivo_consulta != null ? full.motivo_consulta : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 6,
        className: 'text-center',
        title: 'Observaciones',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                            <small class="mb-0">${
                              full.consulta_observaciones != null ? full.consulta_observaciones : ''
                            }</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 7,
        className: 'text-center',
        title: 'Medicamento',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                            <small class="mb-0">${
                              full.consulta_medicamento != null ? full.consulta_medicamento : ''
                            }</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 8,
        className: 'text-center',
        title: 'Empresa',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                            <small class="mb-0">${full.paciente_empresa != null ? full.paciente_empresa : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 9,
        className: 'text-center',
        title: 'Unidad de negocio',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${
                                full.paciente_unidad_negocio != null ? full.paciente_unidad_negocio : ''
                              }</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 10,
        className: 'text-center',
        title: 'Area',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.paciente_area != null ? full.paciente_area : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 11,
        className: 'text-center',
        title: 'Subarea',
        orderable: false,
        render: function (data, type, full, meta) {
          return `
                  <div class="row">
                      <div class="d-flex gap-2 align-items-center col-12">
                          <div class="card-info ">
                              <small class="mb-0">${full.paciente_subarea != null ? full.paciente_subarea : ''}</small>
                          </div>
                      </div>
                  </div>`;
        }
      },
      {
        targets: 12,
        className: 'text-center',
        title: 'Fecha consulta',
        orderable: false,
        render: function (data, type, full, meta) {
          // Formatear la fecha usando moment.js en español
          let fecha_creacion = moment(full.fecha_consulta).format('DD MMMM YYYY, HH:mm');

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
    order: [[2, 'asc']],
    displayLength: 30,
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"B>><"row"<"col-sm-12"t>><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
    lengthMenu: [
        [30, 50, 75, 100, 150, 200, -1],
        [30, 50, 75, 100, 150, 200, "Todos"]
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
