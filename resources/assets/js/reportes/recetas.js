$(document).ready(function () {
  pantallaCarga('off');
  $('.select2').select2();
});

$('#boton-seleccionar_todas_columnas_reporte_recetas').on('click', function () {
  let checkboxes = $('input.form-check-input[type="checkbox"]');
  let todosSeleccionados = checkboxes.length === checkboxes.filter(':checked').length;

  if (todosSeleccionados) {
    // Si todos están seleccionados → deseleccionar
    checkboxes.prop('checked', false);
    $(this).text('Seleccionar todas');
  } else {
    // Si falta alguno → seleccionar todos
    checkboxes.prop('checked', true);
    $(this).text('Deseleccionar todas');
  }
});

// LIMPIAR FILTROS DEL REPORTE
$(document).on('click', '#boton-limpiar_filtros_reporte_recetas', function () {
  $('#filtro-fecha_inicio').val('');
  $('#filtro-fecha_fin').val('');
  $('#filtro-nombre_paciente').val('').trigger('change');
  $('#filtro-medico').val('').trigger('change');
});

$('#boton-generar_reporte_recetas').click(function (e) {
  e.preventDefault();
  pantallaCarga('on');

  let fechaInicio = $('#filtro-fecha_inicio').val();
  let fechaFin = $('#filtro-fecha_fin').val();

  if (!fechaInicio || !fechaFin) {
    pantallaCarga('off');
    alertify.error(
      '<b>Faltan fechas.</b><br>Debes seleccionar la fecha de inicio y la fecha de fin para generar el reporte.'
    );
    return;
  }

  let filtros = {
    fecha_inicio: fechaInicio,
    fecha_fin: fechaFin,
    paciente: $('#filtro-nombre_paciente').val(),
    medico: $('#filtro-medico').val()
  };

  // Obtiene SOLO los checkboxes marcados dentro del form
  let columnas = $('#form-reporte_recetas input[type=checkbox]:checked')
    .map(function () {
      return $(this).val();
    })
    .get();

  if (columnas.length === 0) {
    pantallaCarga('off');
    alertify.error('Selecciona al menos una columna para el reporte.');
    return;
  }

  let csrfToken = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
    url: '/reportes/api/recetas/exportar',
    method: 'POST',
    xhrFields: { responseType: 'blob' },
    headers: { 'X-CSRF-TOKEN': csrfToken },
    data: { filtros: filtros, columnas: columnas },
    success: function (data) {
      pantallaCarga('off');
      alertify.success('Reporte generado y descargado con éxito.');
      let blob = new Blob([data], {
        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
      });
      let url = window.URL.createObjectURL(blob);
      let a = document.createElement('a');
      a.href = url;
      a.download = 'reporte_recetas.xlsx';
      document.body.appendChild(a);
      a.click();
      a.remove();
    },
    error: function (xhr) {
      pantallaCarga('off');
      console.log(xhr);
      alertify.error('Sin resultados para generar el reporte.');
    }
  });
});
