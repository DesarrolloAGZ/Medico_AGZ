<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/login', 'App\Http\Controllers\pages\InicioController@login')->name('inicio-sesion');
Route::post('/login', 'App\Http\Controllers\pages\InicioController@autenticar')->name('procesar-login');
// Route::post('/valida-credenciales', 'App\Http\Controllers\pages\InicioController@validaCredenciales')->name('valida-credenciales');
// Ruta de logout
Route::post('/logout', function () {
  Auth::logout(); // Cierra la sesión del usuario
  return redirect('/login'); // Redirige a la página de login
})->name('logout');

# Proteccion de rutas si no esta autenticado
Route::middleware(['auth'])->group(function () {

  # Ruta para pagina principal.
  Route::get('/', 'App\Http\Controllers\pages\InicioController@index')->name('pantalla-inicio');

  # Grupo de rutas para pacientes.
  Route::prefix('pacientes')->group(function () {

    # Ruta para la vista de un nuevo paciente
    Route::get('/nuevo', 'App\Http\Controllers\pages\PacientesController@nuevoPaciente')->name('nuevo-paciente');

    # Ruta para la vista de registrar datos en el expediente
    Route::get('/registrar-valoracion', 'App\Http\Controllers\pages\PacientesController@registrarValoracionPaciente')->name('registrar-valoracion-paciente');

    # Ruta para la vista de ver los pacientes en lista
    Route::get('/consultar', 'App\Http\Controllers\pages\PacientesSeguimientoController@listadoPacientes')->name('listado-paciente');

    # Ruta para la vista de ver el expediente de los pacientes
    Route::get('/expediente', 'App\Http\Controllers\pages\PacientesSeguimientoController@expedientePacientes')->name('listado-expediente-paciente');

    # Ruta para la vista de las consultas del paciente seleccionado
    Route::get('/detalle-consulta', 'App\Http\Controllers\pages\PacientesSeguimientoController@detalleConsultaPaciente')->name('detalle-consulta-paciente');

    # Ruta para la vista de todas las consultas
    Route::get('/buscar-consulta', 'App\Http\Controllers\pages\PacientesSeguimientoController@todasLasConsultas')->name('listado-consultas');

    # Ruta para la vista de todas las consultas mandando el tipo de visita
    // Route::get('/buscar-consulta?tipo_visita=', 'App\Http\Controllers\pages\PacientesSeguimientoController@todasLasConsultas')->name('listado-consultas');


    # ****************************************************************************************
    # ****************************************************************************************


    # Grupo de rutas para APIS de pacientes.
    Route::prefix('api')->group(function () {

      # Ruta para consultar paciente \ busca el empleado en el APSI
      Route::post('/consultar', 'App\Http\Controllers\pages\PacientesController@consultarPacienteApsi')->name('consultar-paciente');
      # Ruta para registrar el paciente
      Route::post('/registrar', 'App\Http\Controllers\pages\PacientesController@registrarPaciente')->name('registrar-paciente');
      # Ruta para registrar la valoracion el paciente
      Route::post('/guardar-valoracion', 'App\Http\Controllers\pages\PacientesController@guardarValoracionPaciente')->name('guardar-valoracion-paciente');
      # Ruta para obtener el listado de expedientes
      Route::post('/obtener-lista-pacientes', 'App\Http\Controllers\pages\PacientesSeguimientoController@obtenerListadoPacientes')->name('obtener-lista-pacientes');
      # Ruta para obtener las consultas del paciente para la tabla
      Route::post('/obtener-lista-consultas-paciente', 'App\Http\Controllers\pages\PacientesSeguimientoController@obtenerListadoConsultasPaciente')->name('obtener-lista-consultas-paciente');
      # Ruta para registrar la nota en el expediente
      Route::post('/registrar-nota', 'App\Http\Controllers\pages\PacientesController@registrarNota')->name('registrar-nota');
      # Ruta para obtener las recetas del paciente para la tabla
      Route::post('/obtener-lista-recetas-paciente', 'App\Http\Controllers\pages\PacientesSeguimientoController@obtenerListadoRecetasPaciente')->name('obtener-lista-recetas-paciente');
      # Ruta para registrar la nota en el expediente
      Route::post('/buscar-cie', 'App\Http\Controllers\pages\PacientesController@buscarCie')->name('buscar-cie');
      # Ruta para obtener el listado de consultas
      Route::post('/obtener-lista-todas-consultas', 'App\Http\Controllers\pages\PacientesSeguimientoController@obtenerListadoTodasConsultas')->name('obtener-lista-pacientes');
    });

  });

  Route::prefix('receta')->group(function () {
    # Ruta para la vista de crear receta nueva
    Route::get('/nueva', 'App\Http\Controllers\pages\RecetaController@nuevaReceta')->name('receta-nueva');

    # Ruta para la vista de ver el listado de recetas del paciente
    Route::get('/listado', 'App\Http\Controllers\pages\RecetaController@recetasPaciente')->name('listado-recetas');


    # ****************************************************************************************
    # ****************************************************************************************


    # Grupo de rutas para APIS de recetas.
    Route::prefix('api')->group(function () {
      # Ruta para registrar la receta
      Route::post('/registrar-receta', 'App\Http\Controllers\pages\RecetaController@registrarReceta')->name('registrar-receta');
    });

  });

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
