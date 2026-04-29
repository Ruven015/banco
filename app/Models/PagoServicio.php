<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoServicio extends Model
{
    use HasFactory;
    protected $fillable = [
    'servicio',
    'referencia',
    'monto',
    'fecha_hora',
    'estatus',
    'cuenta_id'
    ];
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }
}
