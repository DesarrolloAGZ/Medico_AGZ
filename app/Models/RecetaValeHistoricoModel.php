<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecetaValeHistoricoModel extends Model
{
  use HasFactory;
  protected $connection = 'pgsql';
  protected $hidden = ['created_at', 'updated_at', 'borrado'];
  protected $table = 'receta_vale_historico';
  public $timestamps = true;
}
