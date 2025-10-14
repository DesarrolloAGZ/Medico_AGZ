<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoricoClinicoModel;
use App\Models\HistoricoClinicoGinecoObstetricosModel;
use App\Models\HistoricoClinicoContactoEmergenciaModel;
use App\Models\HistoricoClinicoHeredofamiliaresModel;
use App\Models\HistoricoClinicoPersonalesNoPatologicosModel;
use App\Models\HistoricoClinicoPersonalesPatologicosModel;
use App\Models\HistoricoClinicoLaboralesModel;
use App\Models\HistoricoClinicoEmpleoModel;
use App\Models\HistoricoClinicoAparatosSistemasModel;
use App\Models\HistoricoClinicoExploracionFisicaModel;
use App\Models\HistoricoClinicoDrogasModel;

class HistoricoClinicoController extends Controller
{
  # Retorna la vista de crear una receta nueva
  public function crearHistorico(Request $request)
  {
    # Perfiles => 5=PSICOLOGO
    # Si el usuario logueado tiene el id de perfil 5 (psicologo) entra
    if(Auth::user()->usuario_perfil_id != 5){
      $view_data = [];
      # Mandamos a la  vista
      return view('content.pages.historicoClinico.crear-historico', ['datos_vista' => $view_data]);
    } else {
      return view('content.pages.pages-misc-error');
    }
  }

