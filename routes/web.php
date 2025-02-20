<?php

use Illuminate\Support\Facades\Route;

# Ruta para pagina principal.
Route::get('/', 'App\Http\Controllers\pages\InicioController@index')->name('pantalla-inicio');

# Grupo de rutas para pacientes.
Route::prefix('pacientes')->group(function () {
  Route::post('/consultar', 'App\Http\Controllers\pages\PacientesController@consultarPaciente')->name('consultar-paciente');
  Route::get('/nuevo', 'App\Http\Controllers\pages\PacientesController@nuevoPaciente')->name('nuevo-paciente');
});
