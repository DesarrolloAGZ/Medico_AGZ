<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empleado;

class PacientesController extends Controller
{
  public function nuevoPaciente()
  {
    return view('content.pages.nuevo-paciente');
  }

  public function consultarPaciente(Request $request)
  {
      $filtros = $request->input('filtro', []);
      $pacientes = Empleado::query();

      // Aplica los filtros si existen
      $pacientes->when(isset($filtros['paciente_numero_gafete']), function ($query) use ($filtros) {
          return $query->where('codigo', $filtros['paciente_numero_gafete']);
      });
      $pacientes->when(isset($filtros['paciente_nombre']), function ($query) use ($filtros) {
          return $query->where('nombre', 'like', '%' . $filtros['paciente_nombre'] . '%');
      });
      $pacientes->when(isset($filtros['paciente_apellido_paterno']), function ($query) use ($filtros) {
          return $query->where('ap_paterno', 'like', '%' . $filtros['paciente_apellido_paterno'] . '%');
      });
      $pacientes->when(isset($filtros['paciente_apellido_materno']), function ($query) use ($filtros) {
          return $query->where('ap_materno', 'like', '%' . $filtros['paciente_apellido_materno'] . '%');
      });

      // Obtén los resultados de la consulta
      $pacientes = $pacientes->get();

      // Retorna los resultados en formato JSON
      return response()->json($pacientes);
  }

}
