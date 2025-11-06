<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use App\Models\PacienteModel;
use App\Models\RecetaModel;
use App\Models\RecetaMedicamentoModel;
use App\Models\UsuarioAlmacenModel;
use App\Models\RecetaConsumoHistoricoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RecetaController extends Controller
{
  # Retorna la vista de crear una receta nueva
  public function nuevaReceta(Request $request)
  {
    $post = $request->all();

    if(count($post) == 1){
      # Obtiene el ID desde la URL
      $detalle_receta_id = Crypt::decryptString($request->query('detalle_receta_id'));

      $detalle_receta = RecetaModel::select(
        'receta.id as receta_id',
        'usuario.nombre as usuario_creados_nombre',
        'usuario.apellido_paterno as usuario_creador_apellido_p',
        'usuario.apellido_materno as usuario_creador_apellido_m',
        'usuario.registro_ssa as registro_ssa',
        'usuario.cedula_profesional as cedula_profesional',
        'usuario.usuario_perfil_id as usuario_perfil_id',
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
      ->where('receta.id', $detalle_receta_id)
      ->where('usuario.borrado', 0)
      ->where('receta.borrado', 0)
      ->orderBy('receta.created_at', 'desc')->get()->toArray();

      $view_data['detalles_receta'] = $detalle_receta;
    }

    $usuario_almacenes = UsuarioAlmacenModel::select('empresa_id', 'empresa_nombre', 'almacen_id', 'almacen_nombre', 'almacen_codigo')->where('usuario_id', Auth::user()->id)->where('borrado', 0)->get()->toArray();
    $view_data['usuario_almacenes'] = $usuario_almacenes;

    # Perfiles => 1=MEDICO GENERAL ; 2=MEDICO ESPECIALISTA
    # Validamos si el usuario tiene permiso para acceder a esta seccion
    if(Auth::user()->usuario_perfil_id == 1 || Auth::user()->usuario_perfil_id == 2){
      $view_data['pacientes'] = PacienteModel::where('borrado', 0)->select('id', 'nombre', 'apellido_paterno', 'apellido_materno', 'edad')->get()->toArray();

      $lastFolio = RecetaModel::max('id');
      $view_data['folio'] = $lastFolio ? $lastFolio + 1 : 1;

      # Mandamos a la  vista
      return view('content.pages.receta.nueva-receta',['datos_vista' => $view_data]);
    } else {
      return view('content.pages.pages-misc-error');
    }
  }

  # Funcion para guardar los datos de la receta
  public function registrarReceta(Request $request)
  {
    $result = array("error" => false, "msg" => null, 'url' => null, 'receta_id' => null);
    $post = $request->all();
    $post['medicamentos'] = json_decode($request->input('medicamentos'), true);

    $datosPaciente = PacienteModel::select('nombre', 'apellido_paterno', 'apellido_materno')->where('id', $post['receta']['paciente_id'])->first();

    $url = env('CONSUMO_MEDICAMENTOS_HISPATEC');

    # Agrupamos los medicamentos por empresa y almacén
    $grupos = [];
    foreach ($post['medicamentos'] as $item) {
      $clave = $item['empresa_id'] . '-' . $item['almacen_id'];
      $grupos[$clave]['empresa_id'] = $item['empresa_id'];
      $grupos[$clave]['almacen_id'] = $item['almacen_id'];
      $grupos[$clave]['items'][] = [
        "id" => $item["medicamento_id"],
        "codigo" => $item["medicamento_codigo"],
        "nombre" => $item["medicamento_nombre"],
        "uso" => "",
        "unidad" => "",
        "cantidad" => $item["cantidad_solicitada"]
      ];
    }

    # Enviamos un POST por cada grupo empresa/almacén
    foreach ($grupos as $grupo) {

      $jsonData = [
        "fecha" => date('Y-m-d'),
        "solicitanteid" => 159,
        "autorizadorid" => 159,
        "estadoid" => 3,
        "empresaid" => $grupo['empresa_id'],
        "almacenid" => $grupo['almacen_id'],
        "prioridadid" => 1,
        "tipoid" => 1,
        "almacenaltaid" => 1,
        "centrocostoid" => 540,
        "ordencompraid" => "",
        "nombreentregado" => "DR. ".Auth::user()->nombre." ".Auth::user()->apellido_paterno." ".Auth::user()->apellido_materno." > Paciente: ".$datosPaciente->nombre." ".$datosPaciente->apellido_paterno." ".$datosPaciente->apellido_materno,
        "fechaaplicacion" => date('Y-m-d'),
        "items" => $grupo['items']
      ];

      try {
        $response = Http::withoutVerifying()->post($url, $jsonData);

        if (!$response->successful()) {
          $result['error'] = true;
          $result['msg'] = "No fue posible conectarse a la API de Hispatec para la empresa {$grupo['empresa_id']} / almacén {$grupo['almacen_id']}.";
          return response()->json($result);
        }

        $respuestaAPI = $response->json();

        $historicoConsumo = RecetaConsumoHistoricoModel::insertGetId([
          'json_data' => json_encode($jsonData), # Convertir array a JSON string
          'respuesta_api' => json_encode($respuestaAPI), # Convertir array a JSON string
          'created_at' => now()
        ]);

        if ($historicoConsumo == null) {
          $result["error"] = true;
          $result["msg"] = "No fue posible registrar el historico del consumo, intenta de nuevo.";
        }

        if (isset($respuestaAPI['error']) && $respuestaAPI['error'] == true) {
          $result['error'] = true;
          $result['msg'] = "La API de Hispatec devolvió un error para empresa {$grupo['empresa_id']} / almacén {$grupo['almacen_id']}.";
          $result['api_response'] = $respuestaAPI;
          return response()->json($result);
        }

      } catch (\Exception $e) {
        $result['error'] = true;
        $result['msg'] = "Error al intentar comunicarse con la API de Hispatec.";
        $result['return'] = $e->getMessage();
        return response()->json($result);
      }
    }

    # Si todas las APIs se enviaron correctamente, ahora sí guardamos la receta
    DB::connection('pgsql')->beginTransaction();
    try {
      foreach ($post as $key => $value) {
        switch ($key) {
          case "receta":
            $value['created_at'] = now();
            $value['usuario_id'] = Auth::user()->id;

            $receta = RecetaModel::insertGetId($value);

            if ($receta !== null) {
              $result["receta_id"] = $receta;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar la receta, intenta de nuevo.";
            }
          break;

          case "medicamentos":
            if (isset($result["receta_id"]) && is_array($value)) {
              foreach ($value as $medicamento) {
                $medicamento['receta_id'] = $result["receta_id"];
                $medicamento['created_at'] = now();
                RecetaMedicamentoModel::insert($medicamento);
              }
            }
          break;
        }
      }

      if (!$result["error"]) {
        DB::connection('pgsql')->commit();
        $result["msg"] = 'La receta fue registrada correctamente';
      } else {
        DB::connection('pgsql')->rollback();
        $result["msg"] = '¡Lo sentimos! No fue posible registrar información del paciente.';
      }

    } catch (\Exception $e) {
      DB::connection('pgsql')->rollback();
      $result['error'] = true;
      $result['msg'] = "Error al registrar receta en BD.";
      $result['return'] = $e->getMessage();
    }

    return response()->json($result);
  }

  public function recetasPaciente(Request $request){
    $paciente_id = Crypt::decryptString($request->query('paciente_id'));

    # Verifica si el ID existe
    if (!$paciente_id) {
      return redirect()->back()->with('error', 'No se proporcionó un ID de paciente.');
    }

    $view_data['paciente_id'] = $paciente_id;
    $view_data['paciente']['recetas'] = RecetaModel::where('id',$paciente_id)->where('borrado', 0)->get()->toArray();
    $view_data['paciente']['datos_generales'] = PacienteModel::where('id',$paciente_id)->where('borrado', 0)->get()->toArray();

    # Mandamos a la  vista
    return view('content.pages.receta.listado-receta-paciente',['datos_vista' => $view_data]);
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
      'usuario.registro_ssa as registro_ssa',
      'usuario.cedula_profesional as cedula_profesional',
      'usuario.usuario_perfil_id as usuario_perfil_id',
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
      $detalle_receta_id_encriptado = Crypt::encryptString($detalle_receta->id);

      $botones = '';

      // Enlace en la tabla
      $botones .= '<a href="' . route('receta-nueva', ['detalle_receta_id' => $detalle_receta_id_encriptado]) . '" class="btn btn-icon rounded-pill btn-info waves-effect waves-light m-1" title="Ver detalle de la receta">' .
        '<i class="mdi mdi-text-box-check-outline mdi-20px"></i>' .
      '</a>';

      return $botones;
    })
    ->rawColumns(['acciones'])
    ->make(true);
  }

  public function obtenerMedicamentosHispatec(Request $request)
  {
    $validado = $request->validate([
      'empresaid' => 'required|integer',
      'almacenid' => 'required|integer',
      'almacencodigo' => 'required|string',
      'busqueda' => 'sometimes|string'
    ]);

    try {
      $url =  env('API_URL_KUDE') . '/obtenerCatalogoMedicamentosHispatec.php';

      $response = Http::timeout(30)->asForm()->post($url, [
        'empresaid' => $validado['empresaid'],
        'almacenid' => $validado['almacenid'],
        'almacencodigo' => $validado['almacencodigo'],
        'busqueda' => $validado['busqueda'] ?? ''
      ]);

      # Limpia BOM
      $body = $response->body();
      $cleanBody = preg_replace('/^\xEF\xBB\xBF/', '', $body);
      $data = json_decode($cleanBody, true);

      # Si la API de Hispatec retorna error de validación entra
      if (isset($data['success']) && !$data['success'] && isset($data['error']) && strpos($data['error'], 'obligatorio') !== false) {
        return response()->json([
          'error' => true,
          'message' => 'Error de validación en Hispatec',
          'errores' => $data['errores'] ?? [],
          'hispatec_response' => $data
        ], 400);
      }

      # Si hay otro error de Hispatec
      if (isset($data['success']) && !$data['success']) {
        return response()->json([
          'error' => true,
          'message' => 'Error en Hispatec: ' . ($data['error'] ?? 'Error desconocido')
        ], 500);
      }

      return response()->json([
        'error' => false,
        'data' => $data['data'] ?? [],
        'count' => $data['count'] ?? 0,
        'parametros' => $data['parametros'] ?? []
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'error' => true,
        'message' => 'Excepción: ' . $e->getMessage()
      ], 500);
    }
  }
}
