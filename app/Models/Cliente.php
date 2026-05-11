<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'curp',
        'telefono',
        'correo',
        'direccion',
        'fecha_nacimiento',
        'estatus'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }
    public function beneficiarios()
    {
        return $this->hasMany(Beneficiario::class);
    }
    public function solicitudesPrestamo()
    {
        return $this->hasMany(SolicitudPrestamo::class);
    }
    public function solicitudesCuenta()
    {
        return $this->hasMany(SolicitudCuenta::class);
    }
    
}
