$(document).ready(function () {
  // Ocultamos la pantalla de carga cuando la pantalla termino de cargar todo el contenido
  pantallaCarga('off');
});

document.addEventListener('DOMContentLoaded', function () {
  const correoInput = document.querySelector("[name='correo']");
  const passwordInput = document.querySelector("[name='password']");
  const btnLogin = document.getElementById('btnLogin'); // El botón a deshabilitar

  // Función para verificar las validaciones
  function checkFormValidity() {
    const correoValor = correoInput.value;
    const passwordValor = passwordInput.value;

    // Validación de correo: debe tener al menos un punto y letras (no puede estar vacío)
    const correoValido = /^[a-zA-Z.]+$/.test(correoValor) && correoValor.indexOf('.') !== -1;

    // Validación de contraseña: debe tener entre 8 y 65 caracteres
    const passwordValida = passwordValor.length >= 8 && passwordValor.length <= 65;

    // Si ambas validaciones son correctas, habilitar el botón; de lo contrario, deshabilitarlo
    if (correoValido && passwordValida) {
      btnLogin.disabled = false; // Habilitar el botón
    } else {
      btnLogin.disabled = true; // Deshabilitar el botón
    }
  }

  // Validación del correo en el input
  correoInput.addEventListener('input', function () {
    // Obtener el valor ingresado
    let valor = this.value;
    // Limpiar caracteres no permitidos, permitiendo solo letras y puntos
    valor = valor.replace(/[^a-zA-Z.]/g, ''); // Solo letras y puntos
    // Asegurarse de que solo haya un punto en la cadena
    const partes = valor.split('.');
    if (partes.length > 2) {
      valor = partes[0] + '.' + partes.slice(1).join(''); // Mantener solo el primer punto y eliminar los demás
    }
    // Asignar el valor limpio al input
    this.value = valor;

    // Verificar el estado de los campos
    checkFormValidity();
  });

  // Validación de la longitud de la contraseña en el input
  passwordInput.addEventListener('input', function () {
    let password = passwordInput.value;

    // Validar longitud de la contraseña entre 8 y 65 caracteres
    if (password.length < 8 || password.length > 65) {
      passwordInput.setCustomValidity('La contraseña debe tener entre 8 y 65 caracteres.');
    } else {
      passwordInput.setCustomValidity('');
    }

    // Verificar el estado de los campos
    checkFormValidity();
  });

  // Inicialmente deshabilitar el botón hasta que los campos sean válidos
  checkFormValidity();
});
