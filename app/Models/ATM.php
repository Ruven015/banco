<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ATM extends Model
{
    use HasFactory;
    protected $table = 'atms';
    protected $fillable = [
    'codigo_atm',
    'ubicacion',
    'efectivo_disponible',
    'estatus',
    'sucursal_id'
    ];
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}
