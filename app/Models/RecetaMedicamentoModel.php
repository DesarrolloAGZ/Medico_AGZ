<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RecetaMedicamentoModel extends Model
{
  use HasFactory;
  protected $connection = 'pgsql';
  protected $hidden = ['created_at', 'updated_at', 'borrado'];
  protected $table = 'receta_medicamento';
  public $timestamps = true;
}
