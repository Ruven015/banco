<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;
use App\Models\Cliente;
use App\Models\TipoCuenta;
use App\Models\Sucursal;
use App\Models\Bitacora;

class CuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function __construct()
{
    $this->middleware('permiso:ver_clientes')->only(['index', 'show']);
    $this->middleware('permiso:crear_clientes')->only(['create', 'store']);
    $this->middleware('permiso:editar_clientes')->only(['edit', 'update']);
    $this->middleware('permiso:eliminar_clientes')->only(['destroy']);
}
    public function index()
    {
        //
        $cuentas = Cuenta::with(['cliente', 'tipoCuenta', 'sucursal'])->get();
    return view('cuentas.index', compact('cuentas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $clientes = Cliente::all();
    $tipos = TipoCuenta::all();
    $sucursales = Sucursal::all();

    return view('cuentas.create', compact('clientes', 'tipos', 'sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'numero_cuenta' => 'required|unique:cuentas,numero_cuenta',
            'saldo' => 'required|numeric|min:0',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_cuenta_id' => 'required|exists:tipo_cuentas,id',
            'sucursal_id' => 'required|exists:sucursales,id'
        ]);

        $cuenta = Cuenta::create([
    'numero_cuenta' => $request->numero_cuenta,
    'saldo' => $request->saldo,
    'fecha_apertura' => now(),
    'estatus' => true,
    'cliente_id' => $request->cliente_id,
    'tipo_cuenta_id' => $request->tipo_cuenta_id,
    'sucursal_id' => $request->sucursal_id
]);
Bitacora::create([
    'accion' => 'crear',
    'tabla' => 'cuentas',
    'descripcion' => 'Cuenta creada: ' . $cuenta->numero_cuenta,
    'user_id' => null
]);

    return redirect()->route('cuentas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $cuenta = Cuenta::findOrFail($id);

    $clientes = Cliente::all();
    $tipos = TipoCuenta::all();
    $sucursales = Sucursal::all();

    return view('cuentas.edit', compact('cuenta', 'clientes', 'tipos', 'sucursales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $cuenta = Cuenta::findOrFail($id);

    $cuenta->update([
        'numero_cuenta' => $request->numero_cuenta,
        'saldo' => $request->saldo,
        'cliente_id' => $request->cliente_id,
        'tipo_cuenta_id' => $request->tipo_cuenta_id,
        'sucursal_id' => $request->sucursal_id
    ]);

    return redirect()->route('cuentas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
       $cuenta = Cuenta::findOrFail($id);

    $cuenta->update([
        'estatus' => false
    ]);

    return redirect()->route('cuentas.index');
    }
}
