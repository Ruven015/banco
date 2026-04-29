<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $table = 'bitacoras';

    protected $fillable = [
        'accion',
        'tabla',
        'descripcion',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
