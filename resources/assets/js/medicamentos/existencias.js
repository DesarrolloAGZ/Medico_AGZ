// ###################################################################################################
// ###################################################################################################
// ############################################## - VARIABLES
// ###################################################################################################
// ###################################################################################################
let todosLosMedicamentos = [];

// ###################################################################################################
// ###################################################################################################
// ############################################## - FUNCIONES INICIALIZADAS
// ###################################################################################################
// ###################################################################################################
$(document).ready(function () {
  pantallaCarga('off');
});

// ###################################################################################################
// ###################################################################################################
// ############################################## - FUNCIONES
// ###################################################################################################
// ###################################################################################################
function obtenerCatalogoMedicamentosHispatec() {
  pantallaCarga('on');

  var $select = $('#almacen_medicamentos');
  var almacen_id = $select.val();
  var empresa_id = $select.find('option:selected').data('empresa_id');
  var almacen_codigo = $select.find('option:selected').data('almacen_codigo');
  const lista = document.getElementById('listado-medicamentos-receta');
  $('#indicador-scroll').addClass('d-none');

  if (!almacen_id) {
    pantallaCarga('off');
    alertify.error('No se encontraron medicamentos con la opción seleccionada.');
    lista.innerHTML = '';
    return;
  }
  if (!empresa_id) {
    pantallaCarga('off');
    alertify.error('No se encontraron medicamentos con la opción seleccionada.');
    lista.innerHTML = '';
    return;
  }
  if (!almacen_codigo) {
    pantallaCarga('off');
    alertify.error('No se encontraron medicamentos con la opción seleccionada.');
    lista.innerHTML = '';
    return;
  }

  const formData = {
    empresaid: empresa_id,
    almacenid: almacen_id,
    almacencodigo: almacen_codigo
  };
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  $.ajax({
    url: '/receta/api/obtener-catalogo-medicamentos-hispatec',
    method: 'POST',
    data: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    success: function (response) {
      pantallaCarga('off');
      if (response.error == false) {
        $('#filtro-medicamento').val(''); // Limpiar el filtro anterior
        procesarMedicamentos(response.data); // Procesar y mostrar medicamentos
      } else {
        alertify.error(response.msg || 'Error al obtener el catálogo');
      }
    },
    error: function (xhr, status, error) {
      pantallaCarga('off');
      console.log('Error en la solicitud:', error);
      alertify.error(
        '¡Lo sentimos! No fue posible obtener los medicamentos. Inténtalo de nuevo y si el problema persiste contacta con el equipo de desarrollo.'
      );
    }
  });
}

function procesarMedicamentos(medicamentos) {
  todosLosMedicamentos = medicamentos; // Guardar todos los medicamentos en la variable global

  mostrarMedicamentos(medicamentos); // Mostrar todos los medicamentos inicialmente

  configurarFiltroMedicamentos(); // Configurar el filtro

  $('#contenedor-filtros-medicamento').show(); // Mostrar el contenedor de filtros

  setTimeout(() => {
    $('#filtro-medicamento').focus(); // Enfocar el input de búsqueda
  }, 300);
}

function mostrarMedicamentos(medicamentos) {
  const lista = document.getElementById('listado-medicamentos-receta');
  lista.innerHTML = '';

  if (medicamentos.length === 0) {
    lista.innerHTML = '<li class="list-group-item text-center text-muted">No se encontraron medicamentos</li>';
    $('#indicador-scroll').addClass('d-none');
    return;
  }

  medicamentos.forEach(function (medicamento, index) {
    const listItem = document.createElement('li');
    listItem.className = 'list-group-item list-group-timeline-item';

    const stockMaximo = medicamento.cantidad || 0;

    listItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-start">
              <div class="me-3 flex-grow-1">
                <h6 class="mb-1 text-primary">${medicamento.nombre_articulo || 'Sin nombre'}</h6>
                <p class="mb-2 text-muted small">
                  <strong>ID:</strong> ${medicamento.Id || 'N/A'} |
                  <strong>Código:</strong> ${medicamento.Codigo || 'N/A'} |
                  <strong>Stock disponible:</strong> <span class="text-success">${stockMaximo} ${
      medicamento.Abreviatura || medicamento.unidadmedida || ''
    }</span>
                </p>
              </div>
            </div>
        `;

    listItem.setAttribute('data-medicamento', JSON.stringify(medicamento));
    lista.appendChild(listItem);
  });

  $('#indicador-scroll').removeClass('d-none');
}

function configurarFiltroMedicamentos() {
  // Configurar búsqueda en tiempo real al escribir
  $('#filtro-medicamento').on('input', function () {
    filtrarMedicamentos();
  });
}

function filtrarMedicamentos() {
  const filtro = $('#filtro-medicamento').val().toLowerCase().trim();

  if (filtro === '') {
    // Si no hay filtro, mostrar todos los medicamentos
    mostrarMedicamentos(todosLosMedicamentos);
  } else {
    // Filtrar medicamentos
    const medicamentosFiltrados = todosLosMedicamentos.filter(medicamento => {
      const nombre = medicamento.nombre_articulo?.toLowerCase() || '';
      const codigo = medicamento.Codigo?.toLowerCase() || '';

      return nombre.includes(filtro) || codigo.includes(filtro);
    });

    mostrarMedicamentos(medicamentosFiltrados);
  }
}

// ###################################################################################################
// ###################################################################################################
// ############################################## - BOTONES
// ###################################################################################################
// ###################################################################################################
