<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
{
    $this->middleware('permiso:ver_clientes')->only(['index', 'show']);
    $this->middleware('permiso:crear_clientes')->only(['create', 'store']);
    $this->middleware('permiso:editar_clientes')->only(['edit', 'update']);
    $this->middleware('permiso:eliminar_clientes')->only(['destroy']);
}
    
        // 🔹 LISTAR
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    // 🔹 FORMULARIO CREAR
    public function create()
    {
        $empleados = Empleado::whereNull('user_id')->get();
        $roles = Rol::all();

        return view('usuarios.create', compact('empleados', 'roles'));
    }

    // 🔹 GUARDAR
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol_id' => 'required|exists:roles,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id
        ]);

        // vincular empleado SOLO si viene
if ($request->empleado_id) {
    $empleado = Empleado::find($request->empleado_id);

    if ($empleado) {
        $empleado->user_id = $user->id;
        $empleado->save();
    }
}

        return redirect()->route('usuarios.index');
    }
    }
    
