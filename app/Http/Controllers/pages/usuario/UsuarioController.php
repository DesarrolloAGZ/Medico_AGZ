<?php

namespace App\Http\Controllers\pages\usuario;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UsuarioFirmaModel;


class UsuarioController extends Controller
{
  public function firma()
  {
    return view('content.pages.usuario.firma');
  }

  public function guardarFirma(Request $request)
  {
    $result = [
      "error" => false,
      "msg" => null,
      "ruta" => null
    ];

    try {

      $usuario_id = Auth::user()->id;

      if (!$request->firma) {
        return response()->json([
          'error' => true,
          'msg' => 'No se recibió la firma'
        ], 400);
      }

      $firmaBase64 = $request->firma;

      // Limpiar base64
      $firma = str_replace('data:image/png;base64,', '', $firmaBase64);
      $firma = str_replace(' ', '+', $firma);

      $nombreArchivo = 'firma_' . $usuario_id . '_' . time() . '.png';
      $ruta = 'firmas/' . $nombreArchivo;

      // Guardar archivo
      $directorio = public_path('firmas');

      if (!file_exists($directorio)) {
        mkdir($directorio, 0755, true);
      }

      $nombreArchivo = 'firma_' . $usuario_id . '_' . time() . '.png';

      $path = $directorio . '/' . $nombreArchivo;

      file_put_contents($path, base64_decode($firma));

      $ruta = 'firmas/' . $nombreArchivo;

      // Guardar en BD
      $firmaUsuarioId = UsuarioFirmaModel::insertGetId([
        'usuario_id' => $usuario_id,
        'firma' => $ruta,
        'created_at' => now(),
        'updated_at' => now()
      ]);

      if (!$firmaUsuarioId) {
        return response()->json([
          'error' => true,
          'msg' => 'No fue posible guardar la firma en base de datos'
        ], 500);
      }

      $result['ruta'] = $ruta;
      $result['msg'] = 'Firma registrada correctamente';

      return response()->json($result);
    } catch (\Exception $e) {

      return response()->json([
        'error' => true,
        'msg' => 'Error al guardar firma',
        'detalle' => $e->getMessage()
      ], 500);
    }
  }
}
