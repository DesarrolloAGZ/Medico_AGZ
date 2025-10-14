// Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
pantallaCarga('off');

// Verificar si estamos en la ruta 'historico-clinico-consultar'
if (window.location.pathname.includes('/historia_clinica/consultar')) {
  deshabilitarCamposFormulario();
}

// Elimina todos los listeners de Bootstrap primero para manejo de los acordiones manualmente
document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(el => {
  el.removeAttribute('data-bs-toggle');
});

// Manejamos el abrir y cerrar los acordeones por bug de acordeones en card
document.querySelectorAll('.accordion-button').forEach(button => {
  button.addEventListener('click', function () {
    const target = document.querySelector(this.getAttribute('data-bs-target'));
    const isExpanded = this.getAttribute('aria-expanded') === 'true';

    if (isExpanded) {
      // Animación de cierre
      target.style.height = `${target.scrollHeight}px`;
      setTimeout(() => {
        target.style.height = '0';
      }, 10);
      setTimeout(() => {
        target.classList.remove('show');
        target.style.height = '';
      }, 350);
    } else {
      // Animación de apertura
      target.classList.add('show');
      target.style.height = '0';
      setTimeout(() => {
        target.style.height = `${target.scrollHeight}px`;
      }, 10);
      setTimeout(() => {
        target.style.height = '';
      }, 350);
    }
    this.classList.toggle('collapsed');
    this.setAttribute('aria-expanded', !isExpanded);
  });
});

// Constante de el wizard utilizado para los formularios
const wizardVertical = document.querySelector('.wizard-vertical'),
  wizardVerticalBtnNextList = [].slice.call(wizardVertical.querySelectorAll('.btn-next')),
  wizardVerticalBtnPrevList = [].slice.call(wizardVertical.querySelectorAll('.btn-prev')),
  wizardVerticalBtnSubmit = wizardVertical.querySelector('.btn-submit');

// Bandera para ejecutar la función solo una vez
let yaEjecutadoAntecedenteLaboral = false;

if (typeof wizardVertical !== undefined && wizardVertical !== null) {
  const verticalStepper = new Stepper(wizardVertical, {
    linear: false
  });
  if (wizardVerticalBtnNextList) {
    wizardVerticalBtnNextList.forEach(wizardVerticalBtnNext => {
      wizardVerticalBtnNext.addEventListener('click', event => {
        verticalStepper.next();
      });
    });
  }
  if (wizardVerticalBtnPrevList) {
    wizardVerticalBtnPrevList.forEach(wizardVerticalBtnPrev => {
      wizardVerticalBtnPrev.addEventListener('click', event => {
        verticalStepper.previous();
      });
    });
  }

  // Hacemos esto para detectar que step estamos viendo en pantalla
  wizardVertical.addEventListener('shown.bs-stepper', function (event) {
    const stepId = event.detail.indexStep;
    const stepElement = wizardVertical.querySelectorAll('.content')[stepId];

    if (stepElement && stepElement.id === 'step-antecendentes_laborales' && !yaEjecutadoAntecedenteLaboral) {
      yaEjecutadoAntecedenteLaboral = true; // Marcar como ejecutado
      pintaCamposAntecedenteLaboral();
      if (window.location.pathname.includes('/historia_clinica/consultar')) {
        deshabilitarCamposFormulario();
      }
    }
  });
}

// Ejecutamos la funcion para que pinte el input dependiendo la seleccion en antidoping
pintaCamposAntidoping();

// Ejecutamos la funcion para colocar o no la seccion de mujer
setTimeout(() => {
  seccionSeleccionGeneroMujer();
}, 1000);

// ### Inputs del STEP - Datos generales (validamos y formateamos a su expresion regular correspondiente)
formateaCampoCURP("[name='historico_clinico[curp]']");
formateaCampoEdad('input[name="historico_clinico[edad]"]');
formateaCampoNombre('input[name="historico_clinico[nombre]"]');
formateaCampoApellido('input[name="historico_clinico[apellido_paterno]"]');
formateaCampoApellido('input[name="historico_clinico[apellido_materno]"]');
formateaCampoEstadoCivil('input[name="historico_clinico[estado_civil]"]');
formateaCampoHijos('input[name="historico_clinico[hijos]"]');
formateaCampoEscolaridad('input[name="historico_clinico[escolaridad]"]');
formateaCampoCelular('input[name="historico_clinico[celular]"]');
formateaCampoProfesion('input[name="historico_clinico[profesion_oficio]"]');
formateaCampoDomicilio('input[name="historico_clinico[domicilio]"]');

