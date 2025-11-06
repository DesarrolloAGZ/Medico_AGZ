<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioAlmacenModel extends Model
{
  use HasFactory;
  protected $connection = 'pgsql';
  protected $hidden = ['created_at', 'updated_at', 'borrado'];
  protected $table = 'usuario_almacen_rvd';
  public $timestamps = true;
}
