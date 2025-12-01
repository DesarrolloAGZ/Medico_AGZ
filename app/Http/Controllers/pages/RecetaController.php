<?php
namespace App\Http\Controllers\pages;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use App\Models\PacienteModel;
use App\Models\RecetaModel;
use App\Models\RecetaMedicamentoModel;
use App\Models\UsuarioAlmacenModel;
use App\Models\RecetaValeHistoricoModel;
use App\Models\RecetaConsumoHistoricoModel;
use App\Models\CatalogoRanchosAgrizarModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class RecetaController extends Controller
{
  # Retorna la vista de crear una receta nueva
  public function nuevaReceta(Request $request)
  {
    $post = $request->all();

    # Obtener todos los empleados APSI
    $urlTodosLosEmpleadosApsi =  env('API_URL_KUDE') . '/obtenTodosLosEmpleadosAPSI.php';
    $response = Http::get($urlTodosLosEmpleadosApsi,[]);
    $response = $response->body();
    $response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
    $response = json_decode($response, true);

    # guardamos los empleados en la variable de vista
    $view_data['todos_empleados_apsi'] = $response['response'];

    if(count($post) == 1){
      # Obtiene el ID desde la URL
      $detalle_receta_id = Crypt::decryptString($request->query('detalle_receta_id'));

      $detalle_receta = RecetaModel::select(
        'receta.id as receta_id',
        'usuario.nombre as usuario_creados_nombre',
        'usuario.apellido_paterno as usuario_creador_apellido_p',
        'usuario.apellido_materno as usuario_creador_apellido_m',
        'usuario.registro_ssa',
        'usuario.cedula_profesional',
        'usuario.usuario_perfil_id',
        'paciente.nombre as paciente_nombre',
        'paciente.apellido_paterno as paciente_apellido_p',
        'paciente.apellido_materno as paciente_apellido_m',
        'paciente.edad as paciente_edad',
        'receta.medicamento_indicaciones as medicamento',
        'receta.recomendaciones',
        'receta.created_at as fecha_creacion',
        DB::raw("string_agg(receta_medicamento.medicamento_nombre || ' -> Cantidad: ' || receta_medicamento.cantidad_solicitada || '', ' || ') as medicamentos_txt")
      )
      ->join('usuario', 'usuario.id', '=', 'receta.usuario_id')
      ->join('paciente', 'paciente.id', '=', 'receta.paciente_id')
      ->join('receta_medicamento', 'receta_medicamento.receta_id', '=', 'receta.id')
      ->where('receta.id', $detalle_receta_id)
      ->where('usuario.borrado', 0)
      ->where('receta_medicamento.borrado', 0)
      ->where('receta.borrado', 0)
      ->groupBy(
        'receta.id',
        'usuario.nombre',
        'usuario.apellido_paterno',
        'usuario.apellido_materno',
        'usuario.registro_ssa',
        'usuario.cedula_profesional',
        'usuario.usuario_perfil_id',
        'paciente.nombre',
        'paciente.apellido_paterno',
        'paciente.apellido_materno',
        'paciente.edad',
        'receta.medicamento_indicaciones',
        'receta.recomendaciones',
        'receta.created_at'
      )->get()->toArray();

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
    $token = Helpers::obtenerToken();
    if (!$token) {
      return response()->json(['error' => true, 'msg' => 'No se pudo obtener token'], 500);
    }

    $result = ["error" => false, "msg" => null, 'url' => null, 'receta_id' => null];
    $post = $request->all();
    $post['medicamentos'] = json_decode($request->input('medicamentos'), true);

    $validaEmpleadoRegistradoEnSistemaMedico = PacienteModel::where('gafete', $post['empleado']['gafete'])->where('borrado', 0)->first();

    $post['empleado']['created_at'] = now();
    if(!$validaEmpleadoRegistradoEnSistemaMedico){
      $registrarEmpleadoAlServicioMedico = PacienteModel::insertGetId($post['empleado']);
      if(!$registrarEmpleadoAlServicioMedico){
        return response()->json(['error' => true, 'msg' => 'No fue posible registrar al empleado en el sistema médico automaticamente'], 500);
      } else {
        $datosPaciente = $this->obtenerDatosPaciente($registrarEmpleadoAlServicioMedico);
      }
    } else {
      $datosPaciente = $this->obtenerDatosPaciente($validaEmpleadoRegistradoEnSistemaMedico->id);
    }
    $post['receta']['paciente_id'] = $validaEmpleadoRegistradoEnSistemaMedico ? $validaEmpleadoRegistradoEnSistemaMedico->id : $registrarEmpleadoAlServicioMedico;

    # Agrupamos medicamentos por empresa y almacén
    $grupos = $this->agruparMedicamentos($post['medicamentos']);

    # Procesamos cada grupo (vale y consumo)
    foreach ($grupos as $grupo) {
      $respuesta = $this->procesarGrupo($grupo, $token, $datosPaciente);

      if ($respuesta['error']) {
        return response()->json($respuesta);
      }
    }

    # Guardamos receta en BD
    $respuestaBD = $this->guardarRecetaBD($post, $result);
    return response()->json($respuestaBD);
  }

  private function obtenerDatosPaciente($pacienteId){
    return PacienteModel::select('nombre', 'apellido_paterno', 'apellido_materno', 'gafete')->where('id', $pacienteId)->first();
  }

  private function agruparMedicamentos($medicamentos){
    $grupos = [];
    foreach ($medicamentos as $item) {
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
    return $grupos;
  }

  private function crearJsonVale($grupo, $paciente){
    /*
    # Descomentar para obtener centro de costos dinámico del APSI
    $gafete = $paciente->gafete;
    $urlDatosEmpleadoApsi =  env('API_URL_KUDE') . '/buscaEmpleadoAPSI.php';

    $response = Http::get($urlDatosEmpleadoApsi, ['numeroEmpleado' => $gafete]);
    $response = $response->body();
    $response = preg_replace('/^\xEF\xBB\xBF/', '', $response);
    $response = json_decode($response, true);

    $centroCostosIdApsi = trim($response['response']['centro']);
    */
    $centroCostosIdApsi = '';

    #centro de costos fijo por el momento por usuario logueado
    $centroCostosCatalogo = CatalogoRanchosAgrizarModel::where('id', Auth::user()->catalogo_ranchos_agrizar_id)->where('borrado', 0)->first()->centro_costo;


    return [
      "fecha" => date('Y-m-d'),
      "solicitanteid" => 159,
      "autorizadorid" => 159,
      "estadoid" => 3,
      "empresaid" => $grupo['empresa_id'],
      "almacenid" => $grupo['almacen_id'],
      "prioridadid" => 1,
      "tipoid" => 1,
      "almacenaltaid" => 1,
      "centrocostoid" => $centroCostosIdApsi,
      "centrocostocodigo" => $centroCostosCatalogo,
      "ordencompraid" => "",
      "nombreentregado" => $this->nombreCompleto($paciente),
      "fechaaplicacion" => date('Y-m-d'),
      "items" => $grupo['items']
    ];
  }

  private function crearJsonConsumo($valeId, $paciente, $centroCostos){
    return [
      "moveuserid" => 59,
      "passhispatec" => "MarJim2024",
      "valeid" => $valeId,
      "aplicationdate" => date('Y-m-d'),
      "receptionname" => $this->nombreCompleto($paciente),
      "signature" => "",
      "observations" => "Consumo generado desde: Sistema del Servicio Medico -> Centro de costos: ".$centroCostos." -> Vale id: ".$valeId
    ];
  }

  private function nombreCompleto($paciente)
  {
    return "Dr. ".Auth::user()->nombre." ".Auth::user()->apellido_paterno." ".Auth::user()->apellido_materno." > Paciente: ".$paciente->nombre." ".$paciente->apellido_paterno." ".$paciente->apellido_materno;
  }

  private function postAPI($url, $json, $token){
    $response = Http::withHeaders([
      'Authorization' => 'Bearer ' . $token,
      'Accept' => 'application/json',
      'Content-Type'  => 'application/json'
    ])->withoutVerifying()->send('POST', $url, ['json' => $json]);

    if (!$response->successful()) {
      return [
        'error' => true,
        'msg' => "No fue posible conectar con la API",
      ];
    }

    $data = $response->json();

    if (isset($data['error']) && $data['error'] == true) {
      return [
        'error' => true,
        'msg' => "La API devolvió un error",
        'data' => $data
      ];
    }

    return ['error' => false, 'data' => $data];
  }

  private function guardarRecetaBD($post, $result)  {
    DB::connection('pgsql')->beginTransaction();
    try {
      foreach ($post as $key => $value) {
        if ($key === "receta") {
          $value['created_at'] = now();
          $value['usuario_id'] = Auth::user()->id;

          $result["receta_id"] = RecetaModel::insertGetId($value);

          if (!$result["receta_id"]) {
            return ['error' => true, 'msg' => "No fue posible registrar la receta"];
          }
        }
        if ($key === "medicamentos") {
          foreach ($value as $medicamento) {
            $medicamento['receta_id'] = $result["receta_id"];
            $medicamento['created_at'] = now();
            RecetaMedicamentoModel::insert($medicamento);
          }
        }
      }
      DB::connection('pgsql')->commit();
      return [
        "error" => false,
        "msg" => "La receta fue registrada correctamente",
        "receta_id" => $result["receta_id"]
      ];
    } catch (\Exception $e) {
      DB::connection('pgsql')->rollback();
      return ['error' => true,'msg' => "Error al registrar receta en BD",'return' => $e->getMessage()];
    }
  }

  private function procesarGrupo($grupo, $token, $datosPaciente){
    try {
      # Generar vale
      $jsonVale = $this->crearJsonVale($grupo, $datosPaciente);
      $respuestaVale = $this->postAPI(env('GENERA_VALE_RD'), $jsonVale, $token);

      if ($respuestaVale['error']) {
        return $respuestaVale;
      }

      # Guardar histórico del vale
      RecetaValeHistoricoModel::insert([
          'json_data' => json_encode($jsonVale),
          'respuesta_api' => json_encode($respuestaVale['data']),
          'created_at' => now()
      ]);

      # Generar consumo en Hispatec
      $jsonConsumo = $this->crearJsonConsumo($respuestaVale['data']['valeid'], $datosPaciente, $jsonVale['centrocostocodigo']);
      $respuestaConsumo = $this->postAPI(env('GENERA_CONSUMO_HISPATEC'), $jsonConsumo, $token);

      if ($respuestaConsumo['error']) {
          return $respuestaConsumo;
      }

      # Guardar histórico consumo
      RecetaConsumoHistoricoModel::insert([
          'json_data' => json_encode($jsonConsumo),
          'respuesta_api' => json_encode($respuestaConsumo['data']),
          'created_at' => now()
      ]);

      return ['error' => false];

    } catch (\Exception $e) {
      return ['error' => true,'msg' => "Error al comunicarse con las APIs",'return' => $e->getMessage()];
    }
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
      'receta.medicamento_indicaciones as indicaciones_medicamento',
      'receta.recomendaciones as recomendaciones',
      'receta.created_at as fecha_creacion'
    )
    ->join('usuario', 'usuario.id', '=', 'receta.usuario_id')
    ->join('paciente', 'paciente.id', '=', 'receta.paciente_id')
    ->where('receta.paciente_id', $pacienteId)
    ->where('usuario.borrado', 0)
    ->where('receta.borrado', 0)
    ->orderBy('receta.created_at', 'desc');

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
      $url_obtener_medicamento =  env('API_URL_KUDE') . '/obtenerCatalogoMedicamentosHispatec.php';

      $response = Http::timeout(30)->asForm()->post($url_obtener_medicamento, [
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
