$(document).ready(function () {
  pantallaCarga('off');
  $('.select2').select2();
});

$(document).on('change', '#filtro-fecha_inicio, #filtro-fecha_fin', function () {
  let fechaInicio = $('#filtro-fecha_inicio').val();
  let fechaFin = $('#filtro-fecha_fin').val();
  if (fechaInicio && fechaFin) {
    if (new Date(fechaFin) < new Date(fechaInicio)) {
      alertify.error('<b>Rango de fechas inválido.</b><br>La fecha final no puede ser menor que la fecha inicial.');
      $('#filtro-fecha_fin').val('');
    }
  }
});

$('#boton-seleccionar_todas_columnas_reporte_consultas').on('click', function () {
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
$(document).on('click', '#boton-limpiar_filtros_reporte_consultas', function () {
  $('#filtro-fecha_inicio').val('');
  $('#filtro-fecha_fin').val('');
  $('#filtro-nombre_paciente').val('').trigger('change');
  $('#filtro-edad').val('').trigger('change');
  $('#filtro-genero').val('').trigger('change');
  $('#filtro-empresa').val('').trigger('change');
  $('#filtro-unidad_negocio').val('').trigger('change');
  $('#filtro-area').val('').trigger('change');
  $('#filtro-subarea').val('').trigger('change');
  $('#filtro-tipo_visita').val('').trigger('change');
});

$('#boton-generar_reporte_consultas').click(function (e) {
  e.preventDefault();
  pantallaCarga('on');

  let fechaInicio = $('#filtro-fecha_inicio').val();
  let fechaFin = $('#filtro-fecha_fin').val();
  let paciente = $('#filtro-nombre_paciente').val();
  let edad = $('#filtro-edad').val();
  let genero = $('#filtro-genero').val();
  let empresa = $('#filtro-empresa').val();
  let unidad = $('#filtro-unidad_negocio').val();
  let area = $('#filtro-area').val();
  let subarea = $('#filtro-subarea').val();
  let tipo_visita = $('#filtro-tipo_visita').val();

  if (
    !fechaInicio &&
    !fechaFin &&
    !paciente &&
    !edad &&
    !genero &&
    !empresa &&
    !unidad &&
    !area &&
    !subarea &&
    !tipo_visita
  ) {
    pantallaCarga('off');
    alertify.error(
      '<b>Selecciona al menos un filtro.</b><br>Debes elegir mínimo una opción antes de generar el reporte.'
    );
    return;
  }

  let filtros = {
    fecha_inicio: fechaInicio,
    fecha_fin: fechaFin,
    paciente: paciente,
    edad: edad,
    genero: genero,
    empresa_id: empresa,
    unidad_negocio: unidad,
    area: area,
    subarea: subarea,
    tipo_visita: tipo_visita
  };

  // Obtiene SOLO los checkboxes marcados dentro del form
  let columnas = $('#form-reporte_consultas input[type=checkbox]:checked')
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
    url: '/reportes/api/consultas/exportar',
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
      a.download = 'reporte_consultas.xlsx';
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
