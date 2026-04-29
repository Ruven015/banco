<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    //
  public function index()
{
    $cliente = auth()->user()->cliente;

    // 🔥 marcar como leídas
    $cliente->notificaciones()->update(['leida' => true]);

    // 📄 obtener notificaciones
    $notificaciones = $cliente->notificaciones()
        ->latest()
        ->get();

    return view('notificaciones.index', compact('notificaciones'));
}



}