  public function registrarHistoricoClinico(Request $request){
    # Parametros iniciales para la respuesta
    $result = array("error" => false, "msg" => null, 'url' => null, 'historico_clinico_id' => null);
    # Obtenemos el POST
    $post = $request->all();

    # Iniciamos transaccion de BD
    DB::connection('pgsql')->beginTransaction();
    try {
      $array_ids = array();
      # Iniciamos con el guardamos los datos obtenidos del formulario.
      foreach ($post as $key => $value)
      {
        # Guardamos los datos del historico clinico
        switch ($key)
        {
          case "historico_clinico":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';

            $historico_clinico = HistoricoClinicoModel::insertGetId($value);

            if($historico_clinico !== null){
              $array_ids["historico_clinico_id"] = $historico_clinico;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos generales del histórico clínico, intenta de nuevo.";
            }
          break;

          case "historico_clinico_gineco_obstetricos":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';
            $value['historico_clinico_id'] = $array_ids["historico_clinico_id"];

            $historico_clinico_gineco_obstetricos = HistoricoClinicoGinecoObstetricosModel::insertGetId($value);
            if($historico_clinico_gineco_obstetricos !== null){
              $array_ids["historico_clinico_gineco_obstetricos_id"] = $historico_clinico_gineco_obstetricos;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos gineco obstetricos del histórico clínico, intenta de nuevo.";
            }
          break;

          case "historico_clinico_contacto_emergencia":
            # Iterar sobre cada contacto de emergencia
            foreach ($value as $index => $contacto) {
              # Asignamos la fecha de registro
              $contacto['created_at'] = 'now()';
              $contacto['historico_clinico_id'] = $array_ids["historico_clinico_id"];

              $historico_clinico_contacto_emergencia = HistoricoClinicoContactoEmergenciaModel::insertGetId($contacto);

              if($historico_clinico_contacto_emergencia !== null){
                $array_ids["historico_clinico_contacto_emergencia_id"] = $historico_clinico_contacto_emergencia;
              } else {
                $result["error"] = true;
                $result["msg"] = "No fue posible registrar los datos de contacto de emergencia del histórico clínico, intenta de nuevo.";
              }
            }
          break;

          case "historico_clinico_heredofamiliares":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';
            $value['historico_clinico_id'] = $array_ids["historico_clinico_id"];

            $historico_clinico_heredofamiliares = HistoricoClinicoHeredofamiliaresModel::insertGetId($value);
            if($historico_clinico_heredofamiliares !== null){
              $array_ids["historico_clinico_heredofamiliares_id"] = $historico_clinico_heredofamiliares;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos heredofamiliares del histórico clínico, intenta de nuevo.";
            }
          break;

          case "historico_clinico_personales_no_patologicos":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';
            $value['historico_clinico_id'] = $array_ids["historico_clinico_id"];

            $historico_clinico_personales_no_patologicos = HistoricoClinicoPersonalesNoPatologicosModel::insertGetId($value);
            if($historico_clinico_personales_no_patologicos !== null){
              $array_ids["historico_clinico_personales_no_patologicos_id"] = $historico_clinico_personales_no_patologicos;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos personales no patológicos del histórico clínico, intenta de nuevo.";
            }
          break;

          case "historico_clinico_personales_patologicos":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';
            $value['historico_clinico_id'] = $array_ids["historico_clinico_id"];

            $historico_clinico_personales_patologicos = HistoricoClinicoPersonalesPatologicosModel::insertGetId($value);
            if($historico_clinico_personales_patologicos !== null){
              $array_ids["historico_clinico_personales_patologicos_id"] = $historico_clinico_personales_patologicos;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos personales patológicos del histórico clínico, intenta de nuevo.";
            }
          break;

          case "historico_clinico_laborales":
            # Iterar sobre cada antecedente laboral
            foreach ($value as $index => $laboral) {
              # Asignamos la fecha de registro
              $laboral['created_at'] = 'now()';
              $laboral['historico_clinico_id'] = $array_ids["historico_clinico_id"];

              $laboral['accidentes'] = (isset($laboral['accidentes']) && $laboral['accidentes'] == 'on') ? 1 : 0;
              $laboral['enfermedad'] = (isset($laboral['enfermedad']) && $laboral['enfermedad'] == 'on') ? 1 : 0;
              $laboral['biologicos'] = (isset($laboral['biologicos']) && $laboral['biologicos'] == '1') ? 1 : 0;
              $laboral['quimicos'] = (isset($laboral['quimicos']) && $laboral['quimicos'] == '1') ? 1 : 0;
              $laboral['fisicos'] = (isset($laboral['fisicos']) && $laboral['fisicos'] == '1') ? 1 : 0;
              $laboral['ergonomicos'] = (isset($laboral['ergonomicos']) && $laboral['ergonomicos'] == '1') ? 1 : 0;

              $historico_clinico_laborales = HistoricoClinicoLaboralesModel::insertGetId($laboral);
              if($historico_clinico_laborales !== null){
                $array_ids["historico_clinico_laborales_id"] = $historico_clinico_laborales;
              } else {
                $result["error"] = true;
                $result["msg"] = "No fue posible registrar los datos laborales del histórico clínico, intenta de nuevo.";
              }
            }
          break;

          case "historico_clinico_empleo":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';
            $value['historico_clinico_id'] = $array_ids["historico_clinico_id"];

            $historico_clinico_empleo = HistoricoClinicoEmpleoModel::insertGetId($value);
            if($historico_clinico_empleo !== null){
              $array_ids["historico_clinico_empleo_id"] = $historico_clinico_empleo;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos del empleo del histórico clínico, intenta de nuevo.";
            }
          break;

          case "historico_clinico_aparatos_sistemas":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';
            $value['historico_clinico_id'] = $array_ids["historico_clinico_id"];

            $value['sintomas_generales'] = (isset($value['sintomas_generales']) && $value['sintomas_generales'] == 'on') ? 1 : 0;
            $value['aparato_digestivo'] = (isset($value['aparato_digestivo']) && $value['aparato_digestivo'] == 'on') ? 1 : 0;
            $value['aparato_respiratorio'] = (isset($value['aparato_respiratorio']) && $value['aparato_respiratorio'] == 'on') ? 1 : 0;
            $value['cardiovascular'] = (isset($value['cardiovascular']) && $value['cardiovascular'] == 'on') ? 1 : 0;
            $value['urogenital'] = (isset($value['urogenital']) && $value['urogenital'] == 'on') ? 1 : 0;
            $value['musculoesqueletico'] = (isset($value['musculoesqueletico']) && $value['musculoesqueletico'] == 'on') ? 1 : 0;
            $value['endocrino'] = (isset($value['endocrino']) && $value['endocrino'] == 'on') ? 1 : 0;
            $value['hematopoyetico'] = (isset($value['hematopoyetico']) && $value['hematopoyetico'] == 'on') ? 1 : 0;
            $value['nervioso'] = (isset($value['nervioso']) && $value['nervioso'] == 'on') ? 1 : 0;
            $value['piel_faneras'] = (isset($value['piel_faneras']) && $value['piel_faneras'] == 'on') ? 1 : 0;

            $historico_clinico_aparatos_sistemas = HistoricoClinicoAparatosSistemasModel::insertGetId($value);
            if($historico_clinico_aparatos_sistemas !== null){
              $array_ids["historico_clinico_aparatos_sistemas_id"] = $historico_clinico_aparatos_sistemas;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos del interrogatorio por aparatos y sistemas del histórico clínico, intenta de nuevo.";
            }
          break;

          case "historico_clinico_exploracion_fisica":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';
            $value['historico_clinico_id'] = $array_ids["historico_clinico_id"];

            $value['tatuajes'] = (isset($value['tatuajes']) && $value['tatuajes'] == 'on') ? 1 : 0;

            $historico_clinico_exploracion_fisica = HistoricoClinicoExploracionFisicaModel::insertGetId($value);
            if($historico_clinico_exploracion_fisica !== null){
              $array_ids["historico_clinico_exploracion_fisica_id"] = $historico_clinico_exploracion_fisica;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos de exploración física del histórico clínico, intenta de nuevo.";
            }
          break;

          case "historico_clinico_drogas":
            # Asignamos la fecha de registro
            $value['created_at'] = 'now()';
            $value['historico_clinico_id'] = $array_ids["historico_clinico_id"];

            $value['antidoping'] = (isset($value['antidoping']) && $value['antidoping'] == 'on') ? 1 : 0;

            $historico_clinico_drogas = HistoricoClinicoDrogasModel::insertGetId($value);
            if($historico_clinico_drogas !== null){
              $array_ids["historico_clinico_drogas_id"] = $historico_clinico_drogas;
            } else {
              $result["error"] = true;
              $result["msg"] = "No fue posible registrar los datos de drogas del histórico clínico, intenta de nuevo.";
            }
          break;
        }
      }

      # Si no existe error al guardar el registro del historico clinico entra
      if (!$result["error"])
      {
        # Si todo esta correcto hacemos el commit de la transaccion
        DB::connection('pgsql')->commit();
        $result['error'] = false;
        $result["historico_clinico_id"] = $array_ids["historico_clinico_id"];
        $result["msg"] = 'El histórico clínico fue registrado correctamente';
        $result["url"] = '/historia_clinica/crear';
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
      $result["msg"] = "¡Lo sentimos!, No fue posible registrar el historico clínico favor revisa que no existan campos vacíos en la captura. Inténtalo de nuevo y si el problema persiste contacta con el equipo de desarrollo.";
      $result['return'] = $e->getMessage();
    }

    return response()->json($result);
  }
}
