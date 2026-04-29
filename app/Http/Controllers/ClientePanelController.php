<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use App\Models\Cuenta;
use Illuminate\Support\Facades\DB;
use App\Models\Notificacion;
use App\Models\Cliente;

class ClientePanelController extends Controller
{
    public function verCuenta($id)
{
    $cliente = auth()->user()->cliente;

    $cuenta = Cuenta::findOrFail($id);

    // 🔒 seguridad
    if ($cuenta->cliente_id != $cliente->id) {
        abort(403, 'No puedes ver esta cuenta');
    }

    // 🔍 consulta base
    $query = Transaccion::where(function ($q) use ($cuenta) {
        $q->where('cuenta_origen_id', $cuenta->id)
          ->orWhere('cuenta_destino_id', $cuenta->id);
    });

    // 🔍 filtros
    if (request('desde')) {
        $query->whereDate('fecha_hora', '>=', request('desde'));
    }

    if (request('hasta')) {
        $query->whereDate('fecha_hora', '<=', request('hasta'));
    }

    // 🔁 traer en DESC (más reciente primero)
    $transacciones = $query
        ->orderBy('fecha_hora', 'desc')
        ->get();

    // 🔥 SALDO REAL
    $saldo = $cuenta->saldo;

foreach ($transacciones as $t) {

    $tipo = strtolower($t->tipo);

    // 🔥 1. definir tipo PRIMERO
    if ($tipo === 'deposito') {
        $t->tipo_movimiento = 'ingreso';

    } elseif ($tipo === 'retiro') {
        $t->tipo_movimiento = 'egreso';

    } elseif ($tipo === 'transferencia') {

        if ($t->cuenta_destino_id == $cuenta->id) {
            $t->tipo_movimiento = 'ingreso';
        } else {
            $t->tipo_movimiento = 'egreso';
        }
    }

    // 🔥 2. asignar saldo
    $t->saldo_acumulado = $saldo;

    // 🔥 3. ajustar saldo
    if ($t->tipo_movimiento === 'ingreso') {
        $saldo -= $t->monto;
    } else {
        $saldo += $t->monto;
    }
}


    return view('cliente.cuenta', compact('cuenta', 'transacciones'));
}

