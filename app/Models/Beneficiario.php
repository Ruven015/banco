<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    use HasFactory;
    protected $fillable = [
    'nombre',
    'banco',
    'numero_cuenta',
    'estatus',
    'cliente_id'
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
