<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Sucursal;
use App\Models\User;

class EmpleadoController extends Controller
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
        $empleados = Empleado::with(['user', 'sucursal'])->get();
    return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $sucursales = Sucursal::all();
    $usuarios = User::doesntHave('empleado')->get();

    return view('empleados.create', compact('sucursales', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Empleado::create([
        'nombre' => $request->nombre,
        'apellidos' => $request->apellidos,
        'puesto' => $request->puesto,
        'estatus' => 'activo',
        'user_id' => $request->user_id,
        'sucursal_id' => $request->sucursal_id
    ]);

    return redirect()->route('empleados.index');
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
        $empleado = Empleado::findOrFail($id);
    $sucursales = Sucursal::all();
    $usuarios = User::all();

    return view('empleados.edit', compact('empleado', 'sucursales', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $emp = Empleado::findOrFail($id);
    $emp->update($request->all());

    if ($request->has('user_id')) {
        $emp->user_id = $request->user_id ?: null;
        $emp->save();
    }


    return redirect()->route('empleados.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $emp = Empleado::findOrFail($id);
    $emp->delete();

    return redirect()->route('empleados.index');
    }
}
