$(document).ready(function () {
  pantallaCarga('off');

  const canvas = document.getElementById('signature-pad');

  function resizeCanvas() {
    const ratio = Math.max(window.devicePixelRatio || 1, 1);

    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;

    canvas.getContext('2d').scale(ratio, ratio);
  }

  resizeCanvas();

  $(window).on('resize', function () {
    resizeCanvas();
  });

  const signaturePad = new SignaturePad(canvas);

  $('#limpiar-firma').click(function (e) {
    e.preventDefault();
    signaturePad.clear();
  });

  $('#guardar-firma').click(function (e) {
    e.preventDefault();

    if (signaturePad.isEmpty()) {
      alertify.error('Debe capturar su firma.');
      return;
    }

    alertify.confirm(
      '¿Desea guardar su firma? Esta será utilizada para firmar automáticamente las recetas médicas.',
      function () {
        guardarFirma(signaturePad);
      },
      function () {
        // Canceló
      }
    );
  });
});
function guardarFirma(signaturePad) {
  pantallaCarga('on');

  const csrfToken = $('meta[name="csrf-token"]').attr('content');

  $.ajax({
    url: '/usuario/api/guardar-firma',
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': csrfToken
    },
    data: {
      firma: signaturePad.toDataURL('image/png')
    },
    success: function (response) {
      if (response.error == false) {
        alertify.success(response.msg);

        setTimeout(function () {
          window.location.href = '/';
        }, 800);
      } else {
        pantallaCarga('off');
        alertify.error(response.msg);
      }
    },

    error: function (xhr) {
      pantallaCarga('off');

      let msg = 'No fue posible guardar la firma. Inténtelo nuevamente.';

      if (xhr.responseJSON && xhr.responseJSON.msg) {
        msg = xhr.responseJSON.msg;
      }

      alertify.error(msg);
    }
  });
}
