<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PacienteModel extends Model
{
  use HasFactory;
  protected $connection = 'pgsql';
  protected $fillable = [
      'id',
  ];
  protected $hidden = ['created_at', 'updated_at', 'borrado'];
  protected $table = 'paciente';
  public $timestamps = true;

  public function pacienteDatosConsulta()
  {
    return $this->hasMany(PacienteDatosConsultaModel::class, 'paciente_id')->where('borrado', 0);
  }

  public function recetas()
  {
    return $this->hasMany(RecetaModel::class, 'paciente_id', 'id')->where('borrado', 0)->select('id'); ;
  }

}
