<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use App\Models\PacienteModel;
use App\Models\RecetaModel;
use Illuminate\Support\Facades\Auth;

class RecetaController extends Controller
{
  # Retorna la vista de crear una receta nueva
  public function nuevaReceta(Request $request)
  {
    $post = $request->all();

    $id = urldecode($request->id);
    $medicamento = urldecode($request->medicamento);
    $recomendaciones = urldecode($request->recomendaciones);
    $paciente_id = urldecode($request->paciente_id);
    $paciente_nombre = urldecode($request->paciente_nombre);
    $paciente_apellido_p = urldecode($request->paciente_apellido_p);
    $paciente_apellido_m = urldecode($request->paciente_apellido_m);
    $paciente_edad = urldecode($request->paciente_edad);

    # Validamos si el usuario tiene permiso para acceder a esta seccion
    if(Auth::user()->usuario_perfil_id == 1 || Auth::user()->usuario_perfil_id == 2){
      $view_data['pacientes'] = PacienteModel::where('borrado', 0)->select('id', 'nombre', 'apellido_paterno', 'apellido_materno', 'edad')->get()->toArray();

      $lastFolio = RecetaModel::max('id');
      $view_data['folio'] = $lastFolio ? $lastFolio + 1 : 1;

      $view_data['receta_existente'] = [
          'medicamento' => $medicamento,
          'recomendaciones' => $recomendaciones,
          'id' => $id,
          'paciente_id' => $paciente_id,
          'paciente_nombre' => $paciente_nombre,
          'paciente_apellido_p' => $paciente_apellido_p,
          'paciente_apellido_m' => $paciente_apellido_m,
          'paciente_edad' => $paciente_edad,
      ];

      # Mandamos a la  vista
      return view('content.pages.nueva-receta',['datos_vista' => $view_data]);
    } else {
      return view('content.pages.pages-misc-error');
    }
  }

  # Funcion para guardar los datos de la receta
  public function registrarReceta(Request $request)
  {
    # Parametros iniciales para la respuesta
    $result = array("error" => false, "msg" => null, 'url' => null, 'receta_id' => null);
    # Obtenemos el POST
    $post = $request->all();
    // dd($post);
    # Iniciamos transaccion de BD
    DB::connection('pgsql')->beginTransaction();
    try {
      # Iniciamos con el guardamos los datos obtenidos del formulario.
      foreach ($post as $key => $value)
      {
        switch ($key)
        {
          # Guardamos los datos de la receta
          case "receta":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';

            # Usuario id que registra la nota
            $value['usuario_id'] = Auth::user()->id;

            #insertamos los valores en la tabla del paciente
           $receta = RecetaModel::insertGetId($value);

            if($receta !== null){
              $result["receta_id"] = $receta;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar la receta, intenta de nuevo.";
            }
          break;
        }
      }

      # Si no existe error al guardar el registro de la receta entra
      if (!$result["error"])
      {
        # Si todo esta correcto hacemos el commit de la transaccion
        DB::connection('pgsql')->commit();
        $result['error'] = false;
        $result["msg"] = 'La receta fue registrada correctamente';
      } else {
        # Si existe un error no guardamos en la base de datos
        DB::connection('pgsql')->rollback();
        $result['error'] = true;
        $result["msg"] = '¡Lo sentimos! No fue posible registrar información del paciente.';
      }
    } catch (\Exception $e) {
      # Si existe un error no guardamos en la base de datos
      DB::connection('pgsql')->rollback();
      $result['error'] = true;
      $result["msg"] = "¡Lo sentimos! No fue posible registrar la receta favor revisa que no existan campos vacíos en la captura. Inténtalo de nuevo y si el problema persiste contacta con el equipo de desarrollo.";
      $result['return'] = $e->getMessage();
    }
    return response()->json($result);
  }

  public function recetasPaciente(Request $request){
    $view_data['data'] = '';

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
      # buscar search[value]
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
