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

class PacientesSeguimientoController extends Controller
{
  public function listadoPacientes(){
    return view('content.pages.listado-pacientes');
  }

  public function obtenerListadoPacientes(Request $request){
    $paciente = PacienteModel::withCount(['recetas'])->select(
      'paciente.id',
      'paciente.gafete',
      'paciente.nombre',
      'paciente.apellido_paterno',
      'paciente.apellido_materno',
      'paciente.edad',
      'paciente.curp',
      DB::raw("COALESCE(paciente.celular::text, 'Sin número') as celular")
    )
    ->where('paciente.borrado', 0)
    // ->groupBy('paciente.id', 'paciente.nombre', 'paciente.apellido_paterno', 'paciente.apellido_materno', 'paciente.edad', 'paciente.curp', 'paciente.celular')
    ->orderBy('paciente.nombre', 'asc');

    return DataTables::eloquent($paciente)
    # filtrar por nombre sin importar mayusculas y minusculas
    ->filter(function ($query) use ($request) {
      // buscar en tramite_detalle search[value]
      if (request()->has('search')) {
        if (request()->input('search.value')) {
          $search = strtolower($request->input('search.value'));
          $query->whereRaw('LOWER(paciente.nombre) LIKE LOWER(\'%' . $search . '%\')');
          $query->whereRaw('LOWER(paciente.nombre) LIKE LOWER(?) OR paciente.gafete::text LIKE ?', ["%{$search}%", "%{$search}%"]);
        }
      }
    })
    ->addColumn('acciones', function ($paciente) {
      $botones = '';

      $botones .= '<a  class="btn btn-icon rounded-pill btn-primary waves-effect waves-light m-1" title="Ver expediente" href="' . route('listado-expediente-paciente', ['paciente_id' => $paciente->id]) . '">' .
                    '<i class="mdi mdi-format-list-text mdi-20px"></i>' .
                  '</a>';

      $botones .= '<a class="btn btn-icon rounded-pill btn-warning waves-effect waves-light m-1" title="Valorar paciente" href="' . route('registrar-valoracion-paciente', ['paciente_id' => $paciente->id]) . '">' .
                    '<i class="mdi mdi-medical-cotton-swab mdi-20px"></i>' .
                  '</a>';

      // Solo mostrar botón si tiene al menos una receta
      if (count($paciente->recetas) > 0) {
        $botones .= '<a class="btn btn-icon rounded-pill btn-info waves-effect waves-light m-1" title="Ver recetas" href="' . route('listado-recetas', ['paciente_id' => $paciente->id]) . '">' .
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
    $pacienteId = $request->query('paciente_id');

    # Verifica si el ID existe
    if (!$pacienteId) {
      return redirect()->back()->with('error', 'No se proporcionó un ID de paciente.');
    }

    $view_data['paciente_id'] = $pacienteId;
    $view_data['paciente']['datos_generales'] = PacienteModel::where('id',$pacienteId)->where('borrado', 0)->get()->toArray();

    # Mandamos a la  vista
    return view('content.pages.listado-expediente-paciente',['datos_vista' => $view_data]);
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
      # buscar en tramite_detalle search[value]
      if (request()->has('search')) {
        if (request()->input('search.value')) {
          $search = strtolower($request->input('search.value'));
          $query->whereRaw('LOWER(paciente_datos_consulta.motivo_consulta) LIKE LOWER(\'%' . $search . '%\')');
        }
      }
    })
    ->addColumn('acciones', function ($detalle_consulta) {
      $botones = '';

      $botones .= '<a  class="btn btn-icon rounded-pill btn-success waves-effect waves-light m-1" title="Ver detalle de la consulta" href="' . route('detalle-consulta-paciente', ['detalle_consulta_id' => $detalle_consulta->id]) . '">' .
                    '<i class="mdi mdi-account-details mdi-20px"></i>' .
                  '</a>';

      return $botones;
    })
    ->rawColumns(['acciones'])
    ->make(true);
  }

  public function detalleConsultaPaciente(Request $request){
    # Obtiene el ID desde la URL
    $detalle_consultaId = $request->query('detalle_consulta_id');

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
    ->join('paciente_empresa', 'paciente_empresa.id', '=', 'paciente.paciente_empresa_id')
    ->join('paciente_unidad_negocio', 'paciente_unidad_negocio.id', '=', 'paciente.paciente_unidad_negocio_id')
    ->join('paciente_area', 'paciente_area.id', '=', 'paciente.paciente_area_id')
    ->join('paciente_subarea', 'paciente_subarea.id', '=', 'paciente.paciente_subarea_id')
    ->where('paciente.id', function($query) use ($detalle_consultaId) {
      $query->select('paciente_id')->from('paciente_datos_consulta')->where('id', $detalle_consultaId)->where('borrado', 0)->limit(1);
    })
    ->where('paciente.borrado', 0)
    ->get()->toArray();

    // dd($view_data);
    $view_data['paciente']['detalles_consulta'] = PacienteDatosConsultaModel::where('id', $detalle_consultaId)->where('borrado', 0)->first();
    $view_data['catalogos']['tipo_visita'] = PacienteTipoVisitaModel::where('borrado', 0)->get()->toArray();
    $view_data['notas'] = PacienteDatosConsultaNotaModel::where('paciente_datos_consulta_id',$detalle_consultaId)->where('borrado', 0)->get()->toArray();
    # Mandamos a la  vista
    return view('content.pages.expediente-paciente',['datos_vista' => $view_data]);
  }

  public function recetasPaciente(Request $request){
    # Obtiene el ID desde la URL
    $pacienteId = $request->query('paciente_id');

    # Verifica si el ID existe
    if (!$pacienteId) {
      return redirect()->back()->with('error', 'No se proporcionó un ID de paciente.');
    }

    $view_data['paciente_id'] = $pacienteId;
    $view_data['paciente']['datos_generales'] = PacienteModel::where('id',$pacienteId)->where('borrado', 0)->get()->toArray();
    $view_data['paciente']['recetas'] = RecetaModel::where('paciente_id',$pacienteId)->where('borrado', 0)->get()->toArray();

    # Mandamos a la  vista
    return view('content.pages.listado-receta-paciente',['datos_vista' => $view_data]);
  }

  public function obtenerListadoRecetasPaciente(Request $request){
    # Obtener el paciente_id desde los datos POST
    $pacienteId = $request->input('paciente_id');

    $detalle_receta = RecetaModel::select(
      'receta.id as id',
      'receta.paciente_id as paciente_id',
      'usuario.nombre as nombre',
      'usuario.apellido_paterno as apellido_p',
      'usuario.apellido_materno as apellido_m',
      'paciente.nombre as paciente_nombre',
      'paciente.apellido_paterno as paciente_apellido_p',
      'paciente.apellido_materno as paciente_apellido_m',
      'paciente.edad as paciente_edad',
      'receta.medicamento_indicaciones as medicamento',
      'receta.recomendaciones as recomendaciones',
      'receta.created_at as fecha_creacion'
    )
    ->join('usuario', 'usuario.id', '=', 'receta.usuario_id')
    ->join('paciente', 'paciente.id', '=', 'receta.paciente_id')
    ->where('receta.paciente_id', $pacienteId)
    ->where('usuario.borrado', 0)
    ->where('receta.borrado', 0)
    ->orderBy('receta.created_at', 'desc');
    // dd($detalle_receta->toSql()); // Muestra la consulta SQL

    return DataTables::eloquent($detalle_receta)
    # filtrar por nombre sin importar mayusculas y minusculas
    ->filter(function ($query) use ($request) {
      # buscar en tramite_detalle search[value]
      if (request()->has('search')) {
        if (request()->input('search.value')) {
          $search = strtolower($request->input('search.value'));
          $query->whereRaw('LOWER(receta.medicamento_indicaciones) LIKE LOWER(\'%' . $search . '%\')');
        }
      }
    })
    ->addColumn('acciones', function ($detalle_receta) {
      $botones = '';
      // Enlace en la tabla
      $botones .= '<a href="' . route('receta-nueva', ['medicamento' => urlencode($detalle_receta->medicamento),'recomendaciones' => urlencode($detalle_receta->recomendaciones),'id' => urlencode($detalle_receta->id),'paciente_nombre' => urlencode($detalle_receta->paciente_nombre),'paciente_apellido_p' => urlencode($detalle_receta->paciente_apellido_p),'paciente_apellido_m' => urlencode($detalle_receta->paciente_apellido_m),'paciente_edad' => urlencode($detalle_receta->paciente_edad),'paciente_id' => urlencode($detalle_receta->paciente_id)]) . '" class="btn btn-icon rounded-pill btn-info waves-effect waves-light m-1" title="Ver detalle de la receta">' .
        '<i class="mdi mdi-text-box-check-outline mdi-20px"></i>' .
      '</a>';


      return $botones;
    })
    ->rawColumns(['acciones'])
    ->make(true);
  }
}
