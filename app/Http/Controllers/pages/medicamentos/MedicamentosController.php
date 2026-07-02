<?php

namespace App\Http\Controllers\pages\medicamentos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UsuarioAlmacenModel;
use Illuminate\Support\Facades\Storage;


class MedicamentosController extends Controller
{
  public function existencias(Request $request)
  {
    if (Auth::user()->usuario_perfil_id == 7) {

      $usuario_almacenes = UsuarioAlmacenModel::select('empresa_id', 'empresa_nombre', 'almacen_id', 'almacen_nombre', 'almacen_codigo')->where('usuario_id', Auth::user()->id)->where('borrado', 0)->get()->toArray();
      $view_data['usuario_almacenes'] = $usuario_almacenes;

      return view('content.pages.medicamentos.existencias', ['datos_vista' => $view_data]);
    } else {
      return view('content.pages.pages-misc-error');
    }
  }
}
