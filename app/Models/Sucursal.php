<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = 'sucursales';
    protected $fillable = [
    'nombre',
    'direccion',
    'telefono',
    'ciudad',
    'estatus'
    ];
    public function atms()
    {
        return $this->hasMany(ATM::class);
    }
    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }
    public function empleados()
{
    return $this->hasMany(Empleado::class);
}
}
