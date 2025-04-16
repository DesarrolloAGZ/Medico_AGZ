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
    $correo = $request->input('correo');
    if (!str_contains($correo, '@agrizar.com')) {
      # Concatenamos el dominio de la empresa
      $correo .= env('DOMINIO');
    }

    # Validar el correo ya con el dominio añadido
    $request->merge(['correo' => $correo]); # Actualizamos el valor de correo en el request

    $request->validate([
        'correo' => ['required', 'email'],
        'password' => ['required'],
    ], [
        'correo.email' => 'El campo correo debe ser una dirección de correo electrónico válida.',
    ]);

    # Credenciales ingresadas por el usuario
    $credenciales = [
        'correo' => $request->input('correo'),
        'password' => $request->input('password'),
    ];

    # Ahora validamos en LDAP si el usuario está activo
    $ldapAuth = $this->validaLDAP($credenciales['correo'], $credenciales['password']);

    # Si la respuesta es false indica que no existen las credenciales en el AD
    // if (!$ldapAuth) {
    //     return back()->withErrors([
    //         'correo' => 'El correo proporcionado no está registrado o activo en el sistema AD. Si es un nuevo usuario, por favor contacte con el administrador para validar su cuenta.',
    //     ])->withInput();
    // }

    # Verificar si el usuario está activo en la base de datos del sistema
    $usuarioActivo = UsuarioModel::where('correo', $credenciales['correo'])->where('borrado',0)->first();

    # Verificar si el usuario existe y si no está borrado logicamente en la DB
    if ($usuarioActivo) {
      # Intentar la autenticación de usuario en Laravel
      if (Auth::attempt($credenciales)) {
          $request->session()->regenerate();
          return redirect()->intended('/');
      }
    } else {
      return back()->withErrors([
        'correo' => 'El correo proporcionado no está activo en el sistema. Por favor contacte con el administrador para validar su cuenta.',
      ])->withInput();
    }

    return back()->withErrors([
        'correo' => 'Correo o contraseña incorrectos.',
    ])->withInput();
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
