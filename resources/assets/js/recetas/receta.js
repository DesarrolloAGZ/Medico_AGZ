$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  $('.select2').select2();

  // Inicializa las validaciones para imprimir la nota
  const formReceta = document.getElementById('form-receta');
  const validacionesReceta = FormValidation.formValidation(formReceta, {
    fields: {
      'receta[paciente_id]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          }
        }
      },
      'receta[medicamento_indicaciones]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          stringLength: {
            min: 3,
            message: 'El tamaño minimo es de 3 caracteres'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        eleValidClass: '',
        rowSelector: '.row'
      })
    }
  });

  $('#boton-imprimir_receta').click(async function (e) {
    e.preventDefault();
    const camposFormulario = validacionesReceta.getFields(); // Variable para obtener los campos del formulario
    let campoInvalidoEncontrado = false; // Inicializamos la variable que cambiara cuando este un campo mal llenado

    if (arrayMedicamentosReceta.length === 0) {
      alertify.error('Debe agregar al menos un medicamento a la receta antes de guardarla e imprimirla.');
      return;
    }

    // Iterar sobre cada campo en el formulario del registro del paciente
    for (const nameCampo in camposFormulario) {
      // Solo proceder si no se ha encontrado otro campo inválido
      if (camposFormulario.hasOwnProperty(nameCampo) && !campoInvalidoEncontrado) {
        const estadoCampo = await validacionesReceta.validateField(nameCampo);

        if (estadoCampo === 'Invalid') {
          const primerCampoInvalido = $(`[name="${nameCampo}"]`);
          if (primerCampoInvalido.length) {
            primerCampoInvalido.focus();
            campoInvalidoEncontrado = true;
          }
          break;
        }
      }
    }
    // Si no hay campos invalidos entra
    if (!campoInvalidoEncontrado) {
      // Pregunta si se desea guardar el registro del paciente
      alertify.confirm(
        '¿Desea guardar e imprimir la receta?',
        function (e, ui) {
          document.querySelector('.alertify')?.style.setProperty('display', 'none', 'important');
          guardarReceta();
        },
        function (e, ui) {
          // alertify.error('Operación cancelada, no guardado');
        }
      );
    }
  });

  $('#boton-obtener_listado_medicamentos').click(function (e) {
    e.preventDefault();
    // Abrimos el offcanva cuando tenemos respuesta
    var offcanvas = new bootstrap.Offcanvas(document.getElementById('canvasMedicamentos'));
    offcanvas.show();
  });
});

function colocarPacienteEnReceta(elm) {
  const pacienteId = elm.value;
  // Busca el paciente con ese ID
  const paciente = datos_vista.pacientes.find(p => p.id == pacienteId);

  if (paciente) {
    $('#paciente_receta-nombre').text(
      paciente.nombre + ' ' + paciente.apellido_paterno + ' ' + paciente.apellido_materno
    );
    $('#paciente_receta-edad').text(paciente.edad);
  } else {
    // alertify.error('Ocurrio un error, intenta de nuevo. Si el problema continua contacta con el equipo de desarrollo');
  }
}

function guardarReceta() {
  // Obtenemos el formulario de registro de paciente
  var formElement = document.getElementById('form-receta');
  var formData = new FormData(formElement);
  // Agregamos el array de medicamentos al formData
  formData.append('medicamentos', JSON.stringify(arrayMedicamentosReceta));
  // CSRF Token al encabezado de la solicitud
  var csrfToken = $('meta[name="csrf-token"]').attr('content');

  pantallaCarga('on');

  $.ajax({
    url: '/receta/api/registrar-receta',
    method: 'POST',
    data: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    processData: false,
    contentType: false,
    success: function (response) {
      pantallaCarga('off');
      if (response.error == false) {
        window.print();
        $('#receta-paciente_id').val('').trigger('change'); // Limpiamos el campo de paciente
        $('#paciente_receta-nombre').text(''); // Limpiamos el label del paciente en la receta
        $('#paciente_receta-edad').text(''); // Limpiamos el label de la edad del paciente
        $('#receta-medicamento_indicaciones').val(''); // Limpiamos el campo de las indicaciones de la receta
        $('#receta-recomendaciones').val(''); // Limpiamos el campo de las recomendaciones de la receta
        $('#receta-folio').text('#F-' + (response.receta_id + 1)); // Actualizamos el folio al siguiente
        arrayMedicamentosReceta = []; // Limpiamos el array de medicamentos
        document.querySelector('#contenedor-medicamentos .container').innerHTML = ''; // Limpiamos la vista de medicamentos
        alertify.success('Receta guardada correctamente');
      } else {
        alertify.error(response.msg);
      }
    },
    error: function () {
      // Si ocurre un error en la solicitud
      console.log('Error en la solicitud');
      alertify.error(
        '¡Lo sentimos! No fue posible guardar la nota. Inténtalo de nuevo y si el problema persiste contacta con el equipo de desarrollo.'
      );
    }
  });
}

