<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\PacienteModel;
use App\Models\PacienteDatosConsultaModel;
use App\Models\PacienteTipoVisitaModel;
use App\Models\PacienteDatosConsultaNotaModel;
use App\Models\RecetaModel;
use Illuminate\Support\Facades\Crypt;

class PacientesSeguimientoController extends Controller
{
  public function listadoPacientes(){
    return view('content.pages.paciente.listado-pacientes');
  }

  public function obtenerListadoPacientes(Request $request){
    $paciente = PacienteModel::withCount(['recetas'])->select(
      'paciente.id',
      'paciente.gafete',
      'paciente.nombre',
      DB::raw("COALESCE(paciente.apellido_paterno::text, '') as apellido_paterno"),
      DB::raw("COALESCE(paciente.apellido_materno::text, '') as apellido_materno"),
      'paciente.edad',
      'paciente.curp',
      DB::raw("COALESCE(paciente.celular::text, 'Sin número') as celular"),
      DB::raw("COUNT(paciente_datos_consulta.paciente_id) as consultas_count")
    )
    ->leftJoin('paciente_datos_consulta', function($join) {
      $join->on('paciente.id', '=', 'paciente_datos_consulta.paciente_id')
      ->where('paciente_datos_consulta.borrado', 0);
    })
    ->where('paciente_datos_consulta.borrado', 0)->where('paciente.borrado', 0)
    ->groupBy([
      'paciente.id',
      'paciente.gafete',
      'paciente.nombre',
      'paciente.apellido_paterno',
      'paciente.apellido_materno',
      'paciente.edad',
      'paciente.curp',
      'paciente.celular'
    ])
    ->orderBy('paciente.nombre', 'asc');
    return DataTables::eloquent($paciente)
    # filtrar por nombre sin importar mayusculas y minusculas
    ->filter(function ($query) use ($request) {
        if ($request->has('search') && $request->input('search.value')) {
            $search = strtolower($request->input('search.value'));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(paciente.nombre) LIKE ?', ["%{$search}%"])
                  ->orWhere('paciente.gafete', 'LIKE', "%{$search}%")
                  ->orWhereRaw('LOWER(paciente.apellido_paterno) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(paciente.apellido_materno) LIKE ?', ["%{$search}%"]);
            });
        }
    })
    ->addColumn('acciones', function ($paciente) {
      $paciente_id_encriptado = Crypt::encryptString($paciente->id);

      $botones = '';

      $botones .= '<a  class="btn btn-icon rounded-pill btn-primary waves-effect waves-light m-1" title="Ver expediente" href="' . route('listado-expediente-paciente', ['paciente_id' => $paciente_id_encriptado]) . '">' .
                    '<i class="mdi mdi-format-list-text mdi-20px"></i>' .
                  '</a>';

      $botones .= '<a class="btn btn-icon rounded-pill btn-warning waves-effect waves-light m-1" title="Valorar paciente" href="' . route('registrar-valoracion-paciente', ['paciente_id' => $paciente_id_encriptado]) . '">' .
                    '<i class="mdi mdi-medical-cotton-swab mdi-20px"></i>' .
                  '</a>';

      // Solo mostrar botón si tiene al menos una receta
      if (count($paciente->recetas) > 0) {
        $botones .= '<a class="btn btn-icon rounded-pill btn-info waves-effect waves-light m-1" title="Ver recetas" href="' . route('listado-recetas', ['paciente_id' => $paciente_id_encriptado]) . '">' .
                      '<i class="mdi mdi-text-box-multiple mdi-20px"></i>' .
                    '</a>';
      }

      return $botones;
    })
    ->rawColumns(['acciones'])
    ->make(true);
  }

  public function expedientePacientes(Request $request){
    # Obtiene el ID desde la URL
    $pacienteId = Crypt::decryptString($request->query('paciente_id'));

    # Verifica si el ID existe
    if (!$pacienteId) {
      return redirect()->back()->with('error', 'No se proporcionó un ID de paciente.');
    }

    $view_data['paciente_id'] = $pacienteId;
    $view_data['paciente']['datos_generales'] = PacienteModel::where('id',$pacienteId)->where('borrado', 0)->get()->toArray();

    # Mandamos a la  vista
    return view('content.pages.paciente.listado-expediente-paciente',['datos_vista' => $view_data]);
  }

  public function obtenerListadoConsultasPaciente(Request $request){
    # Obtener el paciente_id desde los datos POST
    $pacienteId = $request->input('paciente_id');

    $detalle_consulta = PacienteDatosConsultaModel::select(
      'paciente_datos_consulta.id',
      'paciente_datos_consulta.motivo_consulta',
      'paciente_cie.codigo',
      'paciente_datos_consulta.temperatura',
      'paciente_datos_consulta.peso',
      'paciente_datos_consulta.altura',
      'paciente_datos_consulta.imc',
      'paciente_datos_consulta.frecuencia_cardiaca',
      'paciente_datos_consulta.saturacion_oxigeno',
      'paciente_datos_consulta.presion_arterial',
      'paciente_datos_consulta.created_at as fecha_registro',
    )
    ->join('paciente_cie', 'paciente_cie.id', '=', 'paciente_datos_consulta.cie_id')
    ->where('paciente_datos_consulta.paciente_id', $pacienteId)
    ->where('paciente_datos_consulta.borrado', 0)
    ->orderBy('paciente_datos_consulta.created_at', 'desc');
    // dd($detalle_consulta->toSql()); // Muestra la consulta SQL

    return DataTables::eloquent($detalle_consulta)
    # filtrar por nombre sin importar mayusculas y minusculas
    ->filter(function ($query) use ($request) {
      # buscar search[value]
      if (request()->has('search')) {
        if (request()->input('search.value')) {
          $search = strtolower($request->input('search.value'));
          $query->whereRaw('LOWER(paciente_datos_consulta.motivo_consulta) LIKE LOWER(\'%' . $search . '%\')');
        }
      }
    })
    ->addColumn('acciones', function ($detalle_consulta) {
      $botones = '';

      $botones .= '<a  class="btn btn-icon rounded-pill btn-success waves-effect waves-light m-1" title="Ver detalle de la consulta" href="' . route('detalle-consulta-paciente', ['detalle_consulta_id' => Crypt::encryptString($detalle_consulta->id)]) . '">' .
                    '<i class="mdi mdi-account-details mdi-20px"></i>' .
                  '</a>';

      return $botones;
    })
    ->rawColumns(['acciones'])
    ->make(true);
  }

  public function detalleConsultaPaciente(Request $request){
    # Obtiene el ID desde la URL
    $detalle_consultaId = Crypt::decryptString($request->query('detalle_consulta_id'));

    # Verifica si el ID existe
    if (!$detalle_consultaId) {
      return redirect()->back()->with('error', 'No se proporcionó un ID de paciente.');
    }

    $view_data['paciente']['datos_generales'] = PacienteModel::select(
      'paciente.id',
      'paciente.gafete',
      'paciente.nombre',
      'paciente.apellido_paterno',
      'paciente.apellido_materno',
      'paciente.genero',
      'paciente.celular',
      'paciente.edad',
      'paciente.curp',
      'paciente_empresa.nombre as empresa_nombre',
      'paciente_unidad_negocio.nombre as unidad_negocio_nombre',
      'paciente_area.nombre as area_nombre',
      'paciente_subarea.nombre as subarea_nombre',
    )
    ->leftjoin('paciente_empresa', 'paciente_empresa.id', '=', 'paciente.paciente_empresa_id')
    ->leftjoin('paciente_unidad_negocio', 'paciente_unidad_negocio.id', '=', 'paciente.paciente_unidad_negocio_id')
    ->leftjoin('paciente_area', 'paciente_area.id', '=', 'paciente.paciente_area_id')
    ->leftjoin('paciente_subarea', 'paciente_subarea.id', '=', 'paciente.paciente_subarea_id')
    ->where('paciente.id', function($query) use ($detalle_consultaId) {
      $query->select('paciente_id')->from('paciente_datos_consulta')->where('id', $detalle_consultaId)->where('borrado', 0)->limit(1);
    })
    ->where('paciente.borrado', 0)
    ->get()->toArray();

    $view_data['paciente']['detalles_consulta'] = PacienteDatosConsultaModel::select(
      'paciente_datos_consulta.*',
      'usuario.nombre as usuario_nombre',
      'usuario.apellido_paterno as usuario_apellido_paterno',
      'usuario.apellido_materno as usuario_apellido_materno'
    )
    ->leftjoin('usuario', 'usuario.id', '=', 'paciente_datos_consulta.usuario_id')
    ->where('paciente_datos_consulta.id', $detalle_consultaId)->where('paciente_datos_consulta.borrado', 0)->first();

    $view_data['catalogos']['tipo_visita'] = PacienteTipoVisitaModel::where('borrado', 0)->get()->toArray();
    $view_data['notas'] = PacienteDatosConsultaNotaModel::where('paciente_datos_consulta_id',$detalle_consultaId)->where('borrado', 0)->get()->toArray();
    # Mandamos a la  vista
    return view('content.pages.paciente.expediente-paciente',['datos_vista' => $view_data]);
  }

  public function todasLasConsultas(Request $request){
    $view_data['catalogos']['tipo_visita'] = PacienteTipoVisitaModel::where('borrado', 0)->get()->toArray();

    $view_data['tipo_visita_seleccionado'] = $request->input('tipo_visita_seleccionado');

    # Mandamos a la  vista
    return view('content.pages.paciente.listado-consultas',['datos_vista' => $view_data]);
  }

  public function obtenerListadoTodasConsultas(Request $request) {
    $query = PacienteDatosConsultaModel::query()
    ->select([
        'paciente_datos_consulta.id as consulta_id',
        'paciente.gafete as paciente_gafete',
        DB::raw("CONCAT(paciente.nombre, ' ', paciente.apellido_paterno, ' ', paciente.apellido_materno) as paciente_nombre"),
        'paciente.edad as paciente_edad',
        'paciente_tipo_visita.nombre as tipo_visita',
        'paciente_datos_consulta.cie_descripcion as motivo_consulta',
        'paciente_datos_consulta.observaciones as consulta_observaciones',
        'paciente_datos_consulta.medicamento_recetado as consulta_medicamento',
        'paciente_empresa.nombre as paciente_empresa',
        'paciente_unidad_negocio.nombre as paciente_unidad_negocio',
        'paciente_area.nombre as paciente_area',
        'paciente_subarea.nombre as paciente_subarea',
        'paciente_datos_consulta.created_at as fecha_consulta'
    ])
    ->join('paciente', 'paciente.id', '=', 'paciente_datos_consulta.paciente_id')
    ->join('paciente_tipo_visita', 'paciente_tipo_visita.id', '=', 'paciente_datos_consulta.paciente_tipo_visita_id')
    ->leftjoin('paciente_empresa', 'paciente_empresa.id', '=', 'paciente.paciente_empresa_id')
    ->leftjoin('paciente_unidad_negocio', 'paciente_unidad_negocio.id', '=', 'paciente.paciente_unidad_negocio_id')
    ->leftjoin('paciente_area', 'paciente_area.id', '=', 'paciente.paciente_area_id')
    ->leftjoin('paciente_subarea', 'paciente_subarea.id', '=', 'paciente.paciente_subarea_id')
    ->where('paciente_datos_consulta.borrado', 0);

    # Filtros de fechas en la query
    if ($request->filled('fecha_inicio') && !$request->filled('fecha_fin')) {
      $query->whereDate('paciente_datos_consulta.created_at', '=', $request->fecha_inicio);
    }
    elseif (!$request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
      $query->whereDate('paciente_datos_consulta.created_at', '=', $request->fecha_fin);
    }
    elseif ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
      $query->whereBetween('paciente_datos_consulta.created_at', [
          $request->fecha_inicio . ' 00:00:00',
          $request->fecha_fin . ' 23:59:59'
      ]);
    }

    # Filtro por nombre
    if ($request->filled('empleado_nombre')) {
      $nombre = $request->empleado_nombre;
      $query->where(function($q) use ($nombre) {
        $q->where('paciente.nombre', 'iLIKE', "%$nombre%")
          ->orWhere('paciente.apellido_paterno', 'iLIKE', "%$nombre%")
          ->orWhere('paciente.apellido_materno', 'iLIKE', "%$nombre%")
          ->orWhereRaw("CONCAT(paciente.nombre, ' ', paciente.apellido_paterno, ' ', paciente.apellido_materno) iLIKE ?", ["%$nombre%"]);
      });
    }

    # Filtro por numero de empleado
    if ($request->filled('numero_empleado')) {
      $query->where('paciente.gafete', 'iLIKE', "%$request->numero_empleado%");
    }

    # Filtro por tipo de visita
    if ($request->filled('tipo_visita')) {
      $query->where('paciente_datos_consulta.paciente_tipo_visita_id', '=', $request->tipo_visita);
    }

    return DataTables::eloquent($query)
    ->addColumn('acciones', function ($consulta) {
      $detalle_consulta_id_encriptado = Crypt::encryptString($consulta->consulta_id);
      return '<a class="btn btn-icon rounded-pill btn-success waves-effect waves-light m-1" title="Ver detalle de la consulta" href="'.route('detalle-consulta-paciente', ['detalle_consulta_id' => $detalle_consulta_id_encriptado]).'">
                <i class="mdi mdi-account-details mdi-20px"></i>
              </a>';
    })
    ->rawColumns(['acciones'])
    ->toJson();
  }
}
