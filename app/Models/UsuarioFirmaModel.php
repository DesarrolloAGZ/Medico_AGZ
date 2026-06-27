<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioFirmaModel extends Model
{
  use HasFactory;

  protected $connection = 'pgsql';
  protected $table = 'usuario_firma';
  public $timestamps = true;

  protected $hidden = ['created_at', 'updated_at', 'borrado'];

  protected $fillable = [
    'usuario_id',
    'firma'
  ];
}
