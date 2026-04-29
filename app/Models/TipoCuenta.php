<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCuenta extends Model
{
    use HasFactory;
    protected $fillable = [
    'nombre',
    'saldo_minimo',
    'comision_manejo',
    'limite_retiro'
    ];
    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }
}
