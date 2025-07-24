<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PacienteDatosConsultaNotaModel extends Model
{
  use HasFactory;

  protected $connection = 'pgsql';
  protected $fillable = ['id'];
  protected $hidden = ['updated_at', 'borrado'];
  protected $table = 'paciente_datos_consulta_nota';
  public $timestamps = true;

  protected function asDateTime($value)
  {
    return parent::asDateTime($value)->setTimezone(config('app.timezone'));
  }

  public function getDateFormat()
  {
    return 'Y-m-d H:i:s.u';
  }

  protected $casts = [
      'created_at' => 'datetime:Y-m-d H:i:s',
      'updated_at' => 'datetime:Y-m-d H:i:s',
  ];
}
