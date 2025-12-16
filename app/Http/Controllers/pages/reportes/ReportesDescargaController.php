<?php

namespace App\Http\Controllers\pages\reportes;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
# uses para generar excel
use App\Exports\DynamicExportQuery;
use Maatwebsite\Excel\Facades\Excel;

class ReportesDescargaController extends Controller
{
  # Funcion auxiliar para determinar si se requieren ciertos JOINs
  private function requires($cols, $targetCols){ return count(array_intersect($cols, $targetCols)) > 0; }

  public function exportarRecetas(Request $request)
  {
    ini_set('max_execution_time', 1200);
    ini_set('memory_limit', '2048M');

    $columnas = $request->columnas ?? [];
    $columnas = array_unique(array_merge(['folio_receta'], $columnas));

    $mapa = [
      'folio_receta' => "CONCAT('#', r.id) AS folio_receta",
      'fecha_creacion' => "r.created_at AS fecha_creacion",
      'paciente_gafete' => "p.gafete AS paciente_gafete",
      'paciente_nombre' => "p.nombre AS paciente_nombre",
      'paciente_apellido_paterno' => "p.apellido_paterno AS paciente_apellido_paterno",
      'paciente_apellido_materno' => "p.apellido_materno AS paciente_apellido_materno",
      'paciente_genero' => "CASE WHEN p.genero='M' THEN 'Masculino' WHEN p.genero='F' THEN 'Femenino' END AS paciente_genero",
      'paciente_curp' => "p.curp AS paciente_curp",
      'medico_tratante_nombre' => "u.nombre AS medico_tratante_nombre",
      'medico_tratante_apellido_paterno' => "u.apellido_paterno AS medico_tratante_apellido_paterno",
      'medico_tratante_apellido_materno' => "u.apellido_materno AS medico_tratante_apellido_materno",
      'medico_tratante_correo' => "CONCAT(u.correo,'@agrizar.com') AS medico_tratante_correo",
      'indicaciones_medicamento' => "r.medicamento_indicaciones AS indicaciones_medicamento",
      'recomendaciones_receta' => "r.recomendaciones AS recomendaciones_receta",
      'medicamento_recetado' => "rm.medicamento_nombre AS medicamento_recetado",
      'medicamento_codigo' => "rm.medicamento_codigo AS medicamento_codigo",
      'medicamento_cantidad_solicitada' => "rm.cantidad_solicitada AS medicamento_cantidad_solicitada",
      'centro_costos_medicamento' => "rch.centro_costos AS centro_costos_medicamento",
      'vale_medicamento' => "rch.vale_id AS vale_medicamento",
    ];

    $select = [];
    foreach ($columnas as $col) {
      if (isset($mapa[$col])) $select[] = DB::raw($mapa[$col]);
    }

    $query = DB::table('receta AS r')->where('r.borrado', 0)->orderBy('r.id', 'ASC');

    # JOINS dinámicos
    if ($this->requires($columnas, ['paciente_gafete','paciente_nombre','paciente_apellido_paterno','paciente_apellido_materno','paciente_genero','paciente_curp'])) {
      $query->join('paciente AS p', 'p.id', '=', 'r.paciente_id');
    }
    if ($this->requires($columnas, ['medico_tratante_nombre','medico_tratante_apellido_paterno','medico_tratante_apellido_materno','medico_tratante_correo'])) {
      $query->join('usuario AS u', 'u.id', '=', 'r.usuario_id');
    }
    if ($this->requires($columnas, ['medicamento_recetado','medicamento_codigo','medicamento_cantidad_solicitada'])) {
      $query->leftJoin('receta_medicamento AS rm', 'rm.receta_id', '=', 'r.id');
    }
    if ($this->requires($columnas, ['centro_costos_medicamento','vale_medicamento'])) {
      $query->join('receta_consumo_historico AS rch', 'rch.receta_id', '=', 'r.id');
    }

    # Filtros
    $f = $request->filtros ?? [];
    if (!empty($f['fecha_inicio'])) $query->whereDate('r.created_at', '>=', $f['fecha_inicio']);
    if (!empty($f['fecha_fin'])) $query->whereDate('r.created_at', '<=', $f['fecha_fin']);
    if (!empty($f['paciente'])) $query->where('r.paciente_id', $f['paciente']);
    if (!empty($f['medico'])) $query->where('r.usuario_id', $f['medico']);

    $query->select($select)->orderBy('r.id', 'ASC');
    return Excel::download(new DynamicExportQuery($query, $columnas),"Reporte_Recetas_" . now()->format('Ymd_His') . ".xlsx");
  }

