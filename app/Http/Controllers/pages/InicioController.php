<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PacienteModel;
use App\Models\PacienteDatosConsultaModel;
use App\Models\PacienteTipoVisitaModel;
use App\Models\UsuarioModel;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
  public function index()
  {
    $view_data['estadisticas']['pacientesHombres'] = PacienteModel::where('genero', 'M')->where('borrado', 0)->count(); # Total de hombres atendidos
    $view_data['estadisticas']['pacientesMujeres'] = PacienteModel::where('genero', 'F')->where('borrado', 0)->count(); # Total de mujeres atendidas
    $view_data['estadisticas']['enfermedadGeneral'] = PacienteDatosConsultaModel::where('paciente_tipo_visita_id', 1)->where('borrado', 0)->count(); # Total de pacientes que acuden por enfermedad general
    $view_data['estadisticas']['riesgoTrabajo'] = PacienteDatosConsultaModel::where('paciente_tipo_visita_id', 2)->where('borrado', 0)->count(); # Total de pacientes que acuden por riesgo de trabajo
    $view_data['catalogos']['tipo_visita'] = PacienteTipoVisitaModel::where('borrado', 0)->get()->toArray(); # Tipos de la visita al servicio medico

    return view('content.pages.inicio',['datos_vista' => $view_data]);
  }

  public function login()
  {
    return view('content.authentications.login');
  }

  public function autenticar(Request $request)
  {
    $request->validate([
        'correo' => ['required', 'string'],
        'password' => ['required'],
    ]);

    $correoCompleto = $request->input('correo') . env('DOMINIO');

    $ldapAuth = $this->validaLDAP($correoCompleto, $request->input('password'));

    if (!$ldapAuth) {
        return back()->withErrors([
            'correo' => 'El usuario o contraseña no son válidos en el sistema AD.',
        ])->withInput();
    }

    $usuario = UsuarioModel::where('correo', $request->input('correo'))->where('borrado', 0)->first();

    if (!$usuario) {
        return back()->withErrors([
            'correo' => 'El usuario no está registrado o está desactivado en el sistema.',
        ])->withInput();
    }

    Auth::login($usuario);
    $request->session()->regenerate();

    return redirect()->intended('/');
  }

  private function validaLDAP($username, $password)
  {
    $url = env('LDAP_URL');
    $data = [
        'username' => $username,
        'password' => $password
    ];

    // Configura cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Ejecuta la solicitud
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Cierra la conexión cURL
    curl_close($ch);

    if ($httpCode === 200 && $response === "true") {
        return true;
    }

    return false;
  }
}
