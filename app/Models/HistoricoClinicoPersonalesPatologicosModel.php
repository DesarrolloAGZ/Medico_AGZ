<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HistoricoClinicoPersonalesPatologicosModel extends Model
{
  use HasFactory;
  protected $connection = 'pgsql';
  protected $fillable = [
      'id',
  ];
  protected $hidden = ['created_at', 'updated_at', 'borrado'];
  protected $table = 'historico_clinico_personales_patologicos';
  public $timestamps = true;
}
