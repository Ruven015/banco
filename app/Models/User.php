<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Empleado;
use App\Models\Bitacora;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Campos asignables
     */
    protected $fillable = [
        'name',
        'email',
        'password',
         'rol_id' // 🔸 lo dejamos comentado hasta usar roles
    ];

    /**
     * Campos ocultos
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relación 1 a 1 con empleado
     */
    public function empleado()
    {
        return $this->hasOne(Empleado::class);
    }

    /**
     * Relación con bitácora
     */
    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class);
    }

    /**
     * Relación con rol (PREPARADA, no obligatoria aún)
     */
    public function tienePermiso($permisoNombre)
    {
    if (!$this->rol) {
        return false;
    }

        return $this->rol
            ->permisos
            ->contains('nombre', $permisoNombre);
    }
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
    public function cliente()
        {
            return $this->hasOne(Cliente::class);
        }
}