<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioPerfilModel extends Model
{
  use HasFactory;
  protected $connection = 'pgsql';
  protected $hidden = ['created_at', 'updated_at', 'borrado'];
  protected $table = 'usuario_perfil';
  public $timestamps = true;
}
