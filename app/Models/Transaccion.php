<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;
    protected $table = 'transacciones';
    protected $fillable = [
    'tipo',
    'monto',
    'fecha_hora',
    'descripcion',
    'canal',
    'referencia',
    'estado',
    'cuenta_origen_id',
    'cuenta_destino_id'
    ];
    public function cuentaOrigen()
{
    return $this->belongsTo(Cuenta::class, 'cuenta_origen_id');
}

public function cuentaDestino()
{
    return $this->belongsTo(Cuenta::class, 'cuenta_destino_id');
}
}
