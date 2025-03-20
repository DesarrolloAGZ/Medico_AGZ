<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PacienteModel;

class InicioController extends Controller
{
  public function index()
  {
    $view_data['pacientesHombres'] = PacienteModel::where('genero', 'M')->where('borrado', 0)->count();
    $view_data['pacientesMujeres'] = PacienteModel::where('genero', 'F')->where('borrado', 0)->count();

    return view('content.pages.inicio',['datos_vista' => $view_data]);
  }
}
