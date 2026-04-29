<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use App\Models\Cuenta;
use App\Models\Bitacora;
use Illuminate\Support\Facades\DB;
use App\Models\Notificacion;


class TransaccionController extends Controller
{
    //
    public function __construct()
{
    $this->middleware('permiso:realizar_transacciones')->only(['create', 'store']);
}
    public function index()
{
    $transacciones = Transaccion::with(['cuentaOrigen', 'cuentaDestino'])->get();
    return view('transacciones.index', compact('transacciones'));
}
public function create()
{
    $cuentas = Cuenta::all();
    return view('transacciones.create', compact('cuentas'));
}


public function store(Request $request)
{
    // 🔥 1. VALIDACIÓN
    $request->validate([
        'tipo' => 'required|in:deposito,retiro,transferencia',
        'monto' => 'required|numeric|min:1',
        'cuenta_origen_id' => 'required|exists:cuentas,id',
        'cuenta_destino_id' => 'nullable|exists:cuentas,id'
    ]);

    // 🔥 2. REGLAS DE NEGOCIO
    if ($request->tipo === 'transferencia') {

        if (!$request->cuenta_destino_id) {
            return back()->withErrors([
                'cuenta_destino_id' => 'La cuenta destino es obligatoria en transferencias'
            ]);
        }

        if ($request->cuenta_origen_id == $request->cuenta_destino_id) {
            return back()->withErrors([
                'cuenta_destino_id' => 'No puedes transferir a la misma cuenta'
            ]);
        }
    }

    try {

        DB::transaction(function () use ($request) {

            $tipo = $request->tipo;
            $monto = $request->monto;

            $cuentaOrigen = Cuenta::lockForUpdate()->findOrFail($request->cuenta_origen_id);
            $cuentaDestino = $request->cuenta_destino_id
                ? Cuenta::lockForUpdate()->findOrFail($request->cuenta_destino_id)
                : null;

            // 🔴 DEPÓSITO
            if ($tipo === 'deposito') {

                $cuentaOrigen->saldo += $monto;
                $cuentaOrigen->save();

                $transaccion = Transaccion::create([
                    'tipo' => 'deposito',
                    'monto' => $monto,
                    'fecha_hora' => now(),
                    'canal' => 'sistema',
                    'estado' => 'completado',
                    
                    
                    'cuenta_origen_id' => $cuentaOrigen->id
                ]);

                Bitacora::create([
                    'accion' => 'deposito',
                    'tabla' => 'transacciones',
                    'descripcion' => 'Depósito de $' . $monto .
                        ' a cuenta ' . $cuentaOrigen->numero_cuenta .
                        ' (TX: ' . $transaccion->id . ')',
                    'user_id' => auth()->id()
                ]);
                Notificacion::create([
                    'tipo' => 'deposito',
                    'mensaje' => 'Depósito de $' . number_format($monto, 2),
                    'leida' => false,
                    'fecha_hora' => now(),
                    'cliente_id' => $cuentaOrigen->cliente_id
                ]);
            }

            // 🔴 RETIRO
            elseif ($tipo === 'retiro') {

                if ($cuentaOrigen->saldo < $monto) {
                    throw new \Exception('Saldo insuficiente');
                }

                $cuentaOrigen->saldo -= $monto;
                $cuentaOrigen->save();

                $transaccion = Transaccion::create([
                    'tipo' => 'retiro',
                    'monto' => $monto,
                    'fecha_hora' => now(),
                    'canal' => 'sistema',
                    'estado' => 'completado',
                    'cuenta_origen_id' => $cuentaOrigen->id,
                    'cuenta_destino_id' => null
                ]);

                Bitacora::create([
                    'accion' => 'retiro',
                    'tabla' => 'transacciones',
                    'descripcion' => 'Retiro de $' . $monto .
                        ' de cuenta ' . $cuentaOrigen->numero_cuenta .
                        ' (TX: ' . $transaccion->id . ')',
                    'user_id' => auth()->id()
                ]);
                Notificacion::create([
                    'tipo' => 'retiro',
                    'mensaje' => 'Has retirado $' . number_format($monto, 2),
                    'leida' => false,
                    'fecha_hora' => now(),
                    'cliente_id' => $cuentaOrigen->cliente_id
                ]);
            }

            // 🔴 TRANSFERENCIA
            elseif ($tipo === 'transferencia') {

                if ($cuentaOrigen->saldo < $monto) {
                    throw new \Exception('Saldo insuficiente');
                }

                // movimiento
                $cuentaOrigen->saldo -= $monto;
                $cuentaDestino->saldo += $monto;

                $cuentaOrigen->save();
                $cuentaDestino->save();

                $transaccion = Transaccion::create([
                    'tipo' => 'transferencia',
                    'monto' => $monto,
                    'fecha_hora' => now(),
                    'canal' => 'sistema',
                    'estado' => 'completado',
                    'cuenta_origen_id' => $cuentaOrigen->id,
                    'cuenta_destino_id' => $cuentaDestino->id
                ]);

                Bitacora::create([
                    'accion' => 'transferencia',
                    'tabla' => 'transacciones',
                    'descripcion' => 'Transferencia de $' . $monto .
                        ' de cuenta ' . $cuentaOrigen->numero_cuenta .
                        ' a cuenta ' . $cuentaDestino->numero_cuenta .
                        ' (TX: ' . $transaccion->id . ')',
                    'user_id' => auth()->id()
                ]);
                // origen
                Notificacion::create([
                    'tipo' => 'transferencia',
                    'mensaje' => 'Enviaste $' . $monto,
                    'fecha_hora' => now(),
                    'cliente_id' => $cuentaOrigen->cliente_id
                ]);

                // destino
                Notificacion::create([
                    'tipo' => 'transferencia',
                    'mensaje' => 'Recibiste $' . $monto,
                    'fecha_hora' => now(),
                    'cliente_id' => $cuentaDestino->cliente_id
                ]);
            }
        });

    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }

    return redirect('/transacciones')->with('success', 'Transacción realizada correctamente');
}
}
