<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as LaravelAuthenticatable;

class UsuarioModel extends Model implements Authenticatable
{
    use HasFactory, LaravelAuthenticatable, Notifiable;

    protected $connection = 'pgsql';
    protected $fillable = [
        'id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'password',
    ];

    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at', 'borrado'];
    protected $table = 'usuario';
    public $timestamps = true;

    public function usuario()
    {
      return $this->belongsTo(User::class, 'elaborado_por_usuario_id');
    }
}
