<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Notificacion extends Model
{
    use HasFactory;
    
    protected $table = 'notificaciones';
    protected $attributes = [
    'leida' => false,
    ];
    protected $fillable = [
        'tipo',
        'mensaje',
        'fecha_hora',
        'leida',
        'cliente_id'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}