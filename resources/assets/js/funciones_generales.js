// Funcion de pantalla de carga
function pantallaCarga(accion) {
  if (accion == 'on') {
    $('#pantallaDeCarga').css('display', 'grid');
  } else {
    $('#pantallaDeCarga').css('display', 'none');
  }
}

function obtenerEdadDesdeCURP(curp) {
  if (!curp || curp.length < 10) return null;
  // Extraer fecha del CURP
  const anio = curp.substring(4, 6);
  const mes = curp.substring(6, 8);
  const dia = curp.substring(8, 10);
  // Determinar siglo (CURP mayores al 2000 comienzan con 0–2)
  const anioNum = parseInt(anio);
  const siglo = anioNum <= 24 ? 2000 : 1900; // Ajusta si lo necesitas
  const fechaNacimiento = new Date(siglo + anioNum, mes - 1, dia);
  // Calcular edad
  const hoy = new Date();
  let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
  const mesDiferencia = hoy.getMonth() - fechaNacimiento.getMonth();
  // Ajustar si aún no cumple años este año
  if (mesDiferencia < 0 || (mesDiferencia === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
    edad--;
  }
  return edad;
}

// Funcion para mostrar el grafico de total de consultas por ultimos 8 dias
function verGraficoConsultasPorDia(datos_vista) {
  // Configuración de colores
  const borderColor = '#828393';
  const labelColor = '#828393';
  const config = { colors: { info: '#006c39' } };

  // Procesa datos para el gráfico
  const categories = datos_vista.map(item => item.dia);
  const seriesData = datos_vista.map(item => parseInt(item.cantidad_consultas));

  // Calcula máximo y mínimo
  const maxDataValue = Math.max(...seriesData);
  const minDataValue = Math.min(...seriesData);

  // Ajusta el máximo para que sea un número entero redondeado
  const maxX = Math.ceil(maxDataValue * 1.1);
  const minX = Math.max(0, Math.floor(minDataValue * 0.9));

  // Inicialización del gráfico
  document.addEventListener('DOMContentLoaded', function () {
    const horizontalBarChartEl = document.querySelector('#horizontalBarChart');

    const horizontalBarChartConfig = {
      chart: {
        height: 343,
        fontFamily: 'Inter',
        type: 'bar',
        toolbar: {
          show: false
        }
      },
      plotOptions: {
        bar: {
          horizontal: true,
          barHeight: '30%',
          borderRadius: 8,
          borderRadiusApplication: 'end',
          borderRadiusWhenStacked: 'last'
        }
      },
      grid: {
        borderColor: borderColor,
        xaxis: {
          lines: {
            show: false
          }
        },
        padding: {
          top: -20,
          bottom: -12
        }
      },
      colors: [config.colors.info],
      dataLabels: {
        enabled: false,
        formatter: function (val) {
          return Math.round(val);
        }
      },
      series: [
        {
          name: 'Consultas',
          data: seriesData
        }
      ],
      xaxis: {
        min: minX,
        max: maxX,
        tickAmount: 4,
        categories: categories,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          },
          formatter: function (val) {
            return Math.round(val); // Asegurar números en eje X
          }
        }
      },
      yaxis: {
        labels: {
          style: {
            colors: labelColor,
            fontSize: '11px'
          }
        }
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return Math.round(val) + (val === 1 ? ' consulta' : ' consultas'); // tooltip
          }
        }
      }
    };
    if (horizontalBarChartEl) {
      const horizontalBarChart = new ApexCharts(horizontalBarChartEl, horizontalBarChartConfig);
      horizontalBarChart.render();
    }
  });
}

// Funcion que valida input para ingresar un número de empleado (#Ejemplo -> 12345678)
function formateaCampoNumeroEmpleado(nameInput) {
  var empleadoInput = document.querySelector(nameInput);
  empleadoInput.addEventListener('input', function () {
    let valor = this.value;
    // Elimina todo lo que no sea número
    valor = valor.replace(/[^0-9]/g, '');
    // Elimina espacios (por si el usuario los pega)
    valor = valor.replace(/\s+/g, '');
    // Limita a un máximo de 8 dígitos
    if (valor.length > 8) {
      valor = valor.slice(0, 8);
    }
    this.value = valor;
  });
}

