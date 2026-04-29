<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPrestamo extends Model
{
    use HasFactory;
    protected $fillable = [
    'monto_solicitado',
    'plazo',
    'ingresos_mensuales',
    'fecha_solicitud',
    'estado',
    'observaciones',
    'cliente_id'
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
