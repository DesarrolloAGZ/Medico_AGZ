document.addEventListener('DOMContentLoaded', function () {
  // Codigo para los mensajes de ayuda que estan de un lado de los input
  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });

  // Codigo para detectar los eventos en el input de altura y que ponga la estructura correcta (ejemplo: 1.75)
  const alturaInput = document.querySelector("[name='paciente_datos_consulta[altura]']");
  alturaInput.addEventListener('input', function () {
    let valor = this.value.replace(/[^0-9.]/g, ''); // Permite solo números y punto
    valor = valor.replace(/^0+/, ''); // Elimina ceros a la izquierda
    let partes = valor.split('.'); // Si hay más de un punto decimal, eliminar adicionales
    if (partes.length > 2) {
      valor = partes[0] + '.' + partes.slice(1).join('');
    }
    if (valor.length > 1 && valor.indexOf('.') === -1) {
      valor = valor[0] + '.' + valor.substring(1);
    } // Agrega automáticamente el punto después del primer número si aún no está
    if (valor.includes('.')) {
      // Limita a dos decimales si ya tiene un punto
      let [entero, decimal] = valor.split('.');
      decimal = decimal.substring(0, 2); // Solo deja dos decimales
      valor = entero + (decimal ? '.' + decimal : '');
    }
    this.value = valor;
  });

  // Codigo para detectar los eventos en el input de temperatura y ponga la estructura correcta (ejemplo: 38 o 38.5)
  const temperaturaInput = document.querySelector("[name='paciente_datos_consulta[temperatura]']");
  temperaturaInput.addEventListener('input', function () {
    let valor = this.value.replace(/[^0-9.]/g, ''); // Permite solo números y punto
    valor = valor.replace(/^0+/, ''); // Elimina ceros a la izquierda
    let partes = valor.split('.'); // Si hay más de un punto decimal, elimina los adicionales
    if (partes.length > 2) {
      valor = partes[0] + '.' + partes.slice(1).join('');
    }
    if (valor.length > 2 && valor.indexOf('.') === -1) {
      // Agrega automáticamente el punto después del segundo número si aún no está
      valor = valor.slice(0, 2) + '.' + valor.slice(2);
    }
    if (valor.includes('.')) {
      // Limita a un solo decimal si ya tiene un punto
      let [entero, decimal] = valor.split('.');
      decimal = decimal.substring(0, 1); // Solo deja un decimal
      valor = entero + (decimal ? '.' + decimal : '');
    }
    this.value = valor;
  });

  // Código para detectar los eventos en el input de peso y asegurar que tenga el formato correcto (ejemplo: 70 o 70.5)
  const pesoInput = document.querySelector("[name='paciente_datos_consulta[peso]']");
  pesoInput.addEventListener('input', function () {
    let valor = this.value;
    valor = valor.replace(/[^0-9.]/g, ''); // Permite solo números y un punto
    // Evita que el usuario inicie con un punto
    if (valor.startsWith('.')) {
      valor = '0' + valor; // Agrega un cero al inicio si empieza con un punto
    }
    // Si hay más de un punto decimal, elimina los adicionales
    let partes = valor.split('.');
    if (partes.length > 2) {
      valor = partes[0] + '.' + partes.slice(1).join('');
    }
    // Limita a un solo decimal si ya tiene un punto
    if (valor.includes('.')) {
      let [entero, decimal] = valor.split('.');
      decimal = decimal.substring(0, 1); // Solo un decimal
      valor = entero + '.' + decimal;
    }
    // Limita los dígitos antes del punto a tres
    if (valor.indexOf('.') === -1 && valor.length > 3) {
      valor = valor.slice(0, 3); // Limita a 3 dígitos antes del punto
    }
    this.value = valor;
  });

  // Código para detectar los eventos en el input de frecuencia cardiaca y asegurar que tenga el formato correcto (ejemplo: 80 o 80.5)
  const frecuenciaCardiacaInput = document.querySelector("[name='paciente_datos_consulta[frecuencia_cardiaca]']");
  frecuenciaCardiacaInput.addEventListener('input', function () {
    let valor = this.value;
    valor = valor.replace(/[^0-9.]/g, ''); // Permite solo números y un punto
    // Evita que el usuario inicie con un punto
    if (valor.startsWith('.')) {
      valor = '0' + valor; // Agrega un cero al inicio si empieza con un punto
    }
    // Si hay más de un punto decimal, elimina los adicionales
    let partes = valor.split('.');
    if (partes.length > 2) {
      valor = partes[0] + '.' + partes.slice(1).join('');
    }
    // Limita a un solo decimal si ya tiene un punto
    if (valor.includes('.')) {
      let [entero, decimal] = valor.split('.');
      decimal = decimal.substring(0, 1); // Solo un decimal
      valor = entero + '.' + decimal;
    }
    // Limita los dígitos antes del punto a tres
    if (valor.indexOf('.') === -1 && valor.length > 3) {
      valor = valor.slice(0, 3); // Limita a 3 dígitos antes del punto
    }
    this.value = valor;
  });

  // Código para detectar los eventos en el input de oxigenacion y asegurar que tenga el formato correcto (ejemplo: 80 o 90.5)
  const oxigenacionInput = document.querySelector("[name='paciente_datos_consulta[saturacion_oxigeno]']");
  oxigenacionInput.addEventListener('input', function () {
    let valor = this.value;
    valor = valor.replace(/[^0-9.]/g, ''); // Permite solo números y un punto decimal
    // Evita que el usuario inicie con un punto
    if (valor.startsWith('.')) {
      valor = '0' + valor; // Agrega un cero al inicio si empieza con un punto
    }
    // Si hay más de un punto decimal, elimina los adicionales
    let partes = valor.split('.');
    if (partes.length > 2) {
      valor = partes[0] + '.' + partes.slice(1).join('');
    }
    // Limita a un solo decimal si ya tiene un punto
    if (valor.includes('.')) {
      let [entero, decimal] = valor.split('.');
      decimal = decimal.substring(0, 1); // Solo un decimal
      valor = entero + '.' + decimal;
    }
    // Limita el valor máximo a 100 y el mínimo a 0
    if (parseFloat(valor) > 100) {
      valor = '100';
    } else if (parseFloat(valor) < 0) {
      valor = '0';
    }
    // Asigna el valor al campo de entrada
    this.value = valor;
  });

  // Código para detectar los eventos en el input de presion arterial y asegurar que tenga el formato correcto (ejemplo: 120/50)
  const presionArterialInput = document.querySelector("[name='paciente_datos_consulta[presion_arterial]']");
  presionArterialInput.addEventListener('input', function () {
    let valor = this.value;
    valor = valor.replace(/[^0-9/]/g, ''); // Permite solo números y el separador '/'
    // Evita que el valor comience con '/'
    if (valor.startsWith('/')) {
      valor = valor.substring(1);
    }
    // Si hay más de un '/' en el valor, elimina los adicionales
    let partes = valor.split('/');
    if (partes.length > 2) {
      valor = partes[0] + '/' + partes[1];
    }
    // Limita la longitud de la presión sistólica a tres dígitos y la diastólica a tres dígitos
    if (partes.length === 1) {
      // Solo se ha ingresado la presión sistólica
      if (partes[0].length > 3) {
        valor = partes[0].slice(0, 3);
      }
    } else if (partes.length === 2) {
      // Se han ingresado ambos valores
      if (partes[1].length > 3) {
        valor = partes[0] + '/' + partes[1].slice(0, 2);
      }
    }
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
});

