<?php

namespace App\Http\Controllers\pages\reportes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\PacienteModel;
use App\Models\UsuarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
# uses para generar excel
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ReportesController extends Controller
{
  public function index(Request $request)
  {
    $view_data = [
      'catalogos' => [
        'pacientes' => PacienteModel::whereHas('pacienteConReceta')->where('borrado', 0)->get()->toArray(),
        'medico_tratante' => UsuarioModel::whereHas('medicoTratanteReceta')->get()->toArray(),
      ]
    ];
    return view('content.pages.reportes.recetas', ['datos_vista' => $view_data]);
  }

  public function exportarRecetas(Request $request)
  {
    # Siempre incluir folio_receta
    $columnas = $request->columnas ?? [];
    $columnas = array_unique(array_merge(['folio_receta'], $columnas));

    # Mapeo columnas - BD
    $mapaColumnas = [
      'folio_receta' => "concat('#', r.id) as folio_receta",
      'fecha_creacion' => "r.created_at as fecha_creacion",
      'paciente_gafete' => "p.gafete as paciente_gafete",
      'paciente_nombre' => "p.nombre as paciente_nombre",
      'paciente_apellido_paterno' => "p.apellido_paterno as paciente_apellido_paterno",
      'paciente_apellido_materno' => "p.apellido_materno as paciente_apellido_materno",
      'paciente_genero' => "case when p.genero = 'M' then 'Masculino' when p.genero = 'F' then 'Femenino' end as paciente_genero",
      'paciente_curp' => "p.curp as paciente_curp",
      'medico_tratante_nombre' => "u.nombre as medico_tratante_nombre",
      'medico_tratante_apellido_paterno' => "u.apellido_paterno as medico_tratante_apellido_paterno",
      'medico_tratante_apellido_materno' => "u.apellido_materno as medico_tratante_apellido_materno",
      'medico_tratante_correo' => "concat(u.correo, '@agrizar.com') as medico_tratante_correo",
      'indicaciones_medicamento' => "r.medicamento_indicaciones as indicaciones_medicamento",
      'recomendaciones_receta' => "r.recomendaciones as recomendaciones_receta",
      'medicamento_recetado' => "rm.medicamento_nombre as medicamento_recetado",
      'medicamento_codigo' => "rm.medicamento_codigo as medicamento_codigo",
      'medicamento_cantidad_solicitada' => "rm.cantidad_solicitada as medicamento_cantidad_solicitada",
      'centro_costos_medicamento' => "rch.centro_costos as centro_costos_medicamento",
      'vale_medicamento' => "rch.vale_id as vale_medicamento",
    ];

    # SELECT dinámico
    $select = Helpers::buildSelect($columnas, $mapaColumnas);

    # Formar consulta
    $registrosQuery = DB::table('receta AS r')
      ->join('paciente AS p', 'p.id', '=', 'r.paciente_id')
      ->join('usuario AS u', 'u.id', '=', 'r.usuario_id')
      ->leftJoin('receta_medicamento AS rm', 'rm.receta_id', '=', 'r.id')
      ->join('receta_consumo_historico AS rch', 'rch.receta_id', '=', 'r.id');

    # Filtros de búsqueda
    $f = $request->filtros ?? [];
    if (!empty($f['fecha_inicio'])) {
      $registrosQuery->whereDate('r.created_at', '>=', $f['fecha_inicio']);
    }
    if (!empty($f['fecha_fin'])) {
      $registrosQuery->whereDate('r.created_at', '<=', $f['fecha_fin']);
    }
    if (!empty($f['paciente'])) {
      $registrosQuery->where('p.id', $f['paciente']);
    }
    if (!empty($f['medico'])) {
      $registrosQuery->where('u.id', $f['medico']);
    }

    # Obtener datos para generar Excel
    $registros = $registrosQuery
      ->select($select)
      ->orderBy('r.id', 'DESC')
      ->get()
      ->toArray();

    if (count($registros) === 0) {
      return response()->json([
        'status' => 'sin_resultados',
        'mensaje' => 'No se encontraron registros con los filtros seleccionados.'
      ]);
    }

    # Crear hoja de cálculo
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    # Sacamos la última columna y el total de columnas
    $totalColumnas = count($columnas);
    $ultimaColumna = Coordinate::stringFromColumnIndex($totalColumnas);

    # Insertar logo e información del reporte
    $logoPath = public_path('assets/img/logos/agzback.png');
    Helpers::insertLogoAndInfo($sheet, $columnas, $registros, $logoPath);

    # Estilo del encabezado de columnas y escritura
    Helpers::writeHeaders($sheet, $columnas, 3);

    # Escribir datos — devuelve fila siguiente a la última escrita
    $siguienteFila = Helpers::writeData($sheet, $columnas, $registros, 4);

    # Merge celdas con valores idénticos en columnas
    Helpers::mergeIdenticalColumns($sheet, $columnas, 2);

    # Descargar archivo
    $filename = "Reporte_Recetas_" . date('Ymd_His') . ".xlsx";

    ob_clean(); # Limpiar buffers de salida
    ob_end_clean(); # Limpiar buffers de salida

    return new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($spreadsheet) {
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }, 200, [
        "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        "Content-Disposition" => "attachment; filename=\"$filename\"",
        "Cache-Control" => "max-age=0",
    ]);
}
}