  public function exportarPacientes(Request $request)
  {
    ini_set('max_execution_time', 1200);
    ini_set('memory_limit', '2048M');

    $columnas = $request->columnas ?? [];
    $columnas = array_unique(array_merge(['fecha_registro_en_sistema'], $columnas));

    $mapa = [
        'fecha_registro_en_sistema' => "p.created_at AS fecha_registro_en_sistema",
        'paciente_gafete' => "CONCAT('#', p.gafete) AS paciente_gafete",
        'paciente_nombre' => "p.nombre",
        'paciente_apellido_paterno' => "p.apellido_paterno",
        'paciente_apellido_materno' => "p.apellido_materno",
        'paciente_genero' => "CASE WHEN p.genero='M' THEN 'Masculino' WHEN p.genero='F' THEN 'Femenino' END AS paciente_genero",
        'paciente_edad' => "p.edad",
        'paciente_telefono' => "p.celular",
        'paciente_curp' => "p.curp",
        'paciente_empresa' => "pe.nombre AS paciente_empresa",
        'paciente_unidad_negocio' => "pun.nombre AS paciente_unidad_negocio",
        'paciente_area' => "pa.nombre AS paciente_area",
        'paciente_subarea' => "psa.nombre AS paciente_subarea",
    ];

    $select = [];
    foreach ($columnas as $col) {
        if (isset($mapa[$col])) $select[] = DB::raw($mapa[$col]);
    }

    $query = DB::table('paciente AS p')->where('p.borrado', 0)->join('paciente_datos_consulta as pdc', 'p.id', '=', 'pdc.paciente_id')->where('pdc.borrado', 0)->distinct('p.id')->orderBy('p.id');

    # JOINS DINÁMICOS
    if ($this->requires($columnas, ['paciente_empresa','paciente_unidad_negocio','paciente_area','paciente_subarea'])) {
      $query->join('paciente_empresa AS pe', 'pe.id', '=', 'p.paciente_empresa_id');
      $query->join('paciente_unidad_negocio AS pun', 'pun.id', '=', 'p.paciente_unidad_negocio_id');
      $query->join('paciente_area AS pa', 'pa.id', '=', 'p.paciente_area_id');
      $query->join('paciente_subarea AS psa', 'psa.id', '=', 'p.paciente_subarea_id');
    }

    # Filtros
    $f = $request->filtros ?? [];

    if (!empty($f['fecha_inicio'])) $query->whereDate('p.created_at', '>=', $f['fecha_inicio']);
    if (!empty($f['fecha_fin'])) $query->whereDate('p.created_at', '<=', $f['fecha_fin']);
    if (!empty($f['paciente'])) $query->where('p.id', $f['paciente']);
    if (!empty($f['edad'])) $query->where('p.edad', $f['edad']);
    if (!empty($f['genero'])) $query->where('p.genero', $f['genero']);
    if (!empty($f['empresa_id'])) $query->where('p.paciente_empresa_id', $f['empresa_id']);
    if (!empty($f['unidad_negocio'])) $query->where('p.paciente_unidad_negocio_id', $f['unidad_negocio']);
    if (!empty($f['area'])) $query->where('p.paciente_area_id', $f['area']);
    if (!empty($f['subarea'])) $query->where('p.paciente_subarea_id', $f['subarea']);

    $query->select($select)->orderBy('p.nombre','ASC');
    return Excel::download(new DynamicExportQuery($query, $columnas),"Reporte_Pacientes_" . now()->format('Ymd_His') . ".xlsx");
  }