// ### Inputs del STEP - Contactos de emergencia (validamos y formateamos a su expresion regular correspondiente)
formateaCampoNombre('input[name="historico_clinico_contacto_emergencia[1][nombre]"]');
formateaCampoParentesco('input[name="historico_clinico_contacto_emergencia[1][parentesco]"]');
formateaCampoCelular('input[name="historico_clinico_contacto_emergencia[1][celular]"]');
formateaCampoNombre('input[name="historico_clinico_contacto_emergencia[2][nombre]"]');
formateaCampoParentesco('input[name="historico_clinico_contacto_emergencia[2][parentesco]"]');
formateaCampoCelular('input[name="historico_clinico_contacto_emergencia[2][celular]"]');

// ### Inputs del STEP - Exploracion fisica (validamos y formateamos a su expresion regular correspondiente)
formateaCampoPeso('input[name="historico_clinico_exploracion_fisica[peso]"]');
formateaCampoAltura('input[name="historico_clinico_exploracion_fisica[talla]"]');
formateaCampoPresionArterial('input[name="historico_clinico_exploracion_fisica[presion_arterial]"]');
formateaCampoFrecuenciaCardiaca('input[name="historico_clinico_exploracion_fisica[frecuencia_cardiaca]"]');
formateaCampoFrecuenciaRespiratoria('input[name="historico_clinico_exploracion_fisica[frecuencia_respiratoria]"]');
formateaCampoTemperatura('input[name="historico_clinico_exploracion_fisica[temperatura]"]');
formateaCampoGlucosa('input[name="historico_clinico_exploracion_fisica[glucosa]"]');

