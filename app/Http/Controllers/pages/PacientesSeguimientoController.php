<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\PacienteModel;

class PacientesSeguimientoController extends Controller
{
  public function listadoPacientes(){
    return view('content.pages.listado-pacientes');
  }

  public function obtenerListadoPacientes(Request $request){
    $paciente = PacienteModel::select(
      'paciente.id',
      'paciente.gafete',
      'paciente.nombre',
      'paciente.apellido_paterno',
      'paciente.apellido_materno',
      'paciente.edad',
      'paciente.curp',
      'paciente.celular'
    )
    ->where('paciente.borrado', 0)
    ->groupBy('paciente.id', 'paciente.nombre', 'paciente.apellido_paterno', 'paciente.apellido_materno', 'paciente.edad', 'paciente.curp', 'paciente.celular')
    ->orderBy('paciente.nombre', 'asc');

    return DataTables::eloquent($paciente)
    // filtrar por nombre sin importar mayusculas y minusculas
    ->filter(function ($query) use ($request) {
      // buscar en tramite_detalle search[value]
      if (request()->has('search')) {
        if (request()->input('search.value')) {
          $search = strtolower($request->input('search.value'));
          $query->whereRaw('LOWER(paciente.nombre) LIKE LOWER(\'%' . $search . '%\')');
        }
      }
    })
    ->addColumn('acciones', function ($air) {
      $botones = '';

      $botones .= '<button  class="btn btn-icon rounded-pill btn-success waves-effect waves-light m-1" title="Ver expediente" onclick="">' .
                      '<i class="mdi mdi-format-list-text mdi-20px"></i>' .
                  '</button>';

      $botones .= '<a  class="btn btn-icon rounded-pill btn-success waves-effect waves-light m-1" title="Valorar paciente" href="/pacientes/nuevo">' .
                    '<i class="mdi mdi-medical-cotton-swab mdi-20px"></i>' .
                  '</a>';

      return $botones;
    })
    ->rawColumns(['acciones'])
    // ordenar por tramite.id de forma descendente
    ->make(true);
  }
}
