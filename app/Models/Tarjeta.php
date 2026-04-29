<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    use HasFactory;
    protected $fillable = [
    'numero_tarjeta',
    'tipo',
    'fecha_emision',
    'fecha_vencimiento',
    'pin_hash',
    'estatus',
    'cuenta_id'
    ];
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }
}
