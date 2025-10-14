<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HistoricoClinicoModel extends Model
{
  use HasFactory;
  protected $connection = 'pgsql';
  protected $fillable = [
      'id',
  ];
  protected $hidden = ['created_at', 'updated_at', 'borrado'];
  protected $table = 'historico_clinico';
  public $timestamps = true;

  public function historicoClinicoGinecoObstetricos()
  {
    return $this->hasMany(HistoricoClinicoGinecoObstetricosModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoContactoEmergencia()
  {
    return $this->hasMany(HistoricoClinicoContactoEmergenciaModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoHeredofamiliares()
  {
    return $this->hasMany(HistoricoClinicoHeredofamiliaresModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoPersonalesNoPatologicos()
  {
    return $this->hasMany(HistoricoClinicoPersonalesNoPatologicosModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoPersonalesPatologicos()
  {
    return $this->hasMany(HistoricoClinicoPersonalesPatologicosModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoLaborales()
  {
    return $this->hasMany(HistoricoClinicoLaboralesModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoEmpleo()
  {
    return $this->hasMany(HistoricoClinicoEmpleoModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoAparatosSistemas()
  {
    return $this->hasMany(HistoricoClinicoAparatosSistemasModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoExploracionFisica()
  {
    return $this->hasMany(HistoricoClinicoExploracionFisicaModel::class, 'historico_clinico_id')->where('borrado', 0);
  }
  public function historicoClinicoDrogas()
  {
    return $this->hasMany(HistoricoClinicoDrogasModel::class, 'historico_clinico_id')->where('borrado', 0);
  }

}