// Inicializa el formulario de historico
const formHistoricoClinico = document.getElementById('form-registra_historico_clinico');
const validacionesHistoricoClinico = FormValidation.formValidation(formHistoricoClinico, {
  fields: {
    'historico_clinico[tipo_registro]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico[curp]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 18,
          max: 18,
          message: 'El campo debe tener exactamente 18 caracteres'
        }
      }
    },
    'historico_clinico[fecha_nacimiento]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico[edad]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico[nombre]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          message: 'El tamaño minimo es de 3 caracteres'
        }
      }
    },
    'historico_clinico[apellido_paterno]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          message: 'El tamaño minimo es de 3 caracteres'
        }
      }
    },
    'historico_clinico[apellido_materno]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          message: 'El tamaño minimo es de 3 caracteres'
        }
      }
    },
    'historico_clinico[genero]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico[estado_civil]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          max: 20,
          message: 'El estado civil debe tener entre 3 y 20 caracteres'
        }
      }
    },
    'historico_clinico[hijos]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        digits: {
          message: 'Solo se permiten números enteros'
        },
        between: {
          min: 0,
          max: 30,
          message: 'El número de hijos debe estar entre 0 y 30'
        }
      }
    },
    'historico_clinico[grupo_sanguineo]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico[escolaridad]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          max: 50,
          message: 'La escolaridad debe tener entre 3 y 50 caracteres'
        }
      }
    },
    'historico_clinico_contacto_emergencia[1][nombre]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          message: 'El tamaño minimo es de 3 caracteres'
        }
      }
    },
    'historico_clinico_contacto_emergencia[1][parentesco]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          max: 20,
          message: 'El tamaño debe tener entre 3 y 20 caracteres'
        }
      }
    },
    'historico_clinico_personales_no_patologicos[alcohol]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          message: 'El tamaño minimo es de 3 caracteres'
        }
      }
    },
    'historico_clinico_personales_no_patologicos[drogas]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          message: 'El tamaño minimo es de 3 caracteres'
        }
      }
    },
    'historico_clinico_personales_no_patologicos[tabaco]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          message: 'El tamaño minimo es de 3 caracteres'
        }
      }
    },
    'historico_clinico_empleo[ultimo_empleo]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        },
        stringLength: {
          min: 3,
          message: 'El tamaño minimo es de 3 caracteres'
        }
      }
    },
    'historico_clinico_exploracion_fisica[peso]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico_exploracion_fisica[talla]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico_exploracion_fisica[presion_arterial]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico_exploracion_fisica[frecuencia_cardiaca]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico_exploracion_fisica[frecuencia_respiratoria]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico_exploracion_fisica[temperatura]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico_exploracion_fisica[craneo]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico_exploracion_fisica[cara]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
        }
      }
    },
    'historico_clinico_drogas[calificacion]': {
      validators: {
        notEmpty: {
          message: 'Este campo es obligatorio'
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

// Boton para validar el formulario y guardar el historico clinico
$('#boton-guardar_historico').click(async function (e) {
  var boton = $(this);
  boton.prop('disabled', true);

  try {
    const camposFormulario = validacionesHistoricoClinico.getFields();
    let campoInvalidoEncontrado = false;
    for (const nameCampo in camposFormulario) {
      if (camposFormulario.hasOwnProperty(nameCampo) && !campoInvalidoEncontrado) {
        const estadoCampo = await validacionesHistoricoClinico.validateField(nameCampo);
        if (estadoCampo === 'Invalid') {
          await manejarCampoInvalido(nameCampo);
          alertify.error('Error. Hay un campo vacío obligatorio o mal llenado.');
          campoInvalidoEncontrado = true;
          break;
        }
      }
    }

    if (!campoInvalidoEncontrado) {
      mostrarConfirmacionGuardado(boton);
    } else {
      boton.prop('disabled', false);
    }
  } catch (error) {
    console.error('Error en validación:', error);
    boton.prop('disabled', false);
  }
});

async function manejarCampoInvalido(nameCampo) {
  const campoElement = $(`[name="${nameCampo}"]`);
  if (!campoElement.length) return;
  const stepId = determinarStepPorCampo(nameCampo);
  if (stepId) {
    await activarStep(stepId);
  }
  setTimeout(() => {
    campoElement.focus();
    campoElement.addClass('is-invalid');
    $('html, body').animate({ scrollTop: campoElement.offset().top - 100 }, 500);
  }, 400);
}

// Funcion para saber el step contenedor en el que se encuentra el campo mal llenado o vacio
function determinarStepPorCampo(nameCampo) {
  const campoElement = $(`[name="${nameCampo}"]`);
  if (!campoElement.length) return null;
  // Buscar directamente el step contenedor
  return campoElement.closest('.content').attr('id');
}

// Funcion para simular el click en el step donde esta el campo mal llenado o vacio
function activarStep(stepId) {
  return new Promise(resolve => {
    const stepElement = $(`.step[data-target="#${stepId}"]`);
    if (stepElement.length) {
      stepElement.find('.step-trigger').trigger('click');
      setTimeout(resolve, 350);
    } else {
      resolve();
    }
  });
}

function mostrarConfirmacionGuardado(boton) {
  alertify.confirm(
    '¿Desea guardar el historico clínico?',
    function (e, ui) {
      guardarRegistroHistorico();
      boton.prop('disabled', false);
    },
    function (e, ui) {
      alertify.error('Operación cancelada, no guardado');

      boton.prop('disabled', false);
    }
  );
}

function guardarRegistroHistorico() {
  // Obtenemos el formulario de registro del historico
  var formData = $('#form-registra_historico_clinico').serialize();
  // CSRF Token al encabezado de la solicitud
  var csrfToken = $('meta[name="csrf-token"]').attr('content');

  pantallaCarga('on');

  $.ajax({
    url: '/historia_clinica/api/registrar-historico',
    method: 'POST',
    data: formData,
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    success: function (response) {
      if (response.error == false) {
        pantallaCarga('off');
        alertify.success(response.msg);
        window.location.href = response.url;
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

function pintaCamposAntecedenteLaboral() {
  const contenedor = $('#contenedor-campos_antecedente_laboral');
  const textDinamico = Date.now();

  if (!datos_vista.historico_clinico) {
    const html = `
        <div class="row card shadow-none bg-label-secondary p-3 mb-3" id="antecedente_${textDinamico}">
          <div class="row mb-3">
            <div class="col-md-5">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control campo_visualizar" id="historico_clinico_laborales-${textDinamico}-empresa" name="historico_clinico_laborales[${textDinamico}][empresa]" placeholder="Ingresa la empresa" />
                <label for="historico_clinico_laborales-${textDinamico}-empresa">Empresa <i class="text-danger">*</i></label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control campo_visualizar" id="historico_clinico_laborales-${textDinamico}-giro" name="historico_clinico_laborales[${textDinamico}][giro]" placeholder="Ingresa el giro de la empresa" />
                <label for="historico_clinico_laborales-${textDinamico}-giro">Giro <i class="text-danger">*</i></label>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control campo_visualizar" id="historico_clinico_laborales-${textDinamico}-antiguedad" name="historico_clinico_laborales[${textDinamico}][antiguedad]" placeholder="Ingresa la antigüedad" />
                <label for="historico_clinico_laborales-${textDinamico}-antiguedad">Antigüedad <i class="text-danger">*</i></label>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <input type="text" class="form-control campo_visualizar" id="historico_clinico_laborales-${textDinamico}-actividad" name="historico_clinico_laborales[${textDinamico}][actividad]" placeholder="Ingresa la actividad" />
                <label for="historico_clinico_laborales-${textDinamico}-actividad">Actividad <i class="text-danger">*</i></label>
              </div>
            </div>
            <div class="col-md-3 text-center">
              <label class="me-2">Accidentes de trabajo</label>
              <label class="switch switch-primary ms-2" style="justify-content: center;">
                <input type="checkbox" id="historico_clinico_laborales-${textDinamico}-accidentes" name="historico_clinico_laborales[${textDinamico}][accidentes]" class="switch-input campo_visualizar" />
                <span class="switch-label" style="display: contents; color: #ff4d49;">No</span>
                <span class="switch-toggle-slider">
                  <span class="switch-on">
                    <i class="icon-base ri ri-check-line"></i>
                  </span>
                  <span class="switch-off">
                    <i class="icon-base ri ri-close-line"></i>
                  </span>
                </span>
                <span class="switch-label" style="color: #28a745;">Si</span>
              </label>
            </div>
            <div class="col-md-3 text-center">
              <label class="me-2">Enfermedad de trabajo</label>
              <label class="switch switch-primary ms-2" style="justify-content: center;">
                <input type="checkbox" id="historico_clinico_laborales-${textDinamico}-enfermedad" name="historico_clinico_laborales[${textDinamico}][enfermedad]" class="switch-input campo_visualizar" />
                <span class="switch-label" style="display: contents; color: #ff4d49;">No</span>
                <span class="switch-toggle-slider">
                  <span class="switch-on">
                    <i class="icon-base ri ri-check-line"></i>
                  </span>
                  <span class="switch-off">
                    <i class="icon-base ri ri-close-line"></i>
                  </span>
                </span>
                <span class="switch-label" style="color: #28a745;">Si</span>
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <small class="fw-medium d-block">Exposiciones nocivas</small>
              <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="checkbox" id="historico_clinico_laborales-${textDinamico}-biologicos" name="historico_clinico_laborales[${textDinamico}][biologicos]" value="1" />
                <label class="form-check-label" for="historico_clinico_laborales-${textDinamico}-biologicos">Biológicos</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="checkbox" id="historico_clinico_laborales-${textDinamico}-quimicos" name="historico_clinico_laborales[${textDinamico}][quimicos]" value="1" />
                <label class="form-check-label" for="historico_clinico_laborales-${textDinamico}-quimicos">Químicos</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="checkbox" id="historico_clinico_laborales-${textDinamico}-fisicos" name="historico_clinico_laborales[${textDinamico}][fisicos]" value="1" />
                <label class="form-check-label" for="historico_clinico_laborales-${textDinamico}-fisicos">Físicos</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input campo_visualizar" type="checkbox" id="historico_clinico_laborales-${textDinamico}-ergonomicos" name="historico_clinico_laborales[${textDinamico}][ergonomicos]" value="1" />
                <label class="form-check-label" for="historico_clinico_laborales-${textDinamico}-ergonomicos">Ergonómicos</label>
              </div>
            </div>
          </div>
          <button type="button" class="btn-close position-absolute top-0 end-0 m-2 campo_visualizar" aria-label="Eliminar" onclick="eliminarAntecedente('${textDinamico}')"></button>
        </div>
      `;

    contenedor.append(html);

    validacionesHistoricoClinico.addField(`historico_clinico_laborales[${textDinamico}][empresa]`, {
      validators: {
        notEmpty: {
          message: 'La empresa es obligatoria'
        }
      }
    });

    validacionesHistoricoClinico.addField(`historico_clinico_laborales[${textDinamico}][giro]`, {
      validators: {
        notEmpty: {
          message: 'El giro es obligatorio'
        }
      }
    });

    validacionesHistoricoClinico.addField(`historico_clinico_laborales[${textDinamico}][antiguedad]`, {
      validators: {
        notEmpty: {
          message: 'La antigüedad es obligatoria'
        }
      }
    });

    validacionesHistoricoClinico.addField(`historico_clinico_laborales[${textDinamico}][actividad]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
  } else {
    $('#btn-pintar_antecedentes_laborales').addClass('d-none');
    if (datos_vista.historico_clinico[0].historico_clinico_laborales.length > 0) {
      for (var x = 0; x < datos_vista.historico_clinico[0].historico_clinico_laborales.length; x++) {
        const html = `
            <div class="row card shadow-none bg-label-secondary p-3 mb-3" id="antecedente_${textDinamico}">
              <div class="row mb-3">
                <div class="col-md-5">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control campo_visualizar" id="historico_clinico_laborales-${textDinamico}-empresa" name="historico_clinico_laborales[${textDinamico}][empresa]" placeholder="Ingresa la empresa"
                    value="${datos_vista.historico_clinico[0].historico_clinico_laborales[x].empresa}" />
                    <label for="historico_clinico_laborales-${textDinamico}-empresa">Empresa <i class="text-danger">*</i></label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control campo_visualizar" id="historico_clinico_laborales-${textDinamico}-giro" name="historico_clinico_laborales[${textDinamico}][giro]" placeholder="Ingresa el giro de la empresa"
                    value="${datos_vista.historico_clinico[0].historico_clinico_laborales[x].giro}" />
                    <label for="historico_clinico_laborales-${textDinamico}-giro">Giro <i class="text-danger">*</i></label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control campo_visualizar" id="historico_clinico_laborales-${textDinamico}-antiguedad" name="historico_clinico_laborales[${textDinamico}][antiguedad]" placeholder="Ingresa la antigüedad"
                    value="${datos_vista.historico_clinico[0].historico_clinico_laborales[x].antiguedad}" />
                    <label for="historico_clinico_laborales-${textDinamico}-antiguedad">Antigüedad <i class="text-danger">*</i></label>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control campo_visualizar" id="historico_clinico_laborales-${textDinamico}-actividad" name="historico_clinico_laborales[${textDinamico}][actividad]" placeholder="Ingresa la actividad"
                    value="${datos_vista.historico_clinico[0].historico_clinico_laborales[x].actividad}" />
                    <label for="historico_clinico_laborales-${textDinamico}-actividad">Actividad <i class="text-danger">*</i></label>
                  </div>
                </div>
                <div class="col-md-3 text-center">
                  <label class="me-2">Accidentes de trabajo</label>
                  <label class="switch switch-primary ms-2" style="justify-content: center;">
                    <input type="checkbox" id="historico_clinico_laborales-${textDinamico}-accidentes" name="historico_clinico_laborales[${textDinamico}][accidentes]" class="switch-input campo_visualizar"
                    ${
                      datos_vista.historico_clinico[0].historico_clinico_laborales[x].accidentes == 1 ? 'checked' : ''
                    } />
                    <span class="switch-label" style="display: contents; color: #ff4d49;">No</span>
                    <span class="switch-toggle-slider">
                      <span class="switch-on">
                        <i class="icon-base ri ri-check-line"></i>
                      </span>
                      <span class="switch-off">
                        <i class="icon-base ri ri-close-line"></i>
                      </span>
                    </span>
                    <span class="switch-label" style="color: #28a745;">Si</span>
                  </label>
                </div>
                <div class="col-md-3 text-center">
                  <label class="me-2">Enfermedad de trabajo</label>
                  <label class="switch switch-primary ms-2" style="justify-content: center;">
                    <input type="checkbox" id="historico_clinico_laborales-${textDinamico}-enfermedad" name="historico_clinico_laborales[${textDinamico}][enfermedad]" class="switch-input campo_visualizar"
                    ${
                      datos_vista.historico_clinico[0].historico_clinico_laborales[x].enfermedad == 1 ? 'checked' : ''
                    } />
                    <span class="switch-label" style="display: contents; color: #ff4d49;">No</span>
                    <span class="switch-toggle-slider">
                      <span class="switch-on">
                        <i class="icon-base ri ri-check-line"></i>
                      </span>
                      <span class="switch-off">
                        <i class="icon-base ri ri-close-line"></i>
                      </span>
                    </span>
                    <span class="switch-label" style="color: #28a745;">Si</span>
                  </label>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <small class="fw-medium d-block">Exposiciones nocivas</small>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input campo_visualizar" type="checkbox" id="historico_clinico_laborales-${textDinamico}-biologicos" name="historico_clinico_laborales[${textDinamico}][biologicos]" value="1"
                    ${
                      datos_vista.historico_clinico[0].historico_clinico_laborales[x].biologicos == 1 ? 'checked' : ''
                    } />
                    <label class="form-check-label" for="historico_clinico_laborales-${textDinamico}-biologicos">Biológicos</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input campo_visualizar" type="checkbox" id="historico_clinico_laborales-${textDinamico}-quimicos" name="historico_clinico_laborales[${textDinamico}][quimicos]" value="1"
                    ${datos_vista.historico_clinico[0].historico_clinico_laborales[x].quimicos == 1 ? 'checked' : ''} />
                    <label class="form-check-label" for="historico_clinico_laborales-${textDinamico}-quimicos">Químicos</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input campo_visualizar" type="checkbox" id="historico_clinico_laborales-${textDinamico}-fisicos" name="historico_clinico_laborales[${textDinamico}][fisicos]" value="1"
                    ${datos_vista.historico_clinico[0].historico_clinico_laborales[x].fisicos == 1 ? 'checked' : ''} />
                    <label class="form-check-label" for="historico_clinico_laborales-${textDinamico}-fisicos">Físicos</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input campo_visualizar" type="checkbox" id="historico_clinico_laborales-${textDinamico}-ergonomicos" name="historico_clinico_laborales[${textDinamico}][ergonomicos]" value="1"
                    ${
                      datos_vista.historico_clinico[0].historico_clinico_laborales[x].ergonomicos == 1 ? 'checked' : ''
                    } />
                    <label class="form-check-label" for="historico_clinico_laborales-${textDinamico}-ergonomicos">Ergonómicos</label>
                  </div>
                </div>
              </div>
              <button type="button" class="btn-close position-absolute top-0 end-0 m-2 campo_visualizar" aria-label="Eliminar" onclick="eliminarAntecedente('${textDinamico}')"></button>
            </div>
          `;

        contenedor.append(html);
      }
    }
  }
}

function eliminarAntecedente(id) {
  $(`#antecedente_${id}`).remove();
  removeValidationField(`historico_clinico_laborales[${id}][empresa]`);
  removeValidationField(`historico_clinico_laborales[${id}][giro]`);
  removeValidationField(`historico_clinico_laborales[${id}][antiguedad]`);
  removeValidationField(`historico_clinico_laborales[${id}][actividad]`);
}

function deshabilitarCamposFormulario() {
  const campos = document.querySelectorAll('.campo_visualizar');
  campos.forEach(campo => {
    campo.setAttribute('disabled', true);
  });
}

function pintaCamposAntidoping() {
  var switchAntidoping = $('#historico_clinico_drogas-antidoping').prop('checked');
  var inputTipoDeDroga = $('#historico_clinico_drogas-tipo_droga');

  if (switchAntidoping) {
    inputTipoDeDroga.css('background', '#ffdfdf55');
  } else {
    inputTipoDeDroga.css('background', '#d6ffc755');
  }
}

function seccionSeleccionGeneroMujer() {
  $('#antecedente_gineObstetricos').css('display', 'none');
  var inputGenero = $('#historico_clinico-genero').val();
  if (inputGenero == 'F') {
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[menarca]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[fur]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[ritmo]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[ivsa]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[gesta]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[partos]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[doc]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[cesareas]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[abortos]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    validacionesHistoricoClinico.addField(`historico_clinico_gineco_obstetricos[anticonceptivo]`, {
      validators: {
        notEmpty: {
          message: 'La actividad es obligatoria'
        }
      }
    });
    $('#antecedente_gineObstetricos').css('display', 'block');
  } else {
    removeValidationField(`historico_clinico_gineco_obstetricos[menarca]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[fur]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[ritmo]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[ivsa]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[gesta]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[partos]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[doc]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[cesareas]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[abortos]`);
    removeValidationField(`historico_clinico_gineco_obstetricos[anticonceptivo]`);
    $('#antecedente_gineObstetricos').css('display', 'none');
  }
}

function removeValidationField(fieldName) {
  if (
    typeof validacionesHistoricoClinico !== 'undefined' &&
    validacionesHistoricoClinico &&
    typeof validacionesHistoricoClinico.fields !== 'undefined' &&
    validacionesHistoricoClinico.fields.hasOwnProperty(fieldName)
  ) {
    validacionesHistoricoClinico.removeField(fieldName);
  }
}