function obtenerCatalogoMedicamentosHispatec() {
  pantallaCarga('on');

  var $select = $('#almacen_medicamentos');
  var almacen_id = $select.val();
  var empresa_id = $select.find('option:selected').data('empresa_id');
  var almacen_codigo = $select.find('option:selected').data('almacen_codigo');

  if (!almacen_id) {
    pantallaCarga('off');
    alertify.error('No existe un almacen id asignado en la opción seleccionada, contacta con el equipo de Desarrollo.');
    return;
  }
  if (!empresa_id) {
    pantallaCarga('off');
    alertify.error(
      'No existe una empresa id asignada en la opción seleccionada, contacta con el equipo de Desarrollo.'
    );
    return;
  }
  if (!almacen_codigo) {
    pantallaCarga('off');
    alertify.error(
      'No existe un almacen codigo asignado en la opción seleccionada, contacta con el equipo de Desarrollo.'
    );
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

// Variable global para almacenar todos los medicamentos
let todosLosMedicamentos = [];

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

function mostrarMedicamentos(medicamentos) {
  const lista = document.getElementById('listado-medicamentos-receta');
  lista.innerHTML = '';

  if (medicamentos.length === 0) {
    lista.innerHTML = '<li class="list-group-item text-center text-muted">No se encontraron medicamentos</li>';
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
                <div class="row g-2 align-items-center">
                  <div class="col-auto">
                    <label class="form-label small mb-0">Cantidad a agregar:</label>
                  </div>
                  <div class="col-auto">
                    <input type="number" class="form-control text-center form-control-sm border-0 border-bottom rounded-0 cantidad-input" style="width: 100px;" value="1" min="0.01" max="${stockMaximo}" step="0.01" data-index="${index}" onchange="validarCantidad(this)" oninput="validarCantidad(this)">
                  </div>
                  <div class="col-auto">
                    <span class="badge bg-light text-dark">${
                      medicamento.Abreviatura || medicamento.unidadmedida || ''
                    }</span>
                  </div>
                </div>
                <small class="text-danger d-none cantidad-error" id="error-${index}">
                  La cantidad no puede ser mayor al stock disponible
                </small>
              </div>
              <div class="ms-2">
                <button type="button" class="btn btn-sm btn-primary" onclick="agregarMedicamentoReceta(${index})" id="btn-agregar-${index}">
                  <i class="mdi mdi-plus"></i> Agregar
                </button>
              </div>
            </div>
        `;

    listItem.setAttribute('data-medicamento', JSON.stringify(medicamento));
    lista.appendChild(listItem);
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

// Función para validar la cantidad
function validarCantidad(input) {
  const index = input.getAttribute('data-index');
  const maxStock = parseFloat(input.getAttribute('max'));
  const cantidad = parseFloat(input.value);
  const errorElement = document.getElementById(`error-${index}`);
  const btnAgregar = document.getElementById(`btn-agregar-${index}`);

  // Validar que sea un número válido
  if (isNaN(cantidad) || cantidad == 0) {
    input.style.borderBottom = '1px solid #7367f0';
    errorElement.classList.add('d-none');
    btnAgregar.disabled = false;
    btnAgregar.classList.remove('btn-secondary');
    btnAgregar.classList.add('btn-primary');
    return;
  }

  if (cantidad > maxStock) {
    input.style.borderBottom = '2px solid #ea5455';
    errorElement.classList.remove('d-none');
    btnAgregar.disabled = true;
    btnAgregar.classList.add('btn-secondary');
    btnAgregar.classList.remove('btn-primary');
  } else {
    input.style.borderBottom = '1px solid #7367f0';
    errorElement.classList.add('d-none');
    btnAgregar.disabled = false;
    btnAgregar.classList.remove('btn-secondary');
    btnAgregar.classList.add('btn-primary');
  }
}

var arrayMedicamentosReceta = [];

// Función para agregar medicamento a la vista principal
function agregarMedicamentoReceta(index) {
  const lista = document.getElementById('listado-medicamentos-receta');
  const listItem = lista.children[index];
  const medicamentoData = JSON.parse(listItem.getAttribute('data-medicamento'));

  // Obtener la cantidad ingresada
  const inputCantidad = listItem.querySelector('.cantidad-input');
  const cantidad = parseFloat(inputCantidad.value) || 1;

  // Validar nuevamente por seguridad
  const stockMaximo = medicamentoData.cantidad || 0;
  if (cantidad > stockMaximo) {
    alertify.error('La cantidad no puede ser mayor al stock disponible');
    return;
  }

  // Agregar a la vista principal
  agregarMedicamentoAVista(medicamentoData, cantidad);

  // Agregar al array de medicamentos de la receta
  arrayMedicamentosReceta.push({
    medicamento_id: medicamentoData.Id,
    medicamento_nombre: medicamentoData.nombre_articulo,
    medicamento_codigo: medicamentoData.Codigo,
    cantidad_solicitada: cantidad,
    empresa_id: medicamentoData.Id_Empresa,
    almacen_id: medicamentoData.Id_Almacen
  });

  // Resetear el input
  inputCantidad.value = 1;
  validarCantidad(inputCantidad);
}

// Función para mostrar en la vista principal (en un solo texto)
function agregarMedicamentoAVista(medicamento, cantidad) {
  const contenedor = document.querySelector('#contenedor-medicamentos .container');

  // Crear el texto del medicamento
  const textoMedicamento = `${medicamento.nombre_articulo} - ${cantidad} ${
    medicamento.Abreviatura || medicamento.unidadmedida || ''
  }`;

  // Usamos el ID del medicamento como parte del ID del div
  const medicamentoId = `med-${medicamento.Id}-${Date.now()}`;

  const medicamentoHTML = `
    <small>
      <div class="alert alert-primary alert-dismissible fade show mb-2" id="${medicamentoId}" data-medicamento-id="${medicamento.Id}" style="display: inline-flex; background-color: transparent; padding: 5px;" role="alert">
        <div class="d-flex justify-content-between align-items-center" style="margin-right: 10px;">
          <span style="margin-right: 11px;">${textoMedicamento}</span>
          <button type="button" style="padding: 9px;" class="btn-close no-imprimir" onclick="removerMedicamento('${medicamentoId}')" aria-label="Close"></button>
        </div>
      </div>
    </small>
  `;

  if (contenedor.innerHTML.trim() === '') {
    contenedor.innerHTML = medicamentoHTML;
  } else {
    contenedor.insertAdjacentHTML('beforeend', medicamentoHTML);
  }
}

// Función para remover medicamento tanto de la vista como del array
function removerMedicamento(id) {
  const elemento = document.getElementById(id);
  if (elemento) {
    // Obtener el ID del medicamento desde el atributo data
    const medicamentoId = elemento.getAttribute('data-medicamento-id');
    // Eliminar de la vista
    elemento.remove();
    // Eliminar del array
    arrayMedicamentosReceta = arrayMedicamentosReceta.filter(item => item.medicamento_id != medicamentoId);
    console.log('Medicamento eliminado:', medicamentoId);
    console.log('Array actualizado:', arrayMedicamentosReceta);
  }
}
