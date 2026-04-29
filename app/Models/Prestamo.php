<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $fillable = [
    'monto',
    'tasa_interes',
    'plazo_meses',
    'fecha_solicitud',
    'fecha_aprobacion',
    'saldo_pendiente',
    'estado',
    'cliente_id',
    'empleado_id'
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
