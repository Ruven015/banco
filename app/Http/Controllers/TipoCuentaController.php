<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoCuenta;

class TipoCuentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tipos = TipoCuenta::all();
    return view('tipo_cuentas.index', compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
         return view('tipo_cuentas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         TipoCuenta::create($request->all());
    return redirect()->route('tipo-cuentas.index');
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
        $tipo = TipoCuenta::findOrFail($id);
    return view('tipo_cuentas.edit', compact('tipo'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $tipo = TipoCuenta::findOrFail($id);
    $tipo->update($request->all());

    return redirect()->route('tipo-cuentas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tipo = TipoCuenta::findOrFail($id);
    $tipo->delete();

    return redirect()->route('tipo-cuentas.index');
    }
}
