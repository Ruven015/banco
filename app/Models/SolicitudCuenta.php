<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCuenta extends Model
{
    use HasFactory;
    protected $fillable = [
    'tipo_cuenta',
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
