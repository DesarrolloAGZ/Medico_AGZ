<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\HistoricoClinicoModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class HistoricoClinicoSeguimientoController extends Controller
{
  public function listadoHistoricos(){
    if(Auth::user()->usuario_perfil_id == 1 || Auth::user()->usuario_perfil_id == 2 || Auth::user()->usuario_perfil_id == 3 || Auth::user()->usuario_perfil_id == 4 || Auth::user()->usuario_perfil_id == 5 || Auth::user()->usuario_perfil_id == 6){
   
      return view('content.pages.historicoClinico.listado-historico');

    } else {
      return view('content.pages.pages-misc-error');
    }
  }

  public function obtenerListadoHistoricosClinicos(Request $request){
    $historicoClinico = HistoricoClinicoModel::select(
      'hc.id',
      'hc.tipo_registro',
      'hc.curp',
      DB::raw("CONCAT(hc.nombre, ' ', hc.apellido_paterno, ' ', hc.apellido_materno) AS nombre_completo"),
      'hc.genero',
      'hc.edad',
      'hcd.antidoping',
      'hcd.calificacion',
      'hcd.idx',
      'hc.created_at as fecha_creacion'
    )
    ->from('historico_clinico as hc')
    ->join('historico_clinico_drogas as hcd', function($join) {
      $join->on('hcd.historico_clinico_id', '=', 'hc.id')->where('hcd.borrado', 0);
    })
    ->where('hc.borrado', 0)->orderBy('hc.created_at', 'desc');

    return DataTables::eloquent($historicoClinico)
    # filtrar por nombre sin importar mayusculas y minusculas
    ->filter(function ($query) use ($request) {
      if ($request->has('search') && $request->input('search.value')) {
        $search = strtolower($request->input('search.value'));
        $query->where(function($q) use ($search) {
          $q->whereRaw('LOWER(hc.nombre) LIKE ?', ["%{$search}%"])
          ->orWhere('hc.curp', 'LIKE', "%{$search}%")
          ->orWhereRaw('LOWER(hc.apellido_paterno) LIKE ?', ["%{$search}%"])
          ->orWhereRaw('LOWER(hc.apellido_materno) LIKE ?', ["%{$search}%"]);
        });
      }
    })
    ->addColumn('acciones', function ($historicoClinico) {
      $historico_id_encriptado = Crypt::encryptString($historicoClinico->id);

      $botones = '';

      $botones .= '<a  class="btn btn-icon rounded-pill btn-success waves-effect waves-light m-1" title="Ver historico clinico" href="' . route('historico-clinico-consultar', ['historico_clinico_id' => $historico_id_encriptado]) . '">' .
                    '<i class="mdi mdi-eye mdi-20px"></i>' .
                  '</a>';
      return $botones;
    })
    ->rawColumns(['acciones'])
    ->make(true);
  }

  public function consultarHistoricoClinico(Request $request){
    if(Auth::user()->usuario_perfil_id == 1 || Auth::user()->usuario_perfil_id == 2 || Auth::user()->usuario_perfil_id == 3 || Auth::user()->usuario_perfil_id == 4 || Auth::user()->usuario_perfil_id == 5 || Auth::user()->usuario_perfil_id == 6){

      # Obtiene el ID desde la URL
      $historico_clinico_id = Crypt::decryptString($request->query('historico_clinico_id'));

      if (!$historico_clinico_id) {
        return redirect()->back()->with('error', 'No se proporcionó un ID de histórico clínico.');
      }

      $view_data['historico_clinico'] = HistoricoClinicoModel::with(
        'historicoClinicoGinecoObstetricos',
        'historicoClinicoContactoEmergencia',
        'historicoClinicoHeredofamiliares',
        'historicoClinicoPersonalesNoPatologicos',
        'historicoClinicoPersonalesPatologicos',
        'historicoClinicoLaborales',
        'historicoClinicoEmpleo',
        'historicoClinicoAparatosSistemas',
        'historicoClinicoExploracionFisica',
        'historicoClinicoDrogas'
      )
      ->where('borrado', 0)->where('id', $historico_clinico_id)
      ->get()->toArray();

      $view_data['usuario_creador_historico_clinico'] = HistoricoClinicoModel::select(
        DB::raw("usuario.nombre || ' ' || usuario.apellido_paterno || ' ' || usuario.apellido_materno AS usuario_nombre_completo"),
        'usuario.cedula_profesional as usuario_cedula_profesional',
        'usuario.registro_ssa as usuario_registro_ssa'
      )
      ->join('usuario', 'usuario.id', '=', 'historico_clinico.elaborado_por_usuario_id')
      ->where('historico_clinico.borrado', 0)
      ->where('historico_clinico.id', $historico_clinico_id)
      ->get()->toArray();

      # Mandamos a la  vista
      return view('content.pages.historicoClinico.crear-historico',['datos_vista' => $view_data]);

    } else {
      return view('content.pages.pages-misc-error');
    }
  }
}