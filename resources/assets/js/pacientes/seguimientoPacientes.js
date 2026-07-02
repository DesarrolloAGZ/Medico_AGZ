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

  formateaCampoNumeroEmpleado("[name='filtro-expediente[numero_empleado]']");
  formateaCampoCURP("[name='filtro-expediente[curp]']");
  formateaCampoNombre("[name='filtro-expediente[empleado_nombre]']");
});

// ###################################################################################################
// ###################################################################################################
// ############################################## - FUNCIONES
// ###################################################################################################
// ###################################################################################################
function generarTabla() {
  // Obtener valores de los filtros
  const filtros = {
    nombre_empleado: $('#filtro-expediente-empleado_nombre').val(),
    curp: $('#filtro-expediente-curp').val(),
    numero_empleado: $('#filtro-expediente-numero_empleado').val()
  };

  // Verificar si la tabla ya existe y destruirla para evitar el error de reinitialise
  if ($.fn.DataTable.isDataTable('.datatables-basic-filas')) {
    $('.datatables-basic-filas').DataTable().clear().destroy();
  }

  let table = $('.datatables-basic-filas').DataTable({
    buttons: [],
    rocessing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    ajax: {
      url: '/pacientes/api/obtener-lista-pacientes',
      type: 'POST',
      data: function (d) {
        d.nombre_empleado = filtros.nombre_empleado;
        d.curp = filtros.curp;
        d.numero_empleado = filtros.numero_empleado;
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
      { data: 'gafete' },
      { data: 'nombre' },
      { data: 'edad' },
      { data: 'curp' },
      { data: 'celular' },
      { data: 'consultas' },
      { data: 'acciones' }
    ],
    columnDefs: [
      /* Acciones a realizar para cada fila */
      {
        targets: 0,
        title: 'Gafete',
        className: 'text-center',
        render: function (data, type, full, meta) {
          return `<small>${full.gafete != null ? full.gafete : ''}</small>`;
        }
      },
      {
        targets: 1,
        className: 'text-center',
        title: 'Nombre del paciente',
        render: function (data, type, full, meta) {
          return `<small><b>${
            full.nombre != null ? full.nombre + ' ' + full.apellido_paterno + ' ' + full.apellido_materno : ''
          }</b></small>`;
        }
      },
      {
        targets: 2,
        className: 'text-center',
        title: 'Edad',
        render: function (data, type, full, meta) {
          return `<small>${full.edad}</small>`;
        }
      },
      {
        targets: 3,
        className: 'text-center',
        title: 'CURP',
        render: function (data, type, full, meta) {
          return `<small>${full.curp != null ? full.curp : ''}</small>`;
        }
      },
      {
        targets: 4,
        className: 'text-center',
        title: 'Telefono celular',
        render: function (data, type, full, meta) {
          return `<small>${full.celular != null ? full.celular : ''}</small>`;
        }
      },
      {
        targets: 5,
        className: 'text-center',
        title: 'Número de consultas',
        render: function (data, type, full, meta) {
          return `<small class="badge bg-label-primary">${
            full.consultas_count != null ? full.consultas_count : 0
          }</small>`;
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
  $('#filtro-expediente-empleado_nombre').val('');
  $('#filtro-expediente-curp').val('');
  $('#filtro-expediente-numero_empleado').val('');

  // Muestra alerta de que se borraron filtros
  alertify.success('Filtros borrados correctamente.');

  generarTabla();
}

// ###################################################################################################
// ###################################################################################################
// ############################################## - BOTONES
// ###################################################################################################
// ###################################################################################################
