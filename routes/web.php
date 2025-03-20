<?php

use Illuminate\Support\Facades\Route;

# Ruta para pagina principal.
Route::get('/', 'App\Http\Controllers\pages\InicioController@index')->name('pantalla-inicio');

# Grupo de rutas para pacientes.
Route::prefix('pacientes')->group(function () {

  # Ruta para vista de un nuevo paciente
  Route::get('/nuevo', 'App\Http\Controllers\pages\PacientesController@nuevoPaciente')->name('nuevo-paciente');

  # Ruta para registrar datos en el expediente
  Route::get('/registrar-valoracion', 'App\Http\Controllers\pages\PacientesController@registrarValoracionPaciente')->name('registrar-valoracion-paciente');

  # Ruta para ver los pacientes en lista
  Route::get('/consultar', 'App\Http\Controllers\pages\PacientesSeguimientoController@listadoPacientes')->name('listado-paciente');



  # Grupo de rutas para APIS de pacientes.
  Route::prefix('api')->group(function () {

    # Ruta para consultar paciente \ busca el empleado en el APSI
    Route::post('/consultar', 'App\Http\Controllers\pages\PacientesController@consultarPacienteApsi')->name('consultar-paciente');

    # Ruta para registrar el paciente
    Route::post('/registrar', 'App\Http\Controllers\pages\PacientesController@registrarPaciente')->name('registrar-paciente');

    # Ruta para registrar la valoracion el paciente
    Route::post('/guardar-valoracion', 'App\Http\Controllers\pages\PacientesController@guardarValoracionPaciente')->name('guardar-valoracion-paciente');

    # Ruta para obtener el listado de pacientes
    Route::post('/obtener-lista-pacientes', 'App\Http\Controllers\pages\PacientesSeguimientoController@obtenerListadoPacientes')->name('obtener-lista-pacientes');

  });



});