// Funcion que valida input para ingresar la altura de un paciente (#Ejemplo -> 1.75)
function formateaCampoAltura(nameInput) {
  var inputAltura = document.querySelector(nameInput);
  inputAltura.addEventListener('input', function () {
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
}

// Funcion que valida input para ingresar la temperatura de un paciente (#Ejemplo -> 36.8)
function formateaCampoTemperatura(nameInput) {
  var temperaturaInput = document.querySelector(nameInput);
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
}

// Funcion que valida input para ingresar el peso de un paciente (#Ejemplo -> 70.5)
function formateaCampoPeso(nameInput) {
  var pesoInput = document.querySelector(nameInput);
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
}

// Funcion que valida input para ingresar la frecuencia cardiaca de un paciente (#Ejemplo -> 80.5)
function formateaCampoFrecuenciaCardiaca(nameInput) {
  var frecuenciaCardiacaInput = document.querySelector(nameInput);
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
}

// Funcion que valida input para ingresar la frecuencia respiratoria de un paciente (#Ejemplo -> 22.5)
function formateaCampoFrecuenciaRespiratoria(nameInput) {
  var frecuenciaRespiratoriaInput = document.querySelector(nameInput);
  frecuenciaRespiratoriaInput.addEventListener('input', function () {
    let valor = this.value;
    valor = valor.replace(/[^0-9.]/g, ''); // Permite solo números y un punto decimal
    // Evita que el usuario inicie con un punto
    if (valor.startsWith('.')) {
      valor = '0' + valor;
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
    // Limita el valor máximo a 60 y el mínimo a 0
    if (parseFloat(valor) > 60) {
      valor = '60';
    } else if (parseFloat(valor) < 0) {
      valor = '0';
    }
    // Limita los dígitos antes del punto a dos
    if (valor.indexOf('.') === -1 && valor.length > 2) {
      valor = valor.slice(0, 2); // Máximo dos dígitos (99)
    }
    this.value = valor;
  });
}

// Funcion que valida input para ingresar la oxigenacion de un paciente (#Ejemplo -> 99.8)
function formateaCampoOxigenacion(nameInput) {
  var oxigenacionInput = document.querySelector(nameInput);
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
}

// Funcion que valida input para ingresar la oxigenacion de un paciente (#Ejemplo -> 120/80)
function formateaCampoPresionArterial(nameInput) {
  var presionArterialInput = document.querySelector(nameInput);
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
}

// Funcion que valida input para ingresar la oxigenacion de un paciente (#Ejemplo -> DSBK881012HGTNNS98)
function formateaCampoCURP(nameInput) {
  var curpInput = document.querySelector(nameInput);
  curpInput.addEventListener('input', function () {
    let valor = this.value.toUpperCase(); // Convertir a mayúsculas
    valor = valor.replace(/[^A-Z0-9]/g, ''); // Permite solo letras mayúsculas y números
    // Limitar a 18 caracteres, longitud estándar de CURP
    if (valor.length > 18) {
      valor = valor.slice(0, 18);
    }
    this.value = valor;
  });
}

// Funcion que valida input para ingresar la edad de un paciente (#Ejemplo -> 25)
function formateaCampoEdad(nameInput) {
  var edadInput = document.querySelector(nameInput);
  edadInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite solo números
    valor = valor.replace(/[^0-9]/g, '');
    // Limita a 3 dígitos (edad máxima 120)
    if (valor.length > 3) {
      valor = valor.slice(0, 3);
    }
    // Si el valor tiene 3 dígitos, verifica que no sea mayor a 120
    if (valor.length === 3 && parseInt(valor) > 120) {
      valor = valor.slice(0, 2); // Mantiene solo los primeros 2 dígitos
    }
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar nombre(s) en mayúsculas sin acentos (#Ejemplo -> MARIA JOSE)
function formateaCampoNombre(nameInput) {
  var nombreInput = document.querySelector(nameInput);
  nombreInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite solo letras y espacios
    valor = valor.replace(/[^a-zA-Z\s]/g, '');
    // Limita a 50 caracteres
    if (valor.length > 50) {
      valor = valor.slice(0, 50);
    }
    // Convierte a mayúsculas y elimina acentos
    valor = valor.toUpperCase();
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar apellido en mayúsculas sin acentos (#Ejemplo -> GARCIA)
function formateaCampoApellido(nameInput) {
  var apellidoInput = document.querySelector(nameInput);
  apellidoInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite solo letras
    valor = valor.replace(/[^a-zA-Z]/g, '');
    // Limita a 30 caracteres
    if (valor.length > 30) {
      valor = valor.slice(0, 30);
    }
    // Convierte a mayúsculas
    valor = valor.toUpperCase();
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar estado civil (#Ejemplo -> Soltero, Casado, Viudo)
function formateaCampoEstadoCivil(nameInput) {
  var estadoCivilInput = document.querySelector(nameInput);
  estadoCivilInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite solo letras, espacios y acentos
    valor = valor.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    // Limita a 15 caracteres
    if (valor.length > 20) {
      valor = valor.slice(0, 20);
    }
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar número de hijos (#Ejemplo -> 2)
function formateaCampoHijos(nameInput) {
  var hijosInput = document.querySelector(nameInput);
  hijosInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite solo números
    valor = valor.replace(/[^0-9]/g, '');
    // Limita a 2 dígitos (máximo 30 hijos)
    if (valor.length > 2) {
      valor = valor.slice(0, 2);
    }
    // Si el valor es mayor a 30, lo ajusta a 30
    if (valor.length === 2 && parseInt(valor) > 30) {
      valor = '30';
    }
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar escolaridad (#Ejemplo -> Primaria, Secundaria, Universidad)
function formateaCampoEscolaridad(nameInput) {
  var escolaridadInput = document.querySelector(nameInput);
  escolaridadInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite solo letras, espacios, acentos y algunos caracteres especiales comunes
    valor = valor.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-\(\)]/g, '');
    // Limita a 50 caracteres
    if (valor.length > 50) {
      valor = valor.slice(0, 50);
    }
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar número celular (#Ejemplo -> 4621234567)
function formateaCampoCelular(nameInput) {
  var celularInput = document.querySelector(nameInput);
  celularInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite solo números
    valor = valor.replace(/[^0-9]/g, '');
    // Limita a 10 dígitos, longitud estándar en México
    if (valor.length > 10) {
      valor = valor.slice(0, 10);
    }
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar profesión/oficio (#Ejemplo -> Ingeniero, Doctor, Carpintero)
function formateaCampoProfesion(nameInput) {
  var profesionInput = document.querySelector(nameInput);
  profesionInput.addEventListener('input', function () {
    let valor = this.value;

    // Permite solo letras, espacios, acentos y algunos caracteres especiales
    valor = valor.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-\.]/g, '');

    // Limita a 50 caracteres
    if (valor.length > 50) {
      valor = valor.slice(0, 50);
    }

    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar domicilio (#Ejemplo -> Calle Juárez #123, Colonia Centro)
function formateaCampoDomicilio(nameInput) {
  var domicilioInput = document.querySelector(nameInput);
  domicilioInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite letras, números, espacios, acentos y caracteres comunes de direcciones
    valor = valor.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\#\.\,\-\/]/g, '');
    // Limita a 200 caracteres
    if (valor.length > 200) {
      valor = valor.slice(0, 200);
    }
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Funcion que valida input para ingresar parentesco (#Ejemplo -> Padre, Madre, Hijo, Hermano)
function formateaCampoParentesco(nameInput) {
  var parentescoInput = document.querySelector(nameInput);
  parentescoInput.addEventListener('input', function () {
    let valor = this.value;
    // Permite solo letras, espacios y acentos
    valor = valor.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    // Limita a 20 caracteres
    if (valor.length > 20) {
      valor = valor.slice(0, 20);
    }
    // Asigna el valor formateado al campo de entrada
    this.value = valor;
  });
}

// Función que valida input para ingresar el nivel de glucosa (#Ejemplo -> 85 o 120.5)
function formateaCampoGlucosa(nameInput) {
  var glucosaInput = document.querySelector(nameInput);
  glucosaInput.addEventListener('input', function () {
    let valor = this.value;
    // Elimina todo lo que no sea número o punto decimal
    valor = valor.replace(/[^0-9.]/g, '');
    // Evita que empiece con un punto
    if (valor.startsWith('.')) {
      valor = '0' + valor;
    }
    // Si hay más de un punto decimal, elimina los adicionales
    let partes = valor.split('.');
    if (partes.length > 2) {
      valor = partes[0] + '.' + partes.slice(1).join('');
    }
    // Limita a un solo decimal si ya tiene punto
    if (valor.includes('.')) {
      let [entero, decimal] = valor.split('.');
      decimal = decimal.substring(0, 1); // Solo un decimal permitido
      valor = entero + '.' + decimal;
    }
    // Limita los dígitos enteros a 3 (ejemplo: 0 - 999)
    if (valor.indexOf('.') === -1 && valor.length > 3) {
      valor = valor.slice(0, 3);
    }
    this.value = valor;
  });
}
