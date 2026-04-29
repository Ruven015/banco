<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Bitacora;

class ClienteController extends Controller
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
        $clientes = Cliente::all();
    return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('clientes.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       $cliente =  Cliente::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'curp' => $request->curp,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estatus' => $request->estatus ?? 0
        ]);
        Bitacora::create([
            'accion' => 'crear',
            'tabla' => 'clientes',
            'descripcion' => 'Cliente creado: ' . $cliente->id,
            'user_id' => null
        ]);

        return redirect()->route('clientes.index');
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
        $cliente = Cliente::findOrFail($id);
    return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $cliente = Cliente::findOrFail($id);

    $cliente->update([
        'nombre' => $request->nombre,
        'apellido_paterno' => $request->apellido_paterno,
        'apellido_materno' => $request->apellido_materno,
        'curp' => $request->curp,
        'correo' => $request->correo,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'fecha_nacimiento' => $request->fecha_nacimiento,
        'estatus' => $request->estatus ?? 0
    ]);

    return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index');
    }
}