    public function comprobante($id)
{
    $transaccion = Transaccion::findOrFail($id);

    $cuentaOrigen = Cuenta::find($transaccion->cuenta_origen_id);
    $cuentaDestino = Cuenta::find($transaccion->cuenta_destino_id);

    return view('cliente.comprobante', compact(
        'transaccion',
        'cuentaOrigen',
        'cuentaDestino'
    ));
}
   public function transferir(Request $request)
{
        
    // 🔹 Validación de entrada
    $request->validate([
        'cuenta_origen_id' => 'required|exists:cuentas,id',
        'numero_cuenta_destino' => 'required',
        'monto' => 'required|numeric|min:1'
    ]);

    $cliente = auth()->user()->cliente;

    // 🔹 Obtener cuentas
    $cuentaOrigen = Cuenta::findOrFail($request->cuenta_origen_id);

    $cuentaDestino = Cuenta::where('numero_cuenta', $request->numero_cuenta_destino)->first();

    if (!$cuentaDestino) {
        return back()->withErrors(['monto' => 'Cuenta destino no existe']);
    }

    $monto = $request->monto;

    // 🔒 Validar propiedad
    if ($cuentaOrigen->cliente_id != $cliente->id) {
        abort(403, 'No puedes usar esta cuenta');
    }

    // ❌ misma cuenta
    if ($cuentaOrigen->id === $cuentaDestino->id) {
        return back()->withErrors(['monto' => 'No puedes transferirte a la misma cuenta']);
    }

    // ❌ cuenta destino inactiva
    if ($cuentaDestino->estatus != 1) {
        return back()->withErrors(['monto' => 'Cuenta destino no disponible']);
    }

    // 💰 saldo
    if ($cuentaOrigen->saldo < $monto) {
        return back()->withErrors(['monto' => 'Saldo insuficiente']);
    }

    // 🔁 transacción segura
$transaccion = null;

DB::transaction(function () use ($cuentaOrigen, $cuentaDestino, $monto, &$transaccion, $cliente) {

    $cuentaOrigen->saldo -= $monto;
    $cuentaOrigen->save();

    $cuentaDestino->saldo += $monto;
    $cuentaDestino->save();

    $transaccion = Transaccion::create([
        'tipo' => 'transferencia',
        'monto' => $monto,
        'fecha_hora' => now(),
        'descripcion' => 'Transferencia cliente',
        'canal' => 'web',
        'estado' => 'completado',
        'cuenta_origen_id' => $cuentaOrigen->id,
        'cuenta_destino_id' => $cuentaDestino->id
    ]);
    // 📤 NOTIFICACIÓN PARA QUIEN ENVÍA
Notificacion::create([
    'tipo' => 'transferencia_envio',
    'mensaje' => 'Transferiste $' . number_format($monto, 2),
    'fecha_hora' => now(),
    'leida' => false,
    'cliente_id' => $cliente->id
]);

// 🔍 buscar cliente destino
$clienteDestino = $cuentaDestino->cliente;

// 📥 NOTIFICACIÓN PARA QUIEN RECIBE
if ($clienteDestino && $clienteDestino->id != $cliente->id) {
    Notificacion::create([
        'tipo' => 'transferencia_recibo',
        'mensaje' => 'Recibiste $' . number_format($monto, 2),
        'fecha_hora' => now(),
        'leida' => false,
        'cliente_id' => $clienteDestino->id
    ]);
}
});

    return redirect()->route('cliente.comprobante', $transaccion->id);
}

public function depositar(Request $request)
{
    $request->validate([
        'cuenta_id' => 'required|exists:cuentas,id',
        'monto' => 'required|numeric|min:1'
    ]);

    $cliente = auth()->user()->cliente;

    $cuenta = Cuenta::findOrFail($request->cuenta_id);

    if ($cuenta->cliente_id != $cliente->id) {
        abort(403);
    }

    $monto = $request->monto;

    DB::transaction(function () use ($cuenta, $monto) {

        $cuenta->saldo += $monto;
        $cuenta->save();

        Transaccion::create([
            'tipo' => 'deposito',
            'monto' => $monto,
            'fecha_hora' => now(),
            'descripcion' => 'Depósito',
            'canal' => 'web',
            'estado' => 'completado',
            'cuenta_origen_id' => $cuenta->id,
            'cuenta_destino_id' => $cuenta->id
        ]);
        Notificacion::create([
            'tipo' => 'deposito',
            'mensaje' => 'Depósito de $' . number_format($monto, 2),
            'fecha_hora' => now(),
            'leida' => false,
            'cliente_id' => $cuenta->cliente_id
        ]);
    });

    return back()->with('success', 'Depósito realizado');
}

public function retirar(Request $request)
{
    $request->validate([
        'cuenta_id' => 'required|exists:cuentas,id',
        'monto' => 'required|numeric|min:1'
    ]);

    $cliente = auth()->user()->cliente;

    $cuenta = Cuenta::findOrFail($request->cuenta_id);

    if ($cuenta->cliente_id != $cliente->id) {
        abort(403);
    }

    $monto = $request->monto;

    if ($cuenta->saldo < $monto) {
        return back()->withErrors(['monto' => 'Saldo insuficiente']);
    }

    DB::transaction(function () use ($cuenta, $monto) {

        $cuenta->saldo -= $monto;
        $cuenta->save();

        Transaccion::create([
            'tipo' => 'retiro',
            'monto' => $monto,
            'fecha_hora' => now(),
            'descripcion' => 'Retiro',
            'canal' => 'web',
            'estado' => 'completado',
            'cuenta_origen_id' => $cuenta->id,
            'cuenta_origen_id' => $cuenta->id
        ]);
        Notificacion::create([
            'tipo' => 'retiro',
            'mensaje' => 'Retiro de $' . number_format($monto, 2),
            'fecha_hora' => now(),
            'leida' => false,
            'cliente_id' => $cuenta->cliente_id
           
        ]);
    });

    return back()->with('success', 'Retiro realizado');
}
    public function index()
{
    $cliente = auth()->user()->cliente;

    // ⚠️ Seguridad
    if (!$cliente) {
        abort(403, 'No tienes cliente asignado');
    }

    $cuentas = $cliente->cuentas;
    $cuentasIds = $cuentas->pluck('id');

    // 🔥 TRAER transacciones (origen + destino)
    $transacciones = Transaccion::where(function ($q) use ($cuentasIds) {
        $q->whereIn('cuenta_origen_id', $cuentasIds)
          ->orWhereIn('cuenta_destino_id', $cuentasIds);
    })
    ->orderBy('fecha_hora', 'desc')
    ->take(5)
    ->get();

    // 🔥 CALCULAR tipo_movimiento
    foreach ($transacciones as $t) {

        $tipo = strtolower($t->tipo);

        if ($tipo === 'deposito') {
            $t->tipo_movimiento = 'ingreso';

        } elseif ($tipo === 'retiro') {
            $t->tipo_movimiento = 'egreso';

        } elseif ($tipo === 'transferencia') {

            if (in_array($t->cuenta_destino_id, $cuentasIds->toArray())) {
                $t->tipo_movimiento = 'ingreso';
            } else {
                $t->tipo_movimiento = 'egreso';
            }
        }
    }

    return view('cliente.dashboard', compact(
        'cliente',
        'cuentas',
        'transacciones'
    ));
}
}