$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');

  $('.select2').select2();

  // Inicializa el formulario de valoracion
  const formValoracionPaciente = document.getElementById('form-registrar_nuevo_paciente');
  const validacionesValoracionPaciente = FormValidation.formValidation(formValoracionPaciente, {
    fields: {
      'paciente_datos_consulta[motivo_consulta]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          stringLength: {
            min: 3,
            message: 'El tamaño minimo es de 3 caracteres'
          },
          regexp: {
            regexp: /^[A-Za-zÑñáéíóúÁÉÍÓÚ0-9\s\$.,()¿?¡!'/_#:;]*$/,
            message: 'Solo se aceptan letras.'
          }
        }
      },
      'paciente_datos_consulta[cie_id]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          }
        }
      },
      'paciente_datos_consulta[temperatura]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^([0-9]{2}(\.[0-9]{1})?|[0-9]{1}(\.[0-9]{1})?)$/,
            message: 'Por favor ingrese una temperatura válida (por ejemplo: 36.5 o 37)'
          }
        }
      },
      'paciente_datos_consulta[peso]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^([0-9]{1,3}(\.[0-9]{1})?)$/, // Permite de 1 a 3 dígitos, con un solo decimal
            message: 'Por favor ingrese un peso válido (por ejemplo: 70 o 70.5)'
          }
        }
      },
      'paciente_datos_consulta[altura]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^(1\.[4-9][0-9]?|2\.0[0-9]?|2\.10)$/,
            message: 'Por favor ingrese una altura válida en formato m.cm'
          }
        }
      },
      'paciente_datos_consulta[frecuencia_cardiaca]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^[1-9]{1}[0-9]{0,2}(\.[0-9]{1})?$/, // Permite números como 72, 85.5, 120, 99.9
            message: 'Por favor ingrese una frecuencia cardíaca válida (por ejemplo: 72 o 85.5)'
          }
        }
      },
      'paciente_datos_consulta[saturacion_oxigeno]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^(100(\.0{1})?|[1-9]{1}[0-9]{0,1}(\.[0-9]{1})?)$/, // Permite números entre 0 y 100, con un decimal opcional
            message: 'Por favor ingrese un valor de saturación de oxígeno válido (por ejemplo: 98 o 98.5)'
          }
        }
      },
      'paciente_datos_consulta[presion_arterial]': {
        validators: {
          notEmpty: {
            message: 'Este campo es obligatorio'
          },
          regexp: {
            regexp: /^(?:1[0-9]{2}|[1-9][0-9])\/(?:1[0-9]{2}|[1-9][0-9])$/,
            message: 'Por favor ingrese una presión arterial válida en formato sistólica/diastólica (ejemplo: 120/80)'
          }
        }
      },
      'paciente_datos_consulta[paciente_tipo_visita_id]': {
        validators: {
          notEmpty: {
            message: 'Debe seleccionar una opción'
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

  async function validateCIEField() {
    const cieId = document.getElementById('cie-id').value;
    if (!cieId) {
      return 'Invalid';
    }
    return 'Valid';
  }

  // Boton para guardar la valoracion del paciente
  $('#boton-guardar_valoracion').click(async function (e) {
    var boton = $(this); // Referencia al botón
    boton.prop('disabled', true); // Deshabilitar el botón para evitar el doble clic

    const camposFormulario = validacionesValoracionPaciente.getFields(); // Variable para obtener los campos del formulario
    let campoInvalidoEncontrado = false; // Inicializamos la variable que cambiara cuando este un campo mal llenado

    const estadoCIE = await validateCIEField();
    if (estadoCIE === 'Invalid') {
      $('#cie-search').focus();
      alertify.error('Escribe y selecciona una opción valida de la lista CIE 10.');
      campoInvalidoEncontrado = true;
    }

    // Iterar sobre cada campo en el formulario del registro del paciente
    for (const nameCampo in camposFormulario) {
      // Solo proceder si no se ha encontrado otro campo inválido
      if (camposFormulario.hasOwnProperty(nameCampo) && !campoInvalidoEncontrado) {
        const estadoCampo = await validacionesValoracionPaciente.validateField(nameCampo);

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
      // Pregunta si se desea guardar la valoracion del paciente
      alertify.confirm(
        '¿Desea guardar la valoración del paciente?',
        function (e, ui) {
          guardarValoracionPaciente();
          boton.prop('disabled', false);
        },
        function (e, ui) {
          alertify.error('Operación cancelada, no guardado');
          boton.prop('disabled', false);
        }
      );
    } else {
      boton.prop('disabled', false);
    }
  });

  // Funcion para guardar el registro de un paciente
  function guardarValoracionPaciente() {
    // Obtenemos el formulario de registro de paciente
    var formData = $('#form-registrar_nuevo_paciente').serialize();

    // CSRF Token al encabezado de la solicitud
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Agregamos manualmente los campos CIE si es necesario
    formData += '&paciente_datos_consulta[cie_descripcion]=' + $('#cie-search').val();
    formData += '&paciente_datos_consulta[cie_id]=' + $('#cie-id').val();

    pantallaCarga('on');

    $.ajax({
      url: '/pacientes/api/guardar-valoracion',
      method: 'POST',
      data: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      success: function (response) {
        if (response.error == false) {
          alertify.success(response.msg);
          setTimeout(function () {
            pantallaCarga('off');
            window.location.href = response.url;
          }, 3000); // Espera 3 segundos (3000 milisegundos)
        } else {
          pantallaCarga('off');
          alertify.error(response.msg);
        }
      },
      error: function () {
        pantallaCarga('off');
        // Si ocurre un error en la solicitud
        console.log('Error en la solicitud');
        alertify.error(
          '¡Lo sentimos! No fue posible guardar el registro. Inténtalo de nuevo y si el problema persiste contacta con el equipo de desarrollo.'
        );
      }
    });
  }
});

// Funcion para calcular automaticamente el IMC y ponerlo en el campo de IMC
function calculaIMC() {
  var peso = $('#paciente_datos_consulta-peso').val();
  var altura = $('#paciente_datos_consulta-altura').val();
  var imc = 0;

  if (peso > 0 && altura > 0) {
    imc = peso / (altura * altura);
  }

  $('#paciente_datos_consulta-imc').val(imc.toFixed(2));
}

// Funcion para que pinte los resultados de la busqueda tecleada por el usuario del CIE 10
(function () {
  // Configuración inicial
  const config = {
    minChars: 3,
    debounceTime: 350,
    endpoint: '/pacientes/api/buscar-cie',
    csrfToken: document.querySelector('meta[name="csrf-token"]').content
  };

  // Elementos del DOM
  const elements = {
    searchInput: document.getElementById('cie-search'),
    resultsContainer: document.getElementById('cie-results'),
    hiddenInput: document.getElementById('cie-id')
  };

  // Variable de estado
  let debounceTimer;

  // Inicialización
  function init() {
    if (!elements.searchInput) return;
    setupEventListeners();
    setupStyles();
  }

  // Estilos dinámicos
  function setupStyles() {
    const style = document.createElement('style');
    style.textContent = `
      #cie-results {
        max-height: 300px;
        overflow-y: auto;
        z-index: 1050;
        width: 100%;
        display: none;
        position: absolute;
        background: white;
        border: 1px solid #ddd;
        border-top: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      }
      #cie-results .result-item {
        padding: 8px 12px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
      }
      #cie-results .result-item:hover {
        background-color: #f5f5f5;
      }
      #cie-results .loading, #cie-results .error, #cie-results .no-results {
        padding: 8px 12px;
        color: #666;
        font-style: italic;
      }
      #cie-results .error {
        color: #dc3545;
      }
    `;
    document.head.appendChild(style);
  }

  // Event listeners
  function setupEventListeners() {
    elements.searchInput.addEventListener('input', handleInput);
    elements.resultsContainer.addEventListener('click', handleResultClick);
    document.addEventListener('click', handleOutsideClick);
  }

  // Manejo de la entrada de texto
  function handleInput(e) {
    clearTimeout(debounceTimer);
    const query = e.target.value.trim();

    if (query.length < config.minChars) {
      hideResults();
      return;
    }

    showLoading();
    debounceTimer = setTimeout(() => fetchResults(query), config.debounceTime);
  }

  // Mostrar estado de carga al buscar
  function showLoading() {
    elements.resultsContainer.innerHTML = `
      <div class="loading">
        <i class="fas fa-spinner fa-spin me-2"></i>Buscando...
      </div>
    `;
    showResults();
  }

  // Ocultar resultados
  function hideResults() {
    elements.resultsContainer.style.display = 'none';
  }

  // Mostrar resultados
  function showResults() {
    elements.resultsContainer.style.display = 'block';
  }

  // Buscar resultados en el servidor
  async function fetchResults(query) {
    try {
      const formData = new FormData();
      formData.append('nombre_cie', query);

      const response = await fetch('/pacientes/api/buscar-cie', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': config.csrfToken,
          Accept: 'application/json'
        },
        body: formData
      });

      if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

      const data = await response.json();

      if (data.data.length > 0) {
        renderResults(data.data);
      } else {
        showNoResults();
      }
    } catch (error) {
      console.error('Error en la búsqueda:', error);
      showError('Error al conectar con el servidor. Intente nuevamente.');
    }
  }

  // Mostrar resultados
  function renderResults(results) {
    elements.resultsContainer.innerHTML = results
      .map(
        cie => `
      <div class="result-item" data-id="${cie.id}">
        <strong>${cie.codigo}</strong> - ${cie.descripcion}
      </div>
    `
      )
      .join('');
  }

  // Mostrar error
  function showError(message) {
    elements.resultsContainer.innerHTML = `
      <div class="error">
        <i class="fas fa-exclamation-circle me-2"></i>${message}
      </div>
    `;
  }

  // Mostrar "no hay resultados"
  function showNoResults() {
    elements.resultsContainer.innerHTML = `
      <div class="no-results">
        No se encontraron coincidencias
      </div>
    `;
  }

  // Manejar clic en un resultado
  function handleResultClick(e) {
    const item = e.target.closest('.result-item');
    if (!item) return;

    e.preventDefault();
    const id = item.getAttribute('data-id');
    const text = item.textContent.trim();

    elements.searchInput.value = text;
    elements.hiddenInput.value = id;
    hideResults();

    showSuccess(`CIE-10 seleccionado: ${text}`);
  }

  // Manejar clic fuera del área de búsqueda
  function handleOutsideClick(e) {
    if (!elements.searchInput.contains(e.target) && !elements.resultsContainer.contains(e.target)) {
      hideResults();
    }
  }

  // Mostrar notificación de éxito
  function showSuccess(message) {
    if (typeof alertify !== 'undefined') {
      alertify.success(message);
    } else {
      console.log('Success:', message);
    }
  }

  // Iniciar la función
  init();
})();
