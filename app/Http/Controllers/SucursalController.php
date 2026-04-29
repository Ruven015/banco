<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sucursal;

class SucursalController extends Controller
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
         $sucursales = Sucursal::all();
    return view('sucursales.index', compact('sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('sucursales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Sucursal::create([
        'nombre' => $request->nombre,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'ciudad' => $request->ciudad,
        'estatus' => 'activa'
    ]);

    return redirect()->route('sucursales.index');
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
        $sucursal = Sucursal::findOrFail($id);
    return view('sucursales.edit', compact('sucursal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $sucursal = Sucursal::findOrFail($id);

    $sucursal->update($request->all());

    return redirect()->route('sucursales.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         $sucursal = Sucursal::findOrFail($id);
    $sucursal->delete();

    return redirect()->route('sucursales.index');
    }
}
