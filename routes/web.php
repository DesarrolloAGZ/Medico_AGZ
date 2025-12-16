<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/login', 'App\Http\Controllers\pages\InicioController@login')->name('inicio-sesion');
Route::post('/login', 'App\Http\Controllers\pages\InicioController@autenticar')->name('procesar-login');

# Ruta de logout
Route::post('/logout', function () {
  Auth::logout(); # Cierra la sesión del usuario
  return redirect('/login'); # Redirige a la página de login
})->name('logout');

# Proteccion de rutas si no esta autenticado
Route::middleware(['auth'])->group(function () {

  Route::get('/', 'App\Http\Controllers\pages\InicioController@index')->name('pantalla-inicio');

  Route::prefix('pacientes')->group(function () {
    Route::get('/nuevo', 'App\Http\Controllers\pages\PacientesController@nuevoPaciente')->name('nuevo-paciente');
    Route::get('/registrar-valoracion', 'App\Http\Controllers\pages\PacientesController@registrarValoracionPaciente')->name('registrar-valoracion-paciente');
    Route::get('/consultar', 'App\Http\Controllers\pages\PacientesSeguimientoController@listadoPacientes')->name('listado-paciente');
    Route::get('/expediente', 'App\Http\Controllers\pages\PacientesSeguimientoController@expedientePacientes')->name('listado-expediente-paciente');
    Route::get('/detalle-consulta', 'App\Http\Controllers\pages\PacientesSeguimientoController@detalleConsultaPaciente')->name('detalle-consulta-paciente');
    Route::get('/buscar-consulta', 'App\Http\Controllers\pages\PacientesSeguimientoController@todasLasConsultas')->name('listado-consultas');

    # ****************************************************************************************
    # ****************************************************************************************

    Route::prefix('api')->group(function () {
      Route::post('/consultar', 'App\Http\Controllers\pages\PacientesController@consultarPacienteApsi')->name('consultar-paciente');
      Route::post('/registrar', 'App\Http\Controllers\pages\PacientesController@registrarPaciente')->name('registrar-paciente');
      Route::post('/guardar-valoracion', 'App\Http\Controllers\pages\PacientesController@guardarValoracionPaciente')->name('guardar-valoracion-paciente');
      Route::post('/obtener-lista-pacientes', 'App\Http\Controllers\pages\PacientesSeguimientoController@obtenerListadoPacientes')->name('obtener-lista-pacientes');
      Route::post('/obtener-lista-consultas-paciente', 'App\Http\Controllers\pages\PacientesSeguimientoController@obtenerListadoConsultasPaciente')->name('obtener-lista-consultas-paciente');
      Route::post('/registrar-nota', 'App\Http\Controllers\pages\PacientesController@registrarNota')->name('registrar-nota');
      Route::post('/obtener-lista-recetas-paciente', 'App\Http\Controllers\pages\RecetaController@obtenerListadoRecetasPaciente')->name('obtener-lista-recetas-paciente');
      Route::post('/buscar-cie', 'App\Http\Controllers\pages\PacientesController@buscarCie')->name('buscar-cie');
      Route::post('/obtener-lista-todas-consultas', 'App\Http\Controllers\pages\PacientesSeguimientoController@obtenerListadoTodasConsultas')->name('obtener-lista-pacientes');
    });

  });

  Route::prefix('receta')->group(function () {
    Route::get('/nueva', 'App\Http\Controllers\pages\RecetaController@nuevaReceta')->name('receta-nueva');
    Route::get('/listado', 'App\Http\Controllers\pages\RecetaController@recetasPaciente')->name('listado-recetas');

    # ****************************************************************************************
    # ****************************************************************************************

    Route::prefix('api')->group(function () {
      Route::post('/registrar-receta', 'App\Http\Controllers\pages\RecetaController@registrarReceta')->name('registrar-receta');
      Route::post('/obtener-catalogo-medicamentos-hispatec', 'App\Http\Controllers\pages\RecetaController@obtenerMedicamentosHispatec')->name('obtener-catalogo-medicamentos-hispatec');
    });

  });

  Route::prefix('historia_clinica')->group(function () {
    Route::get('/crear', 'App\Http\Controllers\pages\HistoricoClinicoController@crearHistorico')->name('historia-clinica-crear');
    Route::get('/listado', 'App\Http\Controllers\pages\HistoricoClinicoSeguimientoController@listadoHistoricos')->name('historia-clinica-listado');
    Route::get('/consultar', 'App\Http\Controllers\pages\HistoricoClinicoSeguimientoController@consultarHistoricoClinico')->name('historico-clinico-consultar');

    # ****************************************************************************************
    # ****************************************************************************************

    Route::prefix('api')->group(function () {
      Route::post('/registrar-historico', 'App\Http\Controllers\pages\HistoricoClinicoController@registrarHistoricoClinico')->name('registrar-historico');
      Route::post('/obtener-lista-historicos-clinicos', 'App\Http\Controllers\pages\HistoricoClinicoSeguimientoController@obtenerListadoHistoricosClinicos')->name('obtener-lista-historicos-clinicos');
    });
  });

  Route::prefix('reportes')->group(function () {
    Route::get('/recetas', 'App\Http\Controllers\pages\reportes\ReportesController@recetas')->name('reporte-recetas');
    Route::get('/pacientes', 'App\Http\Controllers\pages\reportes\ReportesController@pacientes')->name('reporte-pacientes');
    Route::get('/consultas', 'App\Http\Controllers\pages\reportes\ReportesController@consultas')->name('reporte-consultas');

    # ****************************************************************************************
    # ****************************************************************************************

    Route::prefix('api')->group(function () {
      Route::post('/recetas/exportar', 'App\Http\Controllers\pages\reportes\ReportesDescargaController@exportarRecetas');
      Route::post('/pacientes/exportar', 'App\Http\Controllers\pages\reportes\ReportesDescargaController@exportarPacientes');
      Route::post('/consultas/exportar', 'App\Http\Controllers\pages\reportes\ReportesDescargaController@exportarConsultas');
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