  public function exportarConsultas(Request $request)
  {
    ini_set('max_execution_time', 1200);
    ini_set('memory_limit', '2048M');

    $columnas = $request->columnas ?? [];
    $columnas = array_unique(array_merge(['fecha_consulta'], $columnas));

    $mapa = [
      'fecha_consulta' => "pdc.created_at AS fecha_consulta",
      'paciente_gafete' => "CONCAT('#', p.gafete) AS paciente_gafete",
      'paciente_nombre' => "p.nombre",
      'paciente_apellido_paterno' => "p.apellido_paterno",
      'paciente_apellido_materno' => "p.apellido_materno",
      'paciente_genero' => "p.genero",
      'paciente_edad' => "p.edad",
      'paciente_telefono' => "p.celular",
      'paciente_curp' => "p.curp",
      'paciente_empresa' => "pe.nombre AS paciente_empresa",
      'paciente_unidad_negocio' => "pun.nombre AS paciente_unidad_negocio",
      'paciente_area' => "pa.nombre AS paciente_area",
      'paciente_subarea' => "psa.nombre AS paciente_subarea",
      'motivo_consulta' => "pdc.motivo_consulta",
      'cie_nombre' => "pdc.cie_descripcion",
      'temperatura' => "pdc.temperatura",
      'peso' => "pdc.peso",
      'altura' => "pdc.altura",
      'imc' => "pdc.imc",
      'frecuencia_cardiaca' => "pdc.frecuencia_cardiaca",
      'saturacion_oxigeno' => "pdc.saturacion_oxigeno",
      'presion_arterial' => "pdc.presion_arterial",
      'observaciones' => "pdc.observaciones",
      'tipo_visita' => "ptv.nombre AS tipo_visita",
    ];

    $select = [];
    foreach ($columnas as $col) {
      if (isset($mapa[$col])) {
        $select[] = DB::raw($mapa[$col]);
      }
    }

    $query = DB::table('paciente_datos_consulta AS pdc')->where('pdc.borrado', 0)->orderBy('pdc.paciente_id','DESC');

    # Joins dinámicos
    if ($this->requires($columnas, ['paciente_gafete','paciente_nombre','paciente_apellido_paterno','paciente_apellido_materno','paciente_genero','paciente_edad','paciente_telefono','paciente_curp','paciente_empresa','paciente_unidad_negocio','paciente_area','paciente_subarea'])) {
      $query->join('paciente AS p', 'p.id', '=', 'pdc.paciente_id')->where('p.borrado', 0);
    }

    if (in_array('paciente_empresa', $columnas)) { $query->join('paciente_empresa AS pe', 'pe.id', '=', 'p.paciente_empresa_id'); }
    if (in_array('paciente_unidad_negocio', $columnas)) { $query->join('paciente_unidad_negocio AS pun', 'pun.id', '=', 'p.paciente_unidad_negocio_id'); }
    if (in_array('paciente_area', $columnas)) { $query->join('paciente_area AS pa', 'pa.id', '=', 'p.paciente_area_id'); }
    if (in_array('paciente_subarea', $columnas)) { $query->join('paciente_subarea AS psa', 'psa.id', '=', 'p.paciente_subarea_id'); }
    if (in_array('tipo_visita', $columnas)) { $query->join('paciente_tipo_visita AS ptv', 'ptv.id', '=', 'pdc.paciente_tipo_visita_id'); }

    # Filtros
    $f = $request->filtros ?? [];
    if (!empty($f['fecha_inicio'])) $query->whereDate('pdc.created_at', '>=', $f['fecha_inicio']);
    if (!empty($f['fecha_fin'])) $query->whereDate('pdc.created_at', '<=', $f['fecha_fin']);
    if (!empty($f['paciente'])) $query->where('p.id', $f['paciente']);
    if (!empty($f['edad'])) $query->where('p.edad', $f['edad']);
    if (!empty($f['genero'])) $query->where('p.genero', $f['genero']);
    if (!empty($f['empresa_id'])) $query->where('p.paciente_empresa_id', $f['empresa_id']);
    if (!empty($f['unidad_negocio'])) $query->where('p.paciente_unidad_negocio_id', $f['unidad_negocio']);
    if (!empty($f['area'])) $query->where('p.paciente_area_id', $f['area']);
    if (!empty($f['subarea'])) $query->where('p.paciente_subarea_id', $f['subarea']);
    if (!empty($f['tipo_visita'])) $query->where('pdc.paciente_tipo_visita_id', $f['tipo_visita']);

    $query->select($select)->orderBy('pdc.created_at','DESC');
    return Excel::download(new DynamicExportQuery($query, $columnas),"Reporte_Consultas_" . now()->format('Ymd_His') . ".xlsx");
  }

}
