<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $fillable = [
    'nombre',
    'apellidos',
    'puesto',
    'estatus',
    'user_id',
    'sucursal_id'
    ];
   public function user()
{
    return $this->belongsTo(User::class);
}

public function sucursal()
{
    return $this->belongsTo(Sucursal::class);
}
public function prestamos()
{
    return $this->hasMany(Prestamo::class);
}
}
