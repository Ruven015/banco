<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    use HasFactory;
        protected $fillable = [
        'numero_cuenta',
        'saldo',
        'fecha_apertura',
        'estatus',
        'cliente_id',
        'tipo_cuenta_id',
        'sucursal_id'
        ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tipoCuenta()
    {
        return $this->belongsTo(TipoCuenta::class);
    }
    public function transaccionesOrigen()
    {
        return $this->hasMany(Transaccion::class, 'cuenta_origen_id');
    }

    public function transaccionesDestino()
    {
        return $this->hasMany(Transaccion::class, 'cuenta_destino_id');
    }
    public function tarjetas()
    {
        return $this->hasMany(Tarjeta::class);
    }
    public function pagos()
    {
        return $this->hasMany(PagoServicio::class);
    }
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
    
}